<?php

use App\Http\Controllers\Admin\TipController as AdminTipController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\TipController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store'])->middleware('throttle:6,1');

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:login');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        $hariIni = now()->toDateString();

        $obatHariIni = auth()->user()->obat()
            ->where('aktif', true)
            ->whereDate('tanggal_mulai', '<=', $hariIni)
            ->where(function ($query) use ($hariIni) {
                $query->whereNull('tanggal_selesai')
                    ->orWhereDate('tanggal_selesai', '>=', $hariIni);
            })
            ->get();

        return view('dashboard', compact('obatHariIni'));
    })->name('dashboard');

    Route::resource('obat', ObatController::class)->except(['show']);

    Route::patch('obat/{obat}/selesai', [ObatController::class, 'selesai'])
        ->name('obat.selesai');

    Route::get('tips', [TipController::class, 'index'])->name('tips.index');
    Route::get('tips/{tip}', [TipController::class, 'show'])->name('tips.show');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('tips', AdminTipController::class)->except(['show']);
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});