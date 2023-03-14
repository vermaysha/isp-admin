<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    /**
     * Get list of office data
     *
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {
        $offices = Office::with([
            'address',
            'reseller' => function ($q) {
                $q->withCount('clients');
            },
        ])->get();

        return view('pages.admin.direct.index', [
            'offices' => $offices,
        ]);
    }

    /**
     * Detail office
     *
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function detail(Request $request, string $id)
    {
        $office = Office::with([
            'address',
            'reseller' => function ($q) {
                $q->withCount('clients');
            },
        ])->where('id', $id)->firstOrFail();

        $ppnCount = Client::where('reseller_id', $office->reseller->id)->where('is_ppn', true)->count();
        $nonPpnCount = Client::where('reseller_id', $office->reseller->id)->where('is_ppn', false)->count();
        $paidCustCount = Bill::where('reseller_id', $office->id)->whereNotNull('payed_at')->count();
        $outstandingCustCount = Bill::where('reseller_id', $office->id)->whereNull('payed_at')->count();

        return view('pages.admin.direct.detail', [
            'office' => $office,
            'ppnCount' => $ppnCount,
            'nonPpnCount' => $nonPpnCount,
            'paidCustCount' => $paidCustCount,
            'outstandingCustCount' => $outstandingCustCount,
        ]);
    }
}
