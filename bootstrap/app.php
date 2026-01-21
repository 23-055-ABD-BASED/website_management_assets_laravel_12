<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        // Session middleware harus di depan
        $middleware->web(append: [
            // Middleware tambahan bisa ditambah di sini
        ]);
        
        $middleware->alias([
            'pegawai.exists' => \App\Http\Middleware\EnsurePegawaiExists::class,
            'pegawai.aktif'  => \App\Http\Middleware\CheckPegawaiAktif::class,
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
