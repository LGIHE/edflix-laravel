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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LessonPlanController;
use App\Http\Controllers\CommentController;
use thiagoalessio\TesseractOCR\TesseractOCR;


Route::get('optimize', function () {
    $output = Artisan::call('optimize');
    return "<pre>$output</pre>";
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {return redirect('sign-in');});
    Route::get('sign-in', [AuthController::class, 'signInGet'])->name('login');
    Route::post('sign-in', [AuthController::class, 'signInPost']);
    Route::get('sign-up', [AuthController::class, 'signUpGet'])->name('signup');
    Route::post('sign-up', [AuthController::class, 'signUpPost']);
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    Route::get('verify', function () {return view('auth.verify');})->name('verify');
    Route::get('/reset-password/{token}', function ($token) {return view('auth.reset', ['token' => $token]);})->name('password.reset');
    Route::post('verify', [AuthController::class, 'verifyPasswordReset']);

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //USER MANAGEMENT
    Route::post('create-user', [UserController::class, 'createUser'])->middleware('super.admin')->name('create.user');
    Route::get('create-user', [UserController::class, 'createUserSuccess'])->middleware('super.admin')->name('create.user.success');
    Route::get('user/{id}', [UserController::class, 'getUser'])->middleware('super.admin')->name('get.user');
    Route::post('user/{id}', [UserController::class, 'updateUser'])->middleware('super.admin')->name('update.user');
    Route::get('user/delete/{id}', [UserController::class, 'deleteUser'])->middleware('super.admin')->name('delete.user');
    Route::get('users', [UserController::class, 'getUsers'])->middleware('admin')->name('users');

	Route::get('profile', [ProfileController::class, 'get'])->name('profile');
    Route::post('profile', [ProfileController::class, 'updateBio']);
    Route::post('update-password', [ProfileController::class, 'updatePassword'])->name('update.password');

    Route::get('upload-teachers', [UserController::class, 'getUploadTeachers'])->name('get.upload.teachers');
	Route::post('upload-teachers', [UserController::class, 'uploadTeachers'])->name('upload.teachers');

    //LESSON PLAN ROUTES
	Route::get('lesson-plans', [LessonPlanController::class, 'getAll'])->name('lesson.plans');
	Route::get('lesson-plan/{id}', [LessonPlanController::class, 'getLessonPlan'])->name('get.lesson.plan');
	Route::get('create-lesson-plan', [LessonPlanController::class, 'getCreate'])->name('get.create.lesson.plan');
	Route::post('create-lesson-plan', [LessonPlanController::class, 'createLessonPlan'])->name('create.lesson.plan');
	Route::get('create-lesson-plan-success/{id}', [LessonPlanController::class, 'successCreate'])->name('create.lesson.plan.success');

	Route::get('upload-lesson-plan', [LessonPlanController::class, 'getUploadLessonPlan'])->name('get.upload.lesson.plan');
	Route::post('upload-lesson-plan', [LessonPlanController::class, 'uploadLessonPlan'])->name('upload.lesson.plan');

    Route::get('lp-image', function ()
        {
            $tesseract = new TesseractOCR(public_path('annex/image.jpeg'));
            echo $tesseract->setLanguage('eng')->run();
        }
    );

	Route::post('add-step', [LessonPlanController::class, 'addStep'])->name('add.step');
	Route::get('add-step-success/{id}', [LessonPlanController::class, 'successAddStep'])->name('add.step.success');
	Route::get('step/{id}', [LessonPlanController::class, 'getStep'])->name('step');
	Route::post('update-step/{id}', [LessonPlanController::class, 'updateStep'])->name('update.step');
	Route::get('update-step-success/{id}', [LessonPlanController::class, 'successUpdateStep'])->name('update.step.success');
	Route::get('delete-step/{id}', [LessonPlanController::class, 'deleteStep'])->name('delete.step');

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
	Route::get('delete-lesson-plan/{id}', [LessonPlanController::class, 'deleteLessonPlan'])->name('delete.lesson.plan');

    Route::get('download-lp/{id}', [LessonPlanController::class, 'downloadLessonPlan'])->name('download.lp');

    //COMMENTS
	Route::post('add-comment', [CommentController::class, 'addComment'])->name('add.comment');
	Route::get('add-comment-success/{id}', [CommentController::class, 'successAddComment'])->name('add.comment.success');
	Route::post('add-reply', [CommentController::class, 'addReply'])->name('add.reply');
	Route::get('add-reply-success/{id}', [CommentController::class, 'successAddReply'])->name('add.reply.success');
    Route::get('mark-done/{id}', [CommentController::class, 'markDone'])->name('mark.done');

    //SCHOOL ROUTES
	Route::get('schools', [SchoolController::class, 'getAll'])->middleware('admin')->name('schools');
	Route::get('school/{id}', [SchoolController::class, 'getOne'])->middleware('admin')->name('get.school');
	Route::post('school', [SchoolController::class, 'createSchool'])->middleware('admin')->name('create.school');
	Route::get('create-school-success', [SchoolController::class, 'createSuccess'])->middleware('admin')->name('create.school.success');
	Route::post('school/update/{id}', [SchoolController::class, 'updateSchool'])->middleware('admin')->name('update.school');
	Route::get('school-delete/{id}', [SchoolController::class, 'deleteSuccess'])->middleware('admin')->name('delete.school');

    //SUBJECTS ROUTES
    Route::get('subjects', [SubjectController::class, 'getAll'])->middleware('admin')->name('subjects');
	Route::get('subject/{id}', [SubjectController::class, 'getOne'])->middleware('admin')->name('get.subject');
	Route::post('subject', [SubjectController::class, 'createSubject'])->middleware('admin')->name('create.subject');
	Route::get('create-subject-success', [SubjectController::class, 'createSuccess'])->middleware('admin')->name('create.subject.success');
	Route::post('subject/update/{id}', [SubjectController::class, 'updateSubject'])->middleware('admin')->name('update.subject');
	Route::get('subject-delete/{id}', [SubjectController::class, 'deleteSuccess'])->middleware('admin')->name('delete.subject');

    Route::post('sign-out', [AuthController::class, 'singOut'])->name('logout');

    // Route::get('admin-optimize', function () {
    //     $output = Artisan::call('optimize');
    //     return "<pre>$output</pre>";
    // });
});
