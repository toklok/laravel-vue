<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
// */

// Calculator
Route::get('/', [CalculatorController::class, 'index'])->name('homepage.index');
Route::post('/calculation', [CalculatorController::class, 'store'])->name('homepage.store');
Route::delete('/calculations/{id}', [CalculatorController::class, 'delete'])->name('homepage.delete');
