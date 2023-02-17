<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Reseller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $staffs = User::with([
            'roles',
        ])->whereHas('resellers', function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('id', Auth::id());
            });
        });

        if ($request->ajax() || $request->has('is_ajax')) {
            return DataTables::eloquent($staffs)->toJson();
        }

        return view('pages.reseller.employee.index', [
            'title' => 'Pegawai',
        ]);
    }

    /**
     * Show detail data of client
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, $id)
    {
        $staff = User::with([
            'roles',
        ])->whereHas('resellers', function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('id', Auth::id());
            });
        })->findOrFail($id);

        return view('pages.reseller.employee.detail', [
            'title' => 'Detail Pegawai: ' . $staff->fullname,
            'staff' => $staff,
        ]);
    }

    /**
     * Show form to create add new employees
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('pages.reseller.employee.create', [
            'title' => 'Tambah Pegawai',
        ]);
    }

    /**
     * Process create new employee
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required',
            'username' => 'required|alpha_dash|regex:/^[A-Za-z0-9_]+$/|unique:users,username',
            'email' => 'nullable|email:rfc,dns|unique:users,email',
            'phone_number' => 'nullable|numeric',
            'password' => 'required|confirmed',
            'birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable',
            'photo' => 'nullable|image|max:1024',
            'role' => [
                'required',
                Rule::in([
                    Role::RESELLER_ADMIN,
                    Role::RESELLER_TECHNICIAN,
                ]),
            ],
        ]);

        $photoPath = null;

        try {
            if ($request->hasFile('photo')) {
                $logo = Image::make($request->file('photo'));
                $logo->fit($logo->width());

                $photoPath = 'images/staffs/' . Str::slug($request->input('name')) . time() . '.webp';

                Storage::disk('public')->put(
                    $photoPath,
                    $logo->encode('webp')
                );
            }
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());
        }

        $reseller = Reseller::whereHas('user', function ($q) {
            $q->where('id', Auth::id());
        })->firstOrFail();

        try {
            DB::transaction(function () use ($request, $photoPath, $reseller) {
                $user = new User([
                    'fullname' => $request->input('fullname'),
                    'username' => $request->input('username'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'birth' => $request->input('birth'),
                    'gender' => $request->input('gender'),
                    'phone_number' => $request->input('phone_number'),
                    'address' => $request->input('address'),
                    'photo' => $photoPath ? 'storage/' . $photoPath : null,
                ]);

                $user->save();
                $user->assignRole($request->input('role'));
                $user->refresh();
                $reseller->employees()->attach($user->id);
            }, 5);

            return redirect()
                ->route('business.employeeMenu.index')
                ->with('status', 'Pegawai ' . $request->input('fullname') . ' Telah Ditambahkan');
        } catch (Throwable $e) {
            if ($photoPath) {
                Storage::delete($photoPath);
            }

            Log::critical($e->getMessage(), $e->getTrace());

            return abort(500, $e->getMessage());
        }
    }

    /**
     * Show edit employee form
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, string $id)
    {
        $staff = User::with([
            'roles',
        ])->whereHas('resellers', function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('id', Auth::id());
            });
        })->findOrFail($id);

        return view('pages.reseller.employee.edit', [
            'title' => 'Edit Pegawai: ' . $staff->fullname,
            'staff' => $staff,
        ]);
    }

    /**
     * Update employee process
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $staff = User::with([
            'roles',
        ])->whereHas('resellers', function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('id', Auth::id());
            });
        })->findOrFail($id);

        $this->validate($request, [
            'fullname' => 'nullable',
            'username' => [
                'nullable',
                'alpha_dash',
                'regex:/^[A-Za-z0-9_]+$/',
                Rule::unique('users', 'username')->ignore($staff->id),
            ],
            'email' => [
                'nullable',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($staff->id),
            ],
            'phone_number' => 'nullable|numeric',
            'password' => 'nullable|confirmed',
            'birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable',
            'photo' => 'nullable|image|max:1024',
            'role' => [
                'required',
                Rule::in([
                    Role::RESELLER_ADMIN,
                    Role::RESELLER_TECHNICIAN,
                ]),
            ],
        ]);

        $photoPath = null;

        try {
            if ($request->hasFile('photo')) {
                $logo = Image::make($request->file('photo'));
                $logo->fit($logo->width());

                $photoPath = 'images/staffs/' . Str::slug($request->input('name')) . time() . '.webp';

                Storage::disk('public')->put(
                    $photoPath,
                    $logo->encode('webp')
                );
            }
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());
        }

        try {
            DB::transaction(function () use (&$request, &$staff, &$photoPath) {
                $allowedInput = [
                    'fullname',
                    'username',
                    'email',
                    'phone_number',
                    'password',
                    'birth',
                    'gender',
                    'address',
                ];

                foreach ($allowedInput as $key) {
                    if ($request->has($key) && $request->input($key)) {
                        $staff->{$key} = $request->input($key);
                    }
                }

                if ($photoPath) {
                    $staff->photo = $photoPath ? 'storage/' . $photoPath : null;
                }

                $staff->save();
            }, 5);

            return redirect()
                ->route('business.employeeMenu.index')
                ->with('status', 'Pegawai "' . $staff->fullname . '" Telah Diubah');
        } catch (Throwable $e) {
            Log::critical($e->getMessage(), $e->getTrace());

            if ($photoPath) {
                Storage::delete($photoPath);
            }

            return abort(500, $e->getMessage());
        }
    }

    /**
     * Delete selected employee
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, string $id)
    {
        if ($id == Auth::id()) {
            return redirect()->route('business.employeeMenu.index');
        }

        $staff = User::with([
            'roles',
        ])->whereHas('resellers', function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('id', Auth::id());
            });
        })->findOrFail($id);

        $staffName = $staff->fullname;

        try {
            DB::transaction(function () use ($staff) {
                $staff->delete();
            });
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());
            abort(500);
        }

        return redirect()
            ->route('business.employeeMenu.index')
            ->with('status', 'Pegawai ' . $staffName . ' Telah Dihapus');
    }
}
