<?php

use App\Models\Patient;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\TestController;

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
    return view('index');
});

Route::get('/dashboard', function () {
    return redirect()->route('patients');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/result/{id}', [TestController::class, 'result'])->middleware(['auth', 'verified'])->name('result');

Route::get('/users', function () {
    return view('users');
})->middleware(['auth', 'verified'])->name('users');

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

Route::get('/backup', [BackupController::class, 'backup'])->name('backup');

Route::get('/backup_instructions', function () {
    return view('backup_instructions');
})->middleware(['auth', 'verified'])->name('backup_instructions');

require __DIR__.'/auth.php';
