<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Fetch user from the database
        $user = DB::table('admins')->where('username', $request->username)->first();

        // Check if user exists and password matches
        if ($user && password_verify($request->password, $user->password)) {
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
}