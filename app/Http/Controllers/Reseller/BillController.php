<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class BillController extends Controller
{
    /**
     * Outstanding balance bill
     *
     * @return \Illuminate\Http\Response
     */
    public function outstanding(Request $request)
    {
        $bills = $this->_getTransactions($request);

        $bills->whereNull('payed_at');
        $bills->whereNull('accepted_at');

        if ($request->ajax() || $request->has('is_ajax')) {
            return DataTables::eloquent($bills)->toJson();
        }

        return view('pages.reseller.transaction.index', [
            'title' => 'Tagihan Terhutang',
            'transaction_type' => 'outstanding',
            // 'bills' => $bills->paginate(20)->appends($request->all()),
        ]);
    }

    /**
     * Paid bill but not confirmed
     *
     * @return \Illuminate\Http\Response
     */
    public function paid(Request $request)
    {
        $bills = $this->_getTransactions($request);

        $bills->whereNotNull('payed_at');
        $bills->whereNull('accepted_at');

        if ($request->ajax() || $request->has('is_ajax')) {
            return DataTables::eloquent($bills)->toJson();
        }

        return view('pages.reseller.transaction.index', [
            'title' => 'Tagihan Yang Telah Dibayar',
            'transaction_type' => 'paid',
            // 'bills' => $bills->paginate(20)->appends($request->all()),
        ]);
    }

    /**
     * Bill has been paid and confirmed
     *
     * @return \Illuminate\Http\Response
     */
    public function paidOff(Request $request)
    {
        $bills = $this->_getTransactions($request);

        $bills->whereNotNull('payed_at');
        $bills->whereNotNull('accepted_at');

        if ($request->ajax() || $request->has('is_ajax')) {
            return DataTables::eloquent($bills)->toJson();
        }

        return view('pages.reseller.transaction.index', [
            'title' => 'Tagihan Selesai',
            'transaction_type' => 'paidOff',
            // 'bills' => $bills->paginate(20)->appends($request->all()),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bills = $this->_getTransactions($request);

        $bills->whereNotNull('payed_at');

        return view('pages.reseller.transaction.index', [
            'title' => 'Tagihan',
            'bills' => $bills->paginate(20)->appends($request->all()),
        ]);
    }

    /**
     * Get bill
     *
     * @return \Illuminate\Http\Response
     */
    public function bills(Request $request)
    {
        $bills = $this->_getTransactions($request);

        $bills->whereNull('payed_at');

        return view('pages.reseller.transaction.bills', [
            'title' => 'Tagihan',
            'bills' => $bills->paginate(20)->appends($request->all()),
        ]);
    }

    /**
     * Get all data
     */
    private function _getTransactions(Request $request): Builder
    {
        $bills = Bill::whereHas('reseller.employees', fn ($q) => $q->where('user_id', Auth::id()))
            ->with([
                'client:id,user_id',
                'client.user',
            ]);

        if ($request->has('client_id')) {
            $bills->where('client_id', $request->client_id);
        }

        return $bills;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $transaction = Bill::with([
            'reseller' => function ($q) {
                $q->where('user_id', Auth::id());
            },
            'client',
            'plan',
        ])->where('id', $id)
          ->firstOrFail();

        return view('pages.reseller.transaction.detail', [
            'title' => 'Detail Tagihan: ' . $transaction->invoice_id,
            'transaction' => $transaction,
        ]);
    }

    /**
     * Confirm bill
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request, string $id)
    {
        $bill = Bill::with('reseller')->where('id', $id)
          ->firstOrFail();

        if ($bill->payed_at && $bill->accepted_at) {
            return redirect()
                ->route('business.billMenu.detail', $id);
        }

        try {
            DB::transaction(function () use ($bill) {
                $transaction = $bill->reseller->deposit($bill->grand_total, [
                    'description' => 'Pembayaran invoice: ' . $bill->invoice_id,
                ]);
                $bill->accepted_at = now();
                $bill->transaction()->associate($transaction);
                $bill->save();
            }, 5);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());
            abort(500);
        }

        return redirect()
            ->route('business.billMenu.detail', $id)
            ->with('status', 'Tagihan Telah dikonfirmasi');
    }
}
