<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginUserRequest;

class AuthController extends Controller
{

    public function login()
    {
        return view('backend.auth.login');
    }

    public function authenticate(LoginUserRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        $remember = $request->boolean('remember');

        if (auth()->guard('admin')->attempt($credentials, $remember)) {

            $account = auth()->guard('admin')->user();

            if ($account->role_id != 1) {
                sessionFlash('error', 'Tài khoản không có quyền truy cập!');

                auth()->guard('admin')->logout();

                return back();
            }

            sessionFlash('success', 'Đăng nhập thành công.');
            return redirect()->route('admin.dashboard');
        } else {
            sessionFlash('error', 'Tài khoản hoặc mật khẩu không chính xác!');
            return back()->withInput();
        }
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.auth.login');
    }
}
