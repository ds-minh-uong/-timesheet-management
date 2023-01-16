<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimesheetController;
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
    return view('welcome');
});

Route::get('/create-timesheet', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('create-timesheet');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/timesheet', [TimesheetController::class, 'index'])->name('timesheet');
    Route::patch('/timesheet', [TimesheetController::class, 'update'])->name('timesheet.update');
    Route::post('/timesheet', [TimesheetController::class, 'store'])->name('timesheet.store');
});

require __DIR__.'/auth.php';
