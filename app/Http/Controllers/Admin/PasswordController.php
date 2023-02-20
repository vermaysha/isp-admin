<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.password.index', [
            'title' => 'Password Reset',
        ]);
    }
}
