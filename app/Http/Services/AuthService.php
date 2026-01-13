<?php

namespace App\Http\Services;

use App\Http\Requests\StoreAuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function saveSession(StoreAuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Logged in successfully',
            'user' => auth()->user(),
            'redirect' => url('/pages/dashboard')
        ]);
    }

    public function destroySession()
    {
        auth()->logout();
        return redirect('/');
    }
}
