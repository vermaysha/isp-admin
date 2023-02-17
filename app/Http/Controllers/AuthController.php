<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Show login page
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if ($request->user()) {
            return redirect()->route('home');
        }

        return view('pages/login', [
            'pageTitle' => 'Login',
        ]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Tidak dapat masuk. Harap periksa informasi akun Anda.',
        ])->onlyInput('email');
    }

   /**
    * Handle an authentication attempt.
    *
    * @return \Illuminate\Http\Response
    */
   public function signup(Request $request)
   {
       if ($request->user()) {
           return redirect()->route('home');
       }

       return view('pages/signup', [
           'pageTitle' => 'SignUp',
       ]);
   }

    /**
     * Handle logout process
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
