<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Fetch user from the admins table
        $user = Admin::where('username', $request->username)->first();

        // Check if user exists and password matches
        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            // Log the user in
            Auth::login($user);

            // Successful login
            return response()->json([
                'status' => true,
                'message' => 'Login successful.',
                'redirect' => route('dashboard'), // Redirect URL
            ]);
        }

        // Failed login
        return response()->json([
            'status' => false,
            'message' => 'Invalid username or password.',
            'msgField' => [
                'username' => ['Invalid username or password.'],
            ],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => true,
            'message' => 'Logout successful.',
            'redirect' => url('/'), // Redirect ke halaman utama
        ]);
    }
}
