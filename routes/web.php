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
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;


Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [AuthController::class, 'signInGet'])->middleware('guest')->name('login');
Route::post('sign-in', [AuthController::class, 'signInPost'])->middleware('guest');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');
Route::get('verify', function () {return view('auth.verify');})->middleware('guest')->name('verify');
Route::get('/reset-password/{token}', function ($token) {return view('auth.reset', ['token' => $token]);})->middleware('guest')->name('password.reset');
Route::post('verify', [AuthController::class, 'verifyPasswordReset'])->middleware('guest');
Route::post('sign-out', [AuthController::class, 'singOut'])->middleware('auth')->name('logout');

Route::get('create-user', [ProfileController::class, 'create'])->middleware('auth')->name('create-user');
Route::post('profile', [ProfileController::class, 'update'])->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('billing', function () {
		return view('pages.billing');
	})->name('billing');
	Route::get('tables', function () {
		return view('pages.tables');
	})->name('tables');
	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');
	Route::get('users', function () {
		return view('user.users');
	})->name('user-management');
	Route::get('profile', function () {
		return view('user.profile');
	})->name('profile');
});
