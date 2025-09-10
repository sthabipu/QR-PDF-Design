<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrController;

Route::get('/', [QrController::class, 'index'])->name('qr.index');
Route::post('/process', [QrController::class, 'process'])->name('qr.process');
