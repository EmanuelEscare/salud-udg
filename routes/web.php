<?php

use App\Models\Patient;
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

Route::get('/result', function () {
    return view('result');
})->middleware(['auth', 'verified'])->name('result');

Route::get('/usuarios', function () {
    return view('usuarios');
})->middleware(['auth', 'verified'])->name('usuarios');

Route::get('/patients/{patient_id?}', function ($patient_id = null) {
    return view('patients', ['patient_id' => $patient_id]);
})->middleware(['auth', 'verified'])->name('patients');

Route::get('/config', function () {
    return view('config');
})->middleware(['auth', 'verified'])->name('config');

Route::get('/react/{id}/{user_id}', function ($id, $user_id) {
    $user = Patient::find($user_id);
    return view('react')->with(['id' => $id, 'user' => $user]);
})->middleware(['auth', 'verified'])->name('react');


require __DIR__.'/auth.php';
