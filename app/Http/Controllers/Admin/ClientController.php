<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Show all data of clients
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::with([
            'user',
            'reseller',
            'plan',
        ]);

        // Filter by reseller ID
        if ($request->has('reseller')) {
            $clients->where('reseller_id', $request->input('reseller'));
        }

        // Filter by is_ppn flag
        if ($request->input('is_ppn') === '1') {
            $clients->ppn();
        }

        return view('pages.admin.client.index', [
            'title' => 'Pelanggan',
            'clients' => $clients->paginate(20)->appends($request->all()),
        ]);
    }
}
