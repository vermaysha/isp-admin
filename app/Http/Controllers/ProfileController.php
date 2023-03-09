<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function admin(Request $request)
    {
        return view('pages.admin.profile.index', [
            'title' => 'Profile Pribadi',
        ]);
    }

    public function owner(Request $request)
    {
        return view('pages.reseller.profile.index', [
            'title' => 'Profile Pribadi',
        ]);
    }

    public function business(Request $request)
    {
        return view('pages.reseller.profile.business', [
            'title' => 'Profile Bisnis',
        ]);
    }

    public function employee(Request $request)
    {
        return view('pages.reseller.profile.employee', [
            'title' => 'Profile Pegawai',
        ]);
    }

    public function client(Request $request)
    {
        return view('pages.client.profile.index', [
            'title' => 'Profile Pelanggan',
        ]);
    }
}
