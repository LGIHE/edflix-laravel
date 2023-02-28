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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SubjectController;

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
    Route::get('create-user', [UserController::class, 'createUserSuccess'])->name('user.create.success');
    Route::get('user/{id}', [UserController::class, 'getUser'])->name('get.user');
    Route::post('user/{id}', [UserController::class, 'updateUser'])->name('user.update');
    Route::delete('user/{id}', [UserController::class, 'deleteUser']);
    Route::get('users', [UserController::class, 'getUsers'])->name('users');

	Route::get('profile', function () {return view('user.profile');})->name('profile');
    Route::post('profile', [ProfileController::class, 'updateBio']);
    Route::post('update-password', [ProfileController::class, 'updatePassword'])->name('update-password');

    //LESSON PLAN ROUTES
	Route::get('lesson-plans', function () {return view('lesson-plan.index');})->name('lesson-plans');

    //SCHOOL ROUTES
	Route::get('schools', [SchoolController::class, 'getAll'])->name('schools');
	Route::get('school/{id}', [SchoolController::class, 'getOne'])->name('get.school');
	Route::post('school', [SchoolController::class, 'createSchool'])->name('create.school');
	Route::get('school-success', [SchoolController::class, 'createSuccess'])->name('school-success');
	Route::post('school/update/{id}', [SchoolController::class, 'updateSchool'])->name('update.school');
	Route::get('school-update', [SchoolController::class, 'createSuccess'])->name('school-update');
	Route::get('school-delete/{id}', [SchoolController::class, 'deleteSuccess'])->name('delete.school');

    //SUBJECTS ROUTES
    Route::get('subjects', [SubjectController::class, 'getAll'])->name('subjects');
	Route::get('subject/{id}', [SubjectController::class, 'getOne'])->name('get.subject');
	Route::post('subject', [SubjectController::class, 'createSubject'])->name('create.subject');
	Route::get('subject-success', [SubjectController::class, 'createSuccess'])->name('subject-success');
	Route::post('subject/update/{id}', [SubjectController::class, 'updateSubject'])->name('update.subject');
	Route::get('subject-update', [SubjectController::class, 'createSuccess'])->name('subject-update');
	Route::get('subject-delete/{id}', [SubjectController::class, 'deleteSuccess'])->name('delete.subject');

    Route::post('sign-out', [AuthController::class, 'singOut'])->name('logout');
});
