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
use App\Http\Controllers\LessonPlanController;

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

    //USER MANAGEMENT
    Route::post('create-user', [UserController::class, 'createUser'])->middleware('super.admin')->name('create-user');
    Route::get('create-user', [UserController::class, 'createUserSuccess'])->middleware('super.admin')->name('user.create.success');
    Route::get('user/{id}', [UserController::class, 'getUser'])->middleware('super.admin')->name('get.user');
    Route::post('user/{id}', [UserController::class, 'updateUser'])->middleware('super.admin')->name('update.user');
    Route::get('user/delete/{id}', [UserController::class, 'deleteUser'])->middleware('super.admin')->name('delete.user');
    Route::get('users', [UserController::class, 'getUsers'])->middleware('admin')->name('users');

	Route::get('profile', [ProfileController::class, 'get'])->name('profile');
    Route::post('profile', [ProfileController::class, 'updateBio']);
    Route::post('update-password', [ProfileController::class, 'updatePassword'])->name('update-password');

    //LESSON PLAN ROUTES
	Route::get('lesson-plans', [LessonPlanController::class, 'getAll'])->name('lesson.plans');
	Route::get('lesson-plan/{id}', [LessonPlanController::class, 'getLessonPlan'])->name('get.lesson.plan');
	Route::get('create-lesson-plan', [LessonPlanController::class, 'getCreate'])->name('get.create.lesson.plan');
	Route::post('create-lesson-plan', [LessonPlanController::class, 'createLessonPlan'])->name('create.lesson.plan');
	Route::get('create-lesson-plan-success/{id}', [LessonPlanController::class, 'successCreate'])->name('create.lesson.plan.success');

	Route::get('upload-lesson-plan', [LessonPlanController::class, 'getUploadLessonPlan'])->name('get.upload.lesson.plan');
	Route::post('upload-lesson-plan', [LessonPlanController::class, 'uploadLessonPlan'])->name('upload.lesson.plan');

	Route::post('add-step', [LessonPlanController::class, 'addStep'])->name('add.step');
	Route::get('add-step-success/{id}', [LessonPlanController::class, 'successAddStep'])->name('add.step.success');
	Route::get('step/{id}', [LessonPlanController::class, 'getStep'])->name('step');

	Route::post('add-annex/{id}', [LessonPlanController::class, 'addAnnex'])->name('add.annex');
	Route::get('add-annex-success/{id}', [LessonPlanController::class, 'successAddAnnex'])->name('add.annex.success');
    Route::get('annex/{file_name}', function($file_name = null)
    {
        $path = storage_path().'/app/public/annex-uploads/'.$file_name;
        if (file_exists($path)) {
            return Response::download($path);
        }
    });
	Route::post('update-annex/{id}', [LessonPlanController::class, 'updateAnnex'])->name('update.annex');
	Route::get('update-annex-success/{id}', [LessonPlanController::class, 'successUpdateAnnex'])->name('update.annex.success');
	Route::get('delete-annex/{id}', [LessonPlanController::class, 'deleteAnnex'])->name('delete.annex');

	Route::get('lesson-plan/update/{id}', [LessonPlanController::class, 'getLessonPlanUpdate'])->name('get.lesson.plan.update');
	Route::post('lesson-plan/update/{id}', [LessonPlanController::class, 'updateLessonPlan'])->name('update.lesson.plan');
	Route::get('lesson-plan-delete/{id}', [LessonPlanController::class, 'deleteSuccess'])->middleware('admin')->name('delete.lesson.plan');

    //SCHOOL ROUTES
	Route::get('schools', [SchoolController::class, 'getAll'])->middleware('admin')->name('schools');
	Route::get('school/{id}', [SchoolController::class, 'getOne'])->middleware('admin')->name('get.school');
	Route::post('school', [SchoolController::class, 'createSchool'])->middleware('admin')->name('create.school');
	Route::get('school-success', [SchoolController::class, 'createSuccess'])->middleware('admin')->name('school-success');
	Route::post('school/update/{id}', [SchoolController::class, 'updateSchool'])->middleware('admin')->name('update.school');
	Route::get('school-update', [SchoolController::class, 'createSuccess'])->middleware('admin')->name('school-update');
	Route::get('school-delete/{id}', [SchoolController::class, 'deleteSuccess'])->middleware('admin')->name('delete.school');

    //SUBJECTS ROUTES
    Route::get('subjects', [SubjectController::class, 'getAll'])->middleware('admin')->name('subjects');
	Route::get('subject/{id}', [SubjectController::class, 'getOne'])->middleware('admin')->name('get.subject');
	Route::post('subject', [SubjectController::class, 'createSubject'])->middleware('admin')->name('create.subject');
	Route::get('subject-success', [SubjectController::class, 'createSuccess'])->middleware('admin')->name('subject-success');
	Route::post('subject/update/{id}', [SubjectController::class, 'updateSubject'])->middleware('admin')->name('update.subject');
	Route::get('subject-update', [SubjectController::class, 'createSuccess'])->middleware('admin')->name('subject-update');
	Route::get('subject-delete/{id}', [SubjectController::class, 'deleteSuccess'])->middleware('admin')->name('delete.subject');

    Route::post('sign-out', [AuthController::class, 'singOut'])->name('logout');
});
