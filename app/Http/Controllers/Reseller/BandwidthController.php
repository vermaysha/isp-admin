<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Bandwidth;
use App\Models\Reseller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class BandwidthController extends Controller
{
    /**
     * Show table of available bandwidth
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bandwidths = Bandwidth::whereHas('reseller', function ($q) {
            $q->where('user_id', Auth::id());
        })->orderBy('id', 'desc');

        return view('pages.reseller.bandwidth.index', [
            'title' => 'Paket Internet',
            'bandwidths' => $bandwidths->paginate(20)->appends($request->all()),
        ]);
    }

    /**
     * Show detail data of plans
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, string $id)
    {
        $bandwidth = Bandwidth::whereHas('reseller', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($id);

        return view('pages.reseller.bandwidth.detail', [
            'title' => 'Bandwidth: ' . $bandwidth->name,
            'bandwidth' => $bandwidth,
        ]);
    }

    /**
     * Show create plans form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('pages.reseller.bandwidth.create');
    }

    /**
     * Store plan to database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
            'bandwidth' => 'required|numeric',
            'description' => 'nullable',
        ]);

        try {
            $reseller = Reseller::select('id')->where('user_id', Auth::id())->first();

            $bandwdith = new Bandwidth([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'bandwidth' => $request->input('bandwidth'),
                'description' => $request->input('description'),
                'reseller_id' => $reseller->id,
            ]);

            $bandwdith->save();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
        } finally {
            return redirect()->route('reseller_owner.bandwidth')->with('status', 'Paket "' . $request->input('name') . '" Telah Ditambahkan');
        }
    }

    /**
     * Show edit form
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, string $id)
    {
        $plan = Bandwidth::whereHas('reseller', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($id);

        return view('pages.reseller.bandwidth.edit', [
            'plan' => $plan,
        ]);
    }

    /**
     * Process update data
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
            'bandwidth' => 'required|numeric',
            'description' => 'nullable',
        ]);

        $plan = Bandwidth::whereHas('reseller', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($id);

        $plan->name = $request->input('name');
        $plan->price = $request->input('price');
        $plan->bandwidth = $request->input('bandwidth');
        $plan->description = $request->input('description');

        try {
            $plan->save();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
        } finally {
            return redirect()->route('reseller_owner.bandwidth')->with('status', 'Paket "' . $request->input('name') . '" Telah Diubah');
        }
    }
}
