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

Route::get('/patients', function () {
    return view('patients');
})->middleware(['auth', 'verified'])->name('patients');

Route::get('/react/{id}', function ($id) {
    return view('react')->with('id',$id);
})->middleware(['auth', 'verified'])->name('react');


require __DIR__.'/auth.php';
