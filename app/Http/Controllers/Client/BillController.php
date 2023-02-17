<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class BillController extends Controller
{
    public function index(Request $request)
    {
        // return view('pages.client.bill.index', [
        //     'title' => 'Transaksi',
        // ]);
    }

    /**
     * Outstanding balance bill
     *
     * @return \Illuminate\Http\Response
     */
    public function outstanding(Request $request)
    {
        $bills = Bill::with([
            'client',
            'client.user',
        ])->whereHas('client.user', fn ($q) => $q->where('id', Auth::id()))
            ->whereNull('payed_at')
            ->whereNull('accepted_at');

        if ($request->ajax() || $request->has('is_ajax')) {
            return DataTables::eloquent($bills)->toJson();
        }

        return view('pages.client.bill.index', [
            'title' => 'Tagihan Terhutang',
            'type' => 'outstanding',
        ]);
    }

    /**
     * History balance bill
     *
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        $bills = Bill::with([
            'client',
            'client.user',
        ])->whereHas('client.user', fn ($q) => $q->where('id', Auth::id()))
            ->whereNotNull('payed_at');

        if ($request->ajax() || $request->has('is_ajax')) {
            return DataTables::eloquent($bills)->toJson();
        }

        return view('pages.client.bill.index', [
            'title' => 'Riwayat Tagihan',
            'type' => 'history',
        ]);
    }

    /**
     * Detail balance bill
     *
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, string $id)
    {
        $bill = Bill::with([
            'reseller',
            'client',
            'plan',
        ])->where('id', $id)
          ->whereHas('client.user', function ($q) {
              $q->where('id', Auth::id());
          })
          ->firstOrFail();

        return view('pages.client.bill.detail', [
            'title' => 'Detail Tagihan: ' . $bill->invoice_id,
            'bill' => $bill,
        ]);
    }

    /**
     * Pay bill
     *
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request, string $id)
    {
        $request->validate([
            'paymentProff' => 'required|mimes:jpeg,bmp,png,gif,svg,pdf|max:1024',
        ]);

        $bill = Bill::where('id', $id)
          ->whereHas('client.user', function ($q) {
              $q->where('id', Auth::id());
          })->firstOrFail();

        if ($bill->payed_at || $bill->accepted_at) {
            return redirect()
                ->route('client.billMenu.detail', $id);
        }

        $billPhoto = Image::make($request->file('paymentProff'));
        $billPhoto->fit($billPhoto->width());

        $billPhotoPath = 'images/bills/' . now()->format('Y-m-d-') . time() . '.webp';

        Storage::disk('public')->put(
            $billPhotoPath,
            $billPhoto->encode('webp')
        );

        try {
            DB::transaction(function () use ($bill, $billPhotoPath) {
                $bill->bill_photo = 'storage/' . $billPhotoPath;
                $bill->payed_at = now();
                $bill->save();
            }, 5);
        } catch (Throwable $ex) {
            Log::error($ex->getMessage(), $ex->getTrace());
            abort(500);
        }

        return redirect()
            ->route('client.billMenu.detail', $id)
            ->with('status', 'Tagihan Telah Dibayar, menunggu konfirmasi reseller');
    }
}
