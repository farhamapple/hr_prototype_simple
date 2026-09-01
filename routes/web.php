<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\JobController; 
use App\Http\Controllers\JobHistoryController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }

    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')->name('dashboard');

Route::prefix('departments')->group(function () {
    Route::get('/', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('/', [DepartmentController::class, 'store'])->name('departments.store');
    Route::put('/{id}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
});
Route::middleware('auth')->group(function () {
    // Dashboard utama setelah user berhasil login.
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
Route::resource('countries', CountryController::class)
->middleware('auth');

Route::resource('/regions', RegionController::class)
->middleware('auth');

Route::resource('employees', EmployeeController::class)
->middleware('auth');

Route::resource('locations', LocationController::class)
->middleware('auth');

Route::resource('/jobs', JobController::class)
->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/job-history', [JobHistoryController::class, 'index'])
        ->name('job-history.index');

    Route::get('/job-history/{employeeId}', [JobHistoryController::class, 'show'])
        ->name('job-history.show');
});
