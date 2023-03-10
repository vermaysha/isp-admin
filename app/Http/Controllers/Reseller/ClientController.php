<?php

namespace App\Http\Controllers\Reseller;

use App\Enums\ClientStatus;
use App\Enums\ClientType;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Client;
use App\Models\Plan;
use App\Models\Reseller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Throwable;
use Vermaysha\Wilayah\Models\City;
use Vermaysha\Wilayah\Models\District;
use Vermaysha\Wilayah\Models\Province;
use Vermaysha\Wilayah\Models\Village;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    /**
     * Show table of client
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::with([
            'user:id,fullname,username,photo,phone_number,address_id',
            'user.address',
            'plan:id,name',
        ])->where('type', ClientType::INDIRECT_CLIENT)
            ->whereHas('reseller.employees', function ($q) {
                $q->where('user_id', Auth::id());
            });

        $status = match ($request->input('status')) {
            'not_installed' => ClientStatus::NOT_INSTALLED,
            'installed' => ClientStatus::ACTIVED,
            'blocked' => ClientStatus::BLOCKED,
            'inactive' => ClientStatus::INACTIVE,
            default => false
        };

        if ($status !== false) {
            $clients->where('status', $status);
        }

        if ($request->ajax() || $request->has('is_ajax')) {
            return DataTables::eloquent($clients)->toJson();
        }

        return view('pages.reseller.client.index', [
            'title' => 'Tambah Pelanggan',
        ]);
    }

    /**
     * Show detail data of client
     *
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, string $id)
    {
        $client = Client::with([
            'user',
            'plan',
            'bills' => function (HasMany $q) {
                $q->limit(5);
                $q->orderBy('id', 'desc');
            },
        ])->whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($id);

        return view('pages.reseller.client.detail', [
            'title' => 'Tambah Pelanggan',
            'client' => $client,
        ]);
    }

    /**
     * Show edit form for client
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, string $id)
    {
        $client = Client::with([
            'user',
            'plan',
            'bills' => function (HasMany $q) {
                $q->limit(5);
                $q->orderBy('id', 'desc');
            },
        ])->where('type', ClientType::INDIRECT_CLIENT)
            ->whereHas('reseller.employees', function ($q) {
                $q->where('user_id', Auth::id());
            })->findOrFail($id);

        $plans = Plan::whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->latest()->get();

        return view('pages.reseller.client.edit', [
            'title' => 'Edit Pelanggan: ' . $client->user->fullname,
            'plans' => $plans,
            'client' => $client,
        ]);
    }

    /**
     * Update process for client
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $client = Client::whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->where('type', ClientType::INDIRECT_CLIENT)
            ->findOrFail($id);

        $bandwidts = Plan::whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->select('id')->get();

        $this->validate($request, [
            'fullname' => 'nullable',
            'username' => [
                'nullable',
                'alpha_dash',
                'regex:/^[A-Za-z0-9_]+$/',
                Rule::unique('users', 'username')->ignore($client->user_id),
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($client->user_id),
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
            'photo' => 'nullable|image|max:1024',
            'plan' => [
                'nullable',
                Rule::in(Arr::pluck($bandwidts->toArray(), 'id')),
            ],
            'ppn' => 'nullable',
        ]);

        $photoPath = null;

        try {
            if ($request->hasFile('photo')) {
                $logo = Image::make($request->file('photo'));
                $logo->fit($logo->width());

                $photoPath = 'images/client/' . Str::slug($request->input('name')) . time() . '.webp';

                Storage::disk('public')->put(
                    $photoPath,
                    $logo->encode('webp')
                );
            }
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());
        }

        $user = User::find($client->user_id);

        try {
            DB::transaction(function () use (&$request, &$client, &$user, &$photoPath) {
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
                    if ($request->has($key)) {
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

                if ($request->has('is_ppn')) {
                    $client->is_ppn = $request->is_ppn;
                }

                if ($request->has('plan')) {
                    $client->plan_id = $request->plan;
                }

                $client->save();
            }, 5);

            return redirect()
                ->route('business.clientMenu.index')
                ->with('status', 'Pelanggan "' . $user->fullname . '" Telah Diubah');
        } catch (Throwable $e) {
            if ($photoPath) {
                Storage::delete($photoPath);
            }
            Log::critical($e->getMessage(), $e->getTrace());

            return abort(500, $e->getMessage());
        }
    }

    /**
     * Update status for user
     */
    public function updateStatus(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'status' => [
                'required',
                Rule::in(ClientStatus::getAllValues()),
            ],
        ]);

        $client = Client::with('user')->whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->where('type', ClientType::INDIRECT_CLIENT)
            ->findOrFail($id);

        switch ($request->input('status')) {
            case ClientStatus::ACTIVED:
                $client->installed_at = now();
                $client->blocked_at = null;
                $client->inactive_at = null;
                break;

            case ClientStatus::BLOCKED:
                $client->blocked_at = now();
                break;

            case ClientStatus::INACTIVE:
                $client->inactive_at = now();
                break;

            case ClientStatus::NOT_INSTALLED:
                $client->installed_at = null;
                $client->blocked_at = null;
                $client->inactive_at = null;
                break;
        }

        $client->status = $request->input('status');

        try {
            $client->save();

            return redirect()
                    ->route('business.clientMenu.detail', ['id' => $client->id])
                    ->with('status', 'Pelanggan "' . $client->user->fullname . '" Telah Diubah');
        } catch (Throwable $e) {
            Log::critical($e->getMessage(), $e->getTrace());

            return abort(500, $e->getMessage());
        }
    }

    /**
     * Show create clients form
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $plans = Plan::whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->latest()->get();

        return view('pages.reseller.client.create', [
            'title' => 'Tambah Pelanggan',
            'plans' => $plans,
        ]);
    }

    /**
     * Store data process
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bandwidts = Plan::whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->select('id')->get();

        $this->validate($request, [
            'fullname' => 'required',
            'username' => 'required|alpha_dash|regex:/^[A-Za-z0-9_]+$/|unique:users,username',
            'email' => 'required|email:rfc,dns|unique:users,email',
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
            'plan' => [
                'required',
                Rule::in(Arr::pluck($bandwidts->toArray(), 'id')),
            ],
            'ppn' => 'nullable',
        ]);

        $photoPath = null;

        try {
            if ($request->hasFile('photo')) {
                $logo = Image::make($request->file('photo'));
                $logo->fit($logo->width());

                $photoPath = 'images/client/' . Str::slug($request->input('name')) . time() . '.webp';

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
                $user->assignRole(Role::CLIENT);

                $user->client()->save(new Client([
                    'plan_id' => $request->input('plan'),
                    'reseller_id' => Reseller::whereHas('user', fn ($q) => $q->where('user_id', Auth::id()))->first()->id,
                    'payment_due_date' => 10,
                    'is_ppn' => $request->has('ppn'),
                ]));
            }, 5);

            return redirect()
                ->route('business.clientMenu.index')
                ->with('status', 'Pelanggan ' . $request->input('fullname') . ' Telah Ditambahkan');
        } catch (Throwable $e) {
            if ($photoPath) {
                Storage::delete($photoPath);
            }

            Log::critical($e->getMessage(), $e->getTrace());

            return abort(500, $e->getMessage());
        }
    }

    /**
     * Show create clients form
     *
     * @return \Illuminate\Http\Response
     */
    public function candidate(Request $request)
    {
        return view('pages.reseller.client.candidate_client', [
            'title' => 'Calon Pelanggan',
        ]);
    }
}
