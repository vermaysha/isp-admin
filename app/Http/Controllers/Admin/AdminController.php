<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Throwable;
use Vermaysha\Wilayah\Models\City;
use Vermaysha\Wilayah\Models\District;
use Vermaysha\Wilayah\Models\Province;
use Vermaysha\Wilayah\Models\Village;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    /**
     * List of admin lists
     */
    public function index(Request $request): View|JsonResponse
    {
        $admins = Admin::with([
            'user',
        ]);

        if ($request->ajax() || $request->has('is_ajax')) {
            return DataTables::eloquent($admins)->toJson();
        }

        return view('pages.admin.admin.index', [
            'title' => 'Admin',
        ]);
    }

    /**
     * Detail admin
     */
    public function detail(Request $request, string $id): View
    {
        $admin = Admin::with('user')->findOrFail($id);

        return view('pages.admin.admin.detail', [
            'title' => 'Edit Admin: ' . $admin->user->fullname,
            'admin' => $admin,
        ]);
    }

    /**
     * Create admin form menu
     */
    public function create(Request $request): View
    {
        return view('pages.admin.admin.create', [
            'title' => 'Tambah admin',
        ]);
    }

    /**
     * Save data
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'fullname' => 'required',
            'username' => 'required|alpha_dash|regex:/^[A-Za-z0-9_]+$/|unique:users,username',
            'email' => 'nullable|email:rfc,dns|unique:users,email',
            'phone_number' => 'nullable|numeric',
            'password' => 'required|confirmed',
            'birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
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
            'photo' => 'nullable|image|max:1024',
            'office_location' => [
                'required',
                Rule::in(['Tangerang', 'Gresik', 'Solo']),
            ],
        ]);

        $photoPath = null;

        try {
            if ($request->hasFile('photo')) {
                $logo = Image::make($request->file('photo'));
                $logo->fit($logo->width());

                $photoPath = 'images/admin/' . Str::slug($request->input('name')) . time() . '.webp';

                Storage::disk('public')->put(
                    $photoPath,
                    $logo->encode('webp')
                );
            }
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());
        }

        try {
            DB::transaction(function () use ($request, $photoPath) {
                $user = new User([
                    'fullname' => $request->input('fullname'),
                    'username' => $request->input('username'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'birth' => $request->input('birth'),
                    'gender' => $request->input('gender'),
                    'phone_number' => $request->input('phone_number'),
                    'photo' => $photoPath ? 'storage/' . $photoPath : null,
                ]);

                $address = new Address([
                    'village_id' => $request->input('village_id'),
                    'address_line' => $request->input('address_line'),
                    'coordinates' => new Point($request->input('latitude'), $request->input('longitude')),
                ]);

                $address->save();

                $user->address()->associate($address);

                $user->save();
                $user->assignRole(Role::ADMIN);

                $user->client()->save(new Admin([
                    'office_location' => $request->input('office_location'),
                ]));
            }, 5);

            return redirect()
                ->route('admin.adminMenu.index')
                ->with('status', 'Pelanggan ' . $request->input('fullname') . ' Telah Ditambahkan');
        } catch (Throwable $e) {
            Log::critical($e->getMessage(), $e->getTrace());

            if ($photoPath) {
                Storage::delete($photoPath);
            }

            return abort(500, $e->getMessage());
        }
    }

    /**
     * Edit admin form
     */
    public function edit(Request $request, string $id): View
    {
        $admin = Admin::with('user')->findOrFail($id);

        return view('pages.admin.admin.edit', [
            'title' => 'Edit admin: ' . $admin->user->fullname,
            'admin' => $admin,
        ]);
    }

    /**
     * Update data
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $admin = Admin::with('user')->findOrFail($id);

        $this->validate($request, [
            'fullname' => 'nullable',
            'username' => [
                'nullable',
                'alpha_dash',
                'regex:/^[A-Za-z0-9_]+$/',
                Rule::unique('users', 'username')->ignore($admin->user_id),
            ],
            'email' => [
                'nullable',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($admin->user_id),
            ],
            'phone_number' => 'nullable|numeric',
            'password' => 'nullable|confirmed',
            'birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
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
            'photo' => 'nullable|image|max:1024',
            'office_location' => [
                'required',
                Rule::in(['Tangerang', 'Gresik', 'Solo']),
            ],
        ]);

        $photoPath = null;

        try {
            if ($request->hasFile('photo')) {
                $logo = Image::make($request->file('photo'));
                $logo->fit($logo->width());

                $photoPath = 'images/admin/' . Str::slug($request->input('name')) . time() . '.webp';

                Storage::disk('public')->put(
                    $photoPath,
                    $logo->encode('webp')
                );
            }
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());
        }

        try {
            DB::transaction(function () use ($request, $photoPath, $id) {
                $user = User::with('address')->whereHas('admin', function ($q) use ($id) {
                    $q->where('id', $id);
                })->first();

                $allowedInput = [
                    'fullname',
                    'username',
                    'email',
                    'phone_number',
                    'password',
                    'birth',
                    'gender',
                ];

                foreach ($allowedInput as $key) {
                    if ($request->has($key) && ! is_null($request->input($key))) {
                        $user->{$key} = $request->input($key);
                    }
                }

                if ($photoPath) {
                    $user->photo = $photoPath ? 'storage/' . $photoPath : null;
                }

                $user->address->update([
                    'village_id' => $request->input('village_id'),
                    'address_line' => $request->input('address_line'),
                    'coordinates' => new Point($request->input('latitude'), $request->input('longitude')),
                ]);

                $user->save();

                $user->admin()->update([
                    'office_location' => $request->input('office_location'),
                ]);
            }, 5);

            return redirect()
                ->route('admin.adminMenu.index')
                ->with('status', 'Pelanggan ' . $request->input('fullname') . ' Telah Ditambahkan');
        } catch (Throwable $e) {
            Log::critical($e->getMessage(), $e->getTrace());

            if ($photoPath) {
                Storage::delete($photoPath);
            }

            return abort(500, $e->getMessage());
        }
    }
}
