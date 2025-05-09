<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msgField' => $validator->errors(),
                'message' => 'Validasi gagal.'
            ]);
        }

        // Untuk testing: tidak perlu autentikasi, langsung kirim respons sukses
        return response()->json([
            'status' => true,
            'message' => 'Login berhasil (dummy controller).'
        ]);
    }
}
