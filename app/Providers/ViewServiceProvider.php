<?php

namespace App\Providers;

use App\Enums\ClientStatus;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check() && Auth::user()->hasAnyRole([
                Role::RESELLER_ADMIN,
                Role::RESELLER_OWNER,
            ])) {
                $totalOutstandingBill = Bill::select(DB::raw('count(id) as total'))
                    ->whereHas('reseller.employees', function ($q) {
                        $q->where('user_id', Auth::id());
                    })->whereNull('payed_at')->whereNull('accepted_at')->first()->total ?? 0;
                $totalPaidBill = Bill::select(DB::raw('count(id) as total'))
                    ->whereHas('reseller.employees', function ($q) {
                        $q->where('user_id', Auth::id());
                    })->whereNotNull('payed_at')->whereNull('accepted_at')->first()->total ?? 0;
            }

            if (Auth::check() && Auth::user()->hasRole(Role::CLIENT)) {
                $totalOutstandingBill = Bill::select(DB::raw('count(id) as total'))
                    ->whereHas('client.user', function ($q) {
                        $q->where('id', Auth::id());
                    })->whereNull('payed_at')->whereNull('accepted_at')->first()->total ?? 0;
                $totalPaidBill = Bill::select(DB::raw('count(id) as total'))
                    ->whereHas('client.user', function ($q) {
                        $q->where('id', Auth::id());
                    })->whereNotNull('payed_at')->whereNull('accepted_at')->first()->total ?? 0;
            }

            if (Auth::check() && Auth::user()->hasAnyRole([
                Role::RESELLER_ADMIN,
                Role::RESELLER_OWNER,
                Role::RESELLER_TECHNICIAN,
            ])) {
                $prospectiveClient = Client::select(DB::raw('count(id) as total'))
                    ->whereHas('reseller.employees', function ($q) {
                        $q->where('user_id', Auth::id());
                    })->where('status', ClientStatus::NOT_INSTALLED)->first()->total ?? 0;
            }

            $view->with('prospectiveClient', $prospectiveClient ?? 0);

            $view->with('totalOutstandingBill', $totalOutstandingBill ?? 0);
            $view->with('totalPaidBill', $totalPaidBill ?? 0);
        });
    }
}
