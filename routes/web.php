<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/usuarios', function () {
    return view('usuarios');
})->middleware(['auth', 'verified'])->name('usuarios');

Route::get('/pacientes', function () {
    return view('pacientes');
})->middleware(['auth', 'verified'])->name('pacientes');

Route::get('/padecimientos', function () {
    return view('padecimientos');
})->middleware(['auth', 'verified'])->name('padecimientos');

Route::get('/sintomas', function () {
    return view('sintomas');
})->middleware(['auth', 'verified'])->name('sintomas');

require __DIR__.'/auth.php';
