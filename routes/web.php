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

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {return redirect('sign-in');});
    // Route::get('sign-up', [RegisterController::class, 'create'])->name('register');
    // Route::post('sign-up', [RegisterController::class, 'store']);
    Route::get('sign-in', [AuthController::class, 'signInGet'])->name('login');
    Route::post('sign-in', [AuthController::class, 'signInPost']);
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    Route::get('verify', function () {return view('auth.verify');})->name('verify');
    Route::get('/reset-password/{token}', function ($token) {return view('auth.reset', ['token' => $token]);})->name('password.reset');
    Route::post('verify', [AuthController::class, 'verifyPasswordReset']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('create-user', [UserController::class, 'createUser'])->name('create-user');
    Route::get('user/{id}', [UserController::class, 'getUser'])->name('user');
    Route::patch('user/{id}', [UserController::class, 'updateUser']);
    Route::patch('user/{id}', [UserController::class, 'deleteUser']);
    Route::get('users', [UserController::class, 'getUsers'])->name('users');

	Route::get('profile', function () {return view('user.profile');})->name('profile');
    Route::post('profile', [ProfileController::class, 'updateBio']);
    Route::post('update-password', [ProfileController::class, 'updatePassword'])->name('update-password');

	Route::get('lesson-plans', function () {return view('lesson-plans.index');})->name('lesson-plans');

	Route::get('schools', function () {return view('schools.index');})->name('schools');

    Route::post('sign-out', [AuthController::class, 'singOut'])->name('logout');
});
