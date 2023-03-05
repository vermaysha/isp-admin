<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DirectController extends Controller
{
    public function direct(Request $request)
    {
        return view('pages.admin.direct.index', [
            'title' => 'Pelanggan Direct',
        ]);
    }
}
