<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SignInController extends Controller
{
    public function signIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required | email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        if (Auth::attempt($credentials, $request->has('remember'))) {
            return redirect()->route('admin.index');
        }

        return redirect()->back()->with('fail', 'Authentication failed.');
    }
}
