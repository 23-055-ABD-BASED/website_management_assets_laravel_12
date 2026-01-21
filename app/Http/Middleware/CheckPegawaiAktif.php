<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPegawaiAktif
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika user login & punya relasi pegawai
        if ($user && $user->pegawai) {

            // Jika status pegawai NONAKTIF
            if ($user->pegawai->status_pegawai !== 'aktif') {
                return redirect()->back()->with(
                    'pegawai_nonaktif',
                    'Akun pegawai Anda tidak aktif. Silakan hubungi admin untuk aktivasi.'
                );
            }
        }

        return $next($request);
    }
}
