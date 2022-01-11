<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function authenticate(Request $request){
			$credentials = $request->validate([
				'email' => ['required', 'email'],
				'password' => ['required'],
			]);

			if (Auth::attempt($credentials)) {
					$request->session()->regenerate();

					return redirect()->intended('upload');
			}

			return back()->withErrors([
					'email' => 'The provided credentials do not match our records.',
			]);

    }
}
