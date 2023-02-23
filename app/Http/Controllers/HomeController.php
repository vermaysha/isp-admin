<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Client;
use App\Models\Reseller;
use App\Models\Role;
use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use DatePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Dashboard by user role
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::with('roles')->find(Auth::id());

        if ($user->hasRole(Role::ADMIN)) {
            return $this->adminPages($request);
        } elseif ($user->hasRole(Role::RESELLER_OWNER)) {
            return $this->resellerOwnerPages($request);
        } elseif ($user->hasRole(Role::RESELLER_TECHNICIAN)) {
            return $this->resellerTechnicianPages($request);
        } elseif ($user->hasRole(Role::RESELLER_ADMIN)) {
            return $this->resellerAdminPages($request);
        } elseif ($user->hasRole(Role::CLIENT)) {
            return $this->clientPages($request);
        } else {
            abort(403);
        }
    }

    /**
     * Admin pages
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPages(Request $request)
    {
        $data = shell_exec('uptime');
        $uptime = explode(' up ', $data);
        $uptime = explode(',', $uptime[1]);
        $uptime = $uptime[0] . '';

        $cpu = shell_exec('nproc') ?? 1;
        $cpuLoad = sys_getloadavg()[0] / $cpu ?? 0;

        $free = shell_exec('free');
        $free = (string) trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(' ', $free_arr[1]);
        $mem = array_filter($mem, function ($value) {
            return $value !== null && $value !== false && $value !== '';
        }); // removes nulls from array
        $mem = array_merge($mem); // puts arrays back to [0],[1],[2] after
        $memtotal = round($mem[1] / 1000000, 2);
        $memused = round($mem[2] / 1000000, 2);

        $diskfree = round(disk_free_space('.') / 1000000000);
        $disktotal = round(disk_total_space('.') / 1000000000);
        $diskused = round($disktotal - $diskfree);

        $userTotal = User::select('id')->count();
        $mitraTotal = Reseller::select('id')->count();
        $clientTotal = Client::select('id')->count();
        $mitraNonaktif = Reseller::select('inactive_at')->count();

        $mitras = Reseller::with(['user'])
            ->withCount('clients')
            ->orderBy('clients_count', 'desc')
            ->limit(10)
            ->get();

        return view('pages.admin.home', [
            'title' => 'Admin Dashboard',
            'upTime' => $uptime,
            'cpuLoad' => $cpuLoad,
            'memTotal' => $memtotal,
            'memUsed' => $memused,
            'diskFree' => $diskfree,
            'diskTotal' => $disktotal,
            'diskUsed' => $diskused,
            'userTotal' => $userTotal,
            'mitraTotal' => $mitraTotal,
            'mitraNonaktif' => $mitraNonaktif,
            'clientTotal' => $clientTotal,
            'mitras' => $mitras,
        ]);
    }

    /**
     * Reseller Owner pages
     *
     * @return \Illuminate\Http\Response
     */
    public function resellerOwnerPages(Request $request)
    {
        $currentMonth = CarbonImmutable::parse(date('Y-m') . '-1');
        $from = $currentMonth->subMonth(12)->toDateTimeString();
        $to = $currentMonth->toDateTimeString();

        $bills = $this->billGraph($from, $to);

        $outstanding = $this->outstandingGraph($from, $to);

        $clients = $this->clientGraph($from, $to);

        $totalClient = Client::select(DB::raw('count(id) as total'))->whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->first()?->total ?? 0;

        $totalPPNUsers = Client::select(DB::raw('count(id) as total'))->whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->where('is_ppn', true)
            ->first()?->total ?? 0;

        $totalNonPPNUsers = Client::select(DB::raw('count(id) as total'))->whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->where('is_ppn', false)
            ->first()?->total ?? 0;

        $totalEmployee = Reseller::whereHas('employees', fn ($q) => $q->where('user_id', Auth::id()))
            ->withCount('employees')->first()->employees_count;

        $unpayedBill = Bill::select(DB::raw('count(id) as total'))->whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })
            ->whereNull('payed_at')
            ->first()->total ?? 0;

        $lastMonth = $currentMonth->subMonth();
        $totalEarning = Bill::whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })
            ->select(DB::raw('SUM(grand_total) as total'))
            ->whereMonth('payment_month', $lastMonth->format('m'))
            ->whereYear('payment_month', $lastMonth->format('Y'))
            ->whereNotNull('accepted_at')
            ->whereNotNull('payed_at')
            ->first()?->total ?? 0;

        return view('pages.reseller.home.owner', [
            'client' => [
                'labels' => $clients->keys,
                'data' => $clients->values,
            ],
            'earning' => [
                'labels' => $bills->keys,
                'data' => $bills->values,
            ],
            'outstanding' => [
                'labels' => $outstanding->keys,
                'data' => $outstanding->values,
            ],
            'widget' => [
                'totalClient' => $totalClient ?? 0,
                'totalEmployee' => $totalEmployee ?? 0,
                'unpayedBill' => $unpayedBill ?? 0,
                'totalEarning' => $totalEarning ?? 0,
            ],
            'totalPPNusers' => $totalPPNUsers,
            'totalNonPPNUsers' => $totalNonPPNUsers,
        ]);
    }

    /**
     * Reseller Technician pages
     *
     * @return \Illuminate\Http\Response
     */
    public function resellerTechnicianPages(Request $request)
    {
        $currentMonth = CarbonImmutable::parse(date('Y-m') . '-1');
        $from = $currentMonth->subMonth(12)->toDateTimeString();
        $to = $currentMonth->toDateTimeString();

        $clients = $this->clientGraph($from, $to);

        $totalClient = Client::select(DB::raw('count(id) as total'))->whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->first()?->total ?? 0;

        return view('pages.reseller.home.technician', [
            'client' => [
                'labels' => $clients->keys,
                'data' => $clients->values,
            ],
            'widget' => [
                'totalClient' => $totalClient ?? 0,
            ],
        ]);
    }

    /**
     * Reseller Admin pages
     *
     * @return \Illuminate\Http\Response
     */
    public function resellerAdminPages(Request $request)
    {
        $currentMonth = CarbonImmutable::parse(date('Y-m') . '-1');
        $from = $currentMonth->subMonth(12)->toDateTimeString();
        $to = $currentMonth->toDateTimeString();

        $bills = $this->billGraph($from, $to);

        $outstanding = $this->outstandingGraph($from, $to);

        $clients = $this->clientGraph($from, $to);

        $totalClient = Client::select(DB::raw('count(id) as total'))->whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->first()?->total ?? 0;

        $totalPPNUsers = Client::select(DB::raw('count(id) as total'))->whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->where('is_ppn', true)
            ->first()?->total ?? 0;

        $totalNonPPNUsers = Client::select(DB::raw('count(id) as total'))->whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })->where('is_ppn', false)
            ->first()?->total ?? 0;

        $unpayedBill = Bill::select(DB::raw('count(id) as total'))->whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })
            ->whereNull('payed_at')
            ->first()->total ?? 0;

        $lastMonth = $currentMonth->subMonth();
        $totalEarning = Bill::whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })
            ->select(DB::raw('SUM(grand_total) as total'))
            ->whereMonth('payment_month', $lastMonth->format('m'))
            ->whereYear('payment_month', $lastMonth->format('Y'))
            ->whereNotNull('accepted_at')
            ->whereNotNull('payed_at')
            ->first()?->total ?? 0;

        return view('pages.reseller.home.admin', [
            'client' => [
                'labels' => $clients->keys,
                'data' => $clients->values,
            ],
            'earning' => [
                'labels' => $bills->keys,
                'data' => $bills->values,
            ],
            'outstanding' => [
                'labels' => $outstanding->keys,
                'data' => $outstanding->values,
            ],
            'widget' => [
                'totalClient' => $totalClient ?? 0,
                'unpayedBill' => $unpayedBill ?? 0,
                'totalEarning' => $totalEarning ?? 0,
            ],
            'totalPPNusers' => $totalPPNUsers,
            'totalNonPPNUsers' => $totalNonPPNUsers,
        ]);
    }

    /**
     * Client pages
     *
     * @return \Illuminate\Http\Response
     */
    public function clientPages(Request $request)
    {
        $bill = Bill::with([
            'client',
        ])->whereHas('client.user', function ($q) {
            $q->where('id', Auth::id());
        })->orderBy('id', 'asc')
            ->whereNull('payed_at')
            ->limit(1)
            ->first();

        $client = Client::with([
            'plan',
            'reseller',
        ])->whereHas('user', function ($q) {
            $q->where('id', Auth::id());
        })->first();

        return view('pages.client.home', [
            'bill' => $bill,
            'client' => $client,
        ]);
    }

    /**
     * Generate Graph data
     */
    public function graph(Collection $results, string $from, string $to): object
    {
        $results = collect($results)->keyBy('monthNum')->map(function ($item) {
            $item->monthNum = Carbon::parse($item->monthNum);

            return $item;
        });

        $periods = new DatePeriod(Carbon::parse($from), CarbonInterval::month(), Carbon::parse($to));

        $keys = [];
        $values = [];

        foreach ($periods as $period) {
            $monthKey = $period->format('Y-m-') . '01';

            $keys[] = Carbon::parse($period)->isoFormat('MMMM g');
            $values[] = $results->get($monthKey)->total ?? 0;
        }

        return (object) [
            'keys' => $keys,
            'values' => $values,
        ];
    }

    /**
     * Bill Graph data
     */
    public function billGraph(string $start, string $end): object
    {
        $bills = Bill::whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })
        ->select(DB::raw('sum(grand_total) as total'), DB::raw('DATE_FORMAT(payment_month,\'%Y-%m-01\') as monthNum'))
            ->whereBetween('payment_month', [$start, $end])
            ->orderBy('monthNum')
            ->groupBy('monthNum')
            ->whereNotNull('payed_at')
            ->whereNotNull('accepted_at')->get();

        return $this->graph($bills, $start, $end);
    }

    /**
     * Outstanding Graph data
     */
    public function outstandingGraph(string $start, string $end): object
    {
        $outstanding = Bill::whereHas('reseller.employees', function ($q) {
            $q->where('user_id', Auth::id());
        })
            ->select(DB::raw('sum(grand_total) as total'), DB::raw('DATE_FORMAT(payment_month,\'%Y-%m-01\') as monthNum'))
            ->whereBetween('payment_month', [$start, $end])
            ->orderBy('monthNum')
            ->groupBy('monthNum')
            ->whereNull('payed_at')
            ->orWhereNull('accepted_at')->get();

        return $this->graph($outstanding, $start, $end);
    }

    /**
     * Client Graph Data
     */
    public function clientGraph(string $start, string $end): object
    {
        $clients = Client::whereHas('reseller', function ($q) {
            $q->where('user_id', Auth::id());
        })
            ->select(DB::raw('count(id) as total'), DB::raw('DATE_FORMAT(created_at,\'%Y-%m-01\') as monthNum'))
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('monthNum')
            ->groupBy('monthNum')->get();

        $clients = $this->graph($clients, $start, $end);

        $clientsData = [];
        foreach ($clients->values as $value) {
            $clientsData[] = (last($clientsData) ?? 0) + $value;
        }

        return (object) [
            'values' => $clientsData,
            'keys' => $clients->keys,
        ];
    }
}
