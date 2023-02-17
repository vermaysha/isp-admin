<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Reseller;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Log;

class ResellerController extends Controller
{
    /**
     * Show all data of reseller
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $resellers = Reseller::with([
            'user:id,fullname',
        ])->withCount('clients')->latest();

        return view('pages.admin.reseller.index', [
            'title' => 'Reseller',
            'resellers' => $resellers->paginate(20)->appends($request->all()),
        ]);
    }

    /**
     * Show detail data of reseller
     *
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, string $id)
    {
        $reseller = Reseller::with([
            'user',
            'clients',
        ])->withCount([
            'clients',
            'clientPpns',
        ])->where('id', $id)->firstOrFail();

        $clients = Client::with([
            'user',
            'reseller',
            'plan',
        ])->where('reseller_id', $reseller->id)
            ->latest()->limit(10)->get();

        return view('pages.admin.reseller.detail', [
            'title' => 'Reseller: ' . $reseller->name,
            'reseller' => $reseller,
            'clients' => $clients,
        ]);
    }

    /**
     * Show create data form
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('pages.admin.reseller.create');
    }

    /**
     * Store data process
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'nullable|email:rfc,dns',
            'phoneNumber' => 'nullable|numeric',
            'address' => 'required',
            'contractStartDate' => 'required|date',
            'contractEndDate' => 'required|date|after:contractStartDate',
            'logo' => 'nullable|file|image|max:1024',

            'owner_fullname' => 'required',
            'owner_username' => 'required|unique:users,username',
            'owner_email' => 'nullable|email:rfc,dns',
            'owner_password' => 'required|confirmed',
            'owner_birth' => 'nullable|date',
            'owner_gender' => [
                'nullable',
                Rule::in([
                    'female',
                    'male',
                ]),
            ],
            'owner_address' => 'nullable',
            'owner_photo' => 'nullable|image|max:1024',
        ]);

        $photoPath = null;
        $logoPath = null;

        try {
            if ($request->hasFile('logo')) {
                $logo = Image::make($request->file('logo'));
                $logo->fit($logo->width());

                $logoPath = 'images/mitra/' . Str::slug($request->input('name')) . time() . '.webp';

                Storage::disk('public')->put(
                    $logoPath,
                    $logo->encode('webp')
                );
            }

            if ($request->hasFile('owner_photo')) {
                $photo = Image::make($request->file('owner_photo'));
                $photo->fit($photo->width());

                $photoPath = 'images/profile/' . $request->input('owner_username') . '.webp';

                Storage::disk('public')->put(
                    $photoPath,
                    $photo->encode('webp')
                );
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }

        DB::transaction(function () use ($request, $photoPath, $logoPath) {
            $user = new User([
                'fullname' => $request->input('owner_fullname'),
                'username' => $request->input('owner_username'),
                'email' => $request->input('owner_email'),
                'password' => Hash::make($request->input('owner_password')),
                'birth' => $request->input('birth'),
                'gender' => $request->input('owner_gender'),
                'address' => $request->input('owner_address'),
                'photo' => $photoPath ? 'storage/' . $photoPath : null,
            ]);

            $user->save();

            $user->assignRole(Role::RESELLER_OWNER);

            $reseller = new Reseller([
                'name' => $request->input('name'),
                'photo' => $logoPath ? 'storage/' . $logoPath : null,
                'email' => $request->input('email'),
                'phone_number' => $request->input('phoneNumber'),
                'address' => $request->input('address'),
                'contract_start_at' => $request->input('contractStartDate'),
                'contract_end_at' => $request->input('contractEndDate'),
            ]);

            $user->reseller()->save($reseller);
        }, 5);

        return redirect()->route('admin.resellerMenu.index')->with('status', 'Mitra ' . $request->input('name') . ' Telah Ditambahkan');
    }
}
