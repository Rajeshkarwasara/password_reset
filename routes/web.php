<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\admin\loginController as AdminloginController;
use App\Http\Controllers\admin\dashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', [LoginController::class, "index"])->name('Account.login');
Route::get('register', [LoginController::class, "register"])->name('Account.register');
Route::post('processregister', [LoginController::class, "processregister"])->name('Account.processregister');
Route::post('authenticate', [LoginController::class, "authenticate"])->name('Account.authenticate');
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, "dashboard"])->name('Account.dashboard');
    Route::get('logout', [LoginController::class, "logout"])->name('Account.logout');

});


Route::middleware(['admin.auth'])->group(function () {
    Route::get('admin/dashboard', [AdminDashboardController::class, "admin_dashboard"])->name('admin.dashboard');
    Route::get('admin/logout', [AdminloginController::class, "logout"])->name('admin.logout');
});
Route::get('admin/login', [AdminloginController::class, "index"])->name('admin.login');
Route::post('admin/authenticate', [AdminloginController::class, "admin_authenticate"])->name('admin.authenticate');

