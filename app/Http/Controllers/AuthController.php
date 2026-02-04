<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        // JIKA INI REQUEST REGISTER → STOP
        if ($request->has('register')) {
            return back();
        }

        // VALIDASI LOGIN
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'errors' => [
                    'username' => ['Username atau password salah']
                ]
            ], 422);
        }

        // KRUSIAL
        $request->session()->regenerate();

        $user = Auth::user();

        // VALIDASI REGISTER

        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'Password tidak sama',
        ]);

        // ADMIN
        if ($user->role === 'admin') {
            return response()->json([
                'redirect' => route('admin.dashboard')
            ]);
        }

        // PEGAWAI BELUM ADA
        if (!$user->pegawai) {
            return response()->json([
                'redirect' => route('pegawai.create')
            ]);
        }

        //Password salah
        if (!Auth::attempt($request->only('username', 'password'))) {
            return back()->withErrors([
                'password' => 'Password salah'
            ])->withInput();
        }


        // USER BIASA
        return response()->json([
            'redirect' => route('dashboard')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}