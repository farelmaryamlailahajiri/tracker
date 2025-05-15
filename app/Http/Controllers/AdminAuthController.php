<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->only('username', 'password');

        // Cek apakah username dan password sesuai
        if (Auth::guard('admin')->attempt($credentials)) {
    return redirect()->intended(route('admin.dashboard'));
}


        // Jika login gagal
        return response()->json([
            'status' => false,
            'message' => 'Login gagal! Username atau password salah.',
            'msgField' => [
                'username' => ['Username atau password salah.']
            ]
        ]);
    }

    public function dashboard()
    {
        return 'Selamat datang di Dashboard Admin!';
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}