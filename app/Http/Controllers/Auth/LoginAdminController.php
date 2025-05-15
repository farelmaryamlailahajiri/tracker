<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAdminController extends Controller
{
    public function login(Request $request)
    {
        // Ambil hanya username dan password dari input
        $credentials = $request->only('username', 'password');

        // Cek kredensial menggunakan guard admin
        if (Auth::guard('admin')->attempt($credentials)) {
    return redirect()->intended('/admin/dashboard');
}


        // Jika login gagal, kembalikan pesan error
        return response()->json([
            'status' => false,
            'message' => 'Login gagal! Username atau password salah.'
        ]);
    }
}
