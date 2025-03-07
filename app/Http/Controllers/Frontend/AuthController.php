<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login()
    {
        return view('frontend.pages.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|exists:users,email|email',
                'password' => 'required'
            ],
            [
                'required' => 'Das Feld :attribute ist erforderlich.',
                'exists' => 'Die ausgewählte :attribute ist ungültig.',
                'email' => 'Das :attribute muss eine gültige E-Mail-Adresse sein.',
            ],
            [
                'email' => 'E-Mail',
                'password' => 'Passwort'
            ]
        );


        if (auth()->attempt($credentials)) {

            $account = $request->user();

            if ($account->role_id == 1) {
                auth()->logout();
                return redirect()->back()->with('error', 'Der Kontoadministrator kann nicht darauf zugreifen!');
            }

            return redirect()->intended(route('home'));
        }

        return redirect()->route('login')->with('error', 'Das Passwort ist falsch');
    }

    public function register()
    {
        return view('frontend.pages.register');
    }

    public function postRegister(Request $request)
    {
        $credentials = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ],
            [
                'required' => 'Das Feld :attribute ist erforderlich.',
                'email' => 'Das :attribute muss eine gültige E-Mail-Adresse sein.',
                'unique' => 'Das :attribute wurde bereits verwendet.',
            ],
            [
                'name' => 'Name',
                'email' => 'E-Mail',
                'password' => 'Passwort'
            ]
        );

        $credentials['password'] = Hash::make($credentials['password']);

        $account = User::create($credentials);

        auth()->login($account);

        return redirect()->intended(route('home'));
    }

    public function logout()
    {
        auth()->logout();

        session()->flush();

        return redirect(route('home'));
    }
}
