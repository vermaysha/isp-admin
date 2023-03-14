<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ResellerType;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Client;
use App\Models\Reseller;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Vermaysha\Wilayah\Models\City;
use Vermaysha\Wilayah\Models\District;
use Vermaysha\Wilayah\Models\Province;
use Vermaysha\Wilayah\Models\Village;

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
        ])->withCount('clients')->where('type', ResellerType::INDIRECT)->latest();

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
        ])->where('id', $id)->where('type', ResellerType::INDIRECT)->firstOrFail();

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
            'email' => 'nullable|email:rfc,dns|unique:resellers,email',
            'phoneNumber' => 'nullable|numeric',
            'province' => [
                'required',
                Rule::exists((new Province())->getTable(), 'code'),
            ],
            'city' => [
                'required',
                Rule::exists((new City())->getTable(), 'code'),
            ],
            'district' => [
                'required',
                Rule::exists((new District())->getTable(), 'code'),
            ],
            'village' => [
                'required',
                Rule::exists((new Village())->getTable(), 'code'),
            ],
            'village_id' => [
                'required',
                Rule::exists((new Village())->getTable(), 'id'),
            ],
            'address_line' => 'nullable',
            'latitude' => 'required|between:-90,90',
            'longitude' => 'required|between:-180,180',
            'contractRangeDate' => 'required',
            'npwp' => 'required',
            'pks' => 'required',
            'logo' => 'nullable|file|image|max:1024',
            'contract_file' => 'required|file|max:1024|mimes:jpeg,bmp,png,pdf,eps',

            'owner_fullname' => 'required',
            'owner_username' => 'required|unique:users,username',
            'owner_email' => 'nullable|email:rfc,dns|unique:users,email',
            'owner_password' => 'required|confirmed',
            'owner_birth' => 'nullable|date',
            'owner_gender' => [
                'nullable',
                Rule::in([
                    'female',
                    'male',
                ]),
            ],
            'owner_province' => [
                'required',
                Rule::exists((new Province())->getTable(), 'code'),
            ],
            'owner_city' => [
                'required',
                Rule::exists((new City())->getTable(), 'code'),
            ],
            'owner_district' => [
                'required',
                Rule::exists((new District())->getTable(), 'code'),
            ],
            'owner_village' => [
                'required',
                Rule::exists((new Village())->getTable(), 'code'),
            ],
            'owner_village_id' => [
                'required',
                Rule::exists((new Village())->getTable(), 'id'),
            ],
            'owner_address_line' => 'nullable',
            'owner_latitude' => 'required|between:-90,90',
            'owner_longitude' => 'required|between:-180,180',
            'owner_photo_profile' => 'nullable|image|max:1024',
            'owner_photo_ktp' => 'required|image|max:1024',
        ]);

        $photoProfilePath = null;
        $photoKtpPath = null;
        $contractPath = null;
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

            if ($request->hasFile('contract_file')) {
                $contract = Image::make($request->file('contract_file'));
                $contract->fit($contract->width());

                $contractPath = Str::slug($request->input('name')) . time() . '.webp';

                Storage::disk('contracts')->put(
                    $contractPath,
                    $contract->encode('webp')
                );
            }

            if ($request->hasFile('owner_photo_profile')) {
                $photoProfile = Image::make($request->file('owner_photo_profile'));
                $photoProfile->fit($photoProfile->width());

                $photoProfilePath = 'images/profile/' . $request->input('owner_username') . '.webp';

                Storage::disk('public')->put(
                    $photoProfilePath,
                    $photoProfile->encode('webp')
                );
            }

            if ($request->hasFile('owner_photo_ktp')) {
                $photoKtp = Image::make($request->file('owner_photo_ktp'));

                $photoKtpPath = $request->input('owner_username') . '.webp';

                Storage::disk('ktp')->put(
                    $photoKtpPath,
                    $photoKtp->encode('webp')
                );
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }

        $contractRangeDate = explode(' to ', mb_strtolower($request->input('contractRangeDate')));

        if (count($contractRangeDate) < 2) {
            return redirect()->route('admin.resellerMenu.index')->withErrors([
                'contractRangeDate' => 'Tanggal kontrak tidak valid',
            ]);
        }

        DB::transaction(function () use ($request, $photoProfilePath, $logoPath, $photoKtpPath, $contractPath, $contractRangeDate) {
            $user = new User([
                'fullname' => $request->input('owner_fullname'),
                'username' => $request->input('owner_username'),
                'email' => $request->input('owner_email'),
                'password' => Hash::make($request->input('owner_password')),
                'birth' => $request->input('birth'),
                'gender' => $request->input('owner_gender'),
                'address' => $request->input('owner_address'),
                'photo' => $photoProfilePath ? 'storage/' . $photoProfilePath : null,
                'ktp_file' => $photoKtpPath,
            ]);

            $userAddress = new Address([
                'village_id' => $request->input('owner_village_id'),
                'address_line' => $request->input('owner_address_line'),
                'coordinates' => new Point($request->input('owner_latitude'), $request->input('owner_longitude')),
            ]);

            $userAddress->save();

            $user->address()->associate($userAddress);

            $user->save();

            $user->assignRole(Role::RESELLER_OWNER);

            $reseller = new Reseller([
                'name' => $request->input('name'),
                'photo' => $logoPath ? 'storage/' . $logoPath : null,
                'email' => $request->input('email'),
                'phone_number' => $request->input('phoneNumber'),
                'address_line' => $request->input('address_line'),
                'npwp' => $request->input('npwp'),
                'pks' => $request->input('pks'),
                'contract_file' => $contractPath,
                'contract_start_at' => $contractRangeDate[0],
                'contract_end_at' => $contractRangeDate[1],
            ]);

            $resellerAddress = new Address([
                'village_id' => $request->input('village_id'),
                'address_line' => $request->input('address_line'),
                'coordinates' => new Point($request->input('latitude'), $request->input('longitude')),
            ]);

            $resellerAddress->save();

            $reseller->address()->associate($resellerAddress);

            $user->reseller()->save($reseller);
        }, 5);

        return redirect()->route('admin.resellerMenu.index')->with('status', 'Mitra ' . $request->input('name') . ' Telah Ditambahkan');
    }
}
