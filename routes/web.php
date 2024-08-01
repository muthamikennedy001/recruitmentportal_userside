<?php

use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\HighestEducationLevelController;
use App\Http\Controllers\HighSchoolEducationController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\JobPostingsController;
use App\Http\Controllers\PersonalDetailsController;
use App\Http\Controllers\ProfessionalQualificationsController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SearchJobController;
use App\Http\Controllers\ShowFormController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware(['attach.api.token', 'verified'])->group(function () {
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');
    Route::get('/myprofile', [UserProfileController::class, 'index'])->name('myprofile');
    Route::post('/storePersonalDetails', [PersonalDetailsController::class, 'store'])->name('storepersonaldetails');
    Route::post('/storeHighSchoolEducationDetails', [HighSchoolEducationController::class, 'store'])->name('storehighschooleducationdetails');
    Route::post('/storeHighestEducationLevelDetails', [HighestEducationLevelController::class, 'store'])->name('storehighesteducationleveldetails');
    Route::post('/storeProfessionalQualifications', [ProfessionalQualificationsController::class, 'store'])->name('storeprofessionalqualificationdetails');

    Route::get('/editPersonalDetails', [PersonalDetailsController::class, 'edit'])->name('editpersonaldetails');
    Route::get('/editProfessionalQualifications', [ProfessionalQualificationsController::class, 'edit'])->name('editprofessionalqualificationdetails');
    Route::get('/editHighestEducationLevelDetails', [HighestEducationLevelController::class, 'edit'])->name('edithighesteducationleveldetails');
    Route::get('/editHighSchoolEducationDetails', [HighSchoolEducationController::class, 'edit'])->name('edithighschooleducationdetails');

    Route::put('/updatePersonalDetails', [PersonalDetailsController::class, 'update'])->name('updatepersonaldetails');
    Route::put('/updateHighSchoolEducationDetails', [HighSchoolEducationController::class, 'update'])->name('updatehighschooleducationdetails');
    Route::put('/updateHighestEducationLevelDetails', [HighestEducationLevelController::class, 'update'])->name('updatehighesteducationleveldetails');
    Route::put('/updateProfessionalQualifications', [ProfessionalQualificationsController::class, 'update'])->name('updateprofessionalqualificationdetails');

    Route::get('/check-user-data/{assessment_id}', [ShowFormController::class, 'showForm'])->name('checkUserData');

    Route::post('/email/verification-notification', [AuthController::class, 'verifyHandler'])->middleware(['throttle:6,1'])->name('verification.send');
    Route::get('/quiz/start', [AssessmentController::class, 'showQuestion'])->middleware('check.test.completed')->name('quiz.start');
    Route::post('/quiz/submit', [AssessmentController::class, 'submitAnswer'])->name('quiz.submit');
    Route::get('/quiz/complete/{assessment_id}', [AssessmentController::class, 'completeQuiz'])->name('quiz.complete');
    Route::get('/myapplications', [ApplicationsController::class, 'getApplicationsByUser'])->name('user.applications');
    Route::get('/myapplication/{id}', [ApplicationsController::class, 'getSpecificJobByApplicationId'])->name('application.details');
    Route::get('/personaldetails', function () {
        $assessment_id = request()->query('assessment_id');
        $job_id = request()->query('job_id');

        return view('users.personaldetails', compact('assessment_id', 'job_id'));
    })->name('personaldetails');


    Route::get('/highschooleducation', function () {
        $assessment_id = request()->query('assessment_id');
        $job_id = request()->query('job_id');
        return view('users.highschooleducation', compact('assessment_id', 'job_id'));
    })->name('highschooleducation');

    Route::get('/highesteducationlevel', function () {
        $assessment_id = request()->query('assessment_id');
        $job_id = request()->query('job_id');
        return view('users.highesteducationlevel', compact('assessment_id', 'job_id'));
    })->name('highesteducationlevel');

    Route::get('/professionalQualification', function () {
        $assessment_id = request()->query('assessment_id');
        $job_id = request()->query('job_id');
        return view('users.professionalqualification', compact('assessment_id', 'job_id'));
    })->name('professionalqualification');
});

//guests routes

Route::resource('posts', JobPostingsController::class);
Route::get('/jobs/search', [SearchJobController::class, 'search'])->name('jobs.search');
Route::get('/jobs', [SearchJobController::class, 'showSearchForm'])->name('jobsindex');
//authenticated users routes
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['attach.api.token'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');


Route::get('/jobs', function () {
    return view('components.jobs');
})->name('jobs');

Route::get('/assessementdone', function () {
    return view('components.assessmentdone');
})->name('assessementdone');

Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');

Route::post('/forgot-password', [ResetPasswordController::class, 'passwordEmail']);

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');

Route::get('/', [HomePageController::class, 'index'])->name('home');


//email verification notice
Route::get('/email/verify', [AuthController::class, 'verifyNotice'])->name('verification.notice');
//verify handler
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');
//resend verification
Route::post('/email/verification-notification', [AuthController::class, 'verifyHandler'])->middleware(['throttle:6,1'])->name('verification.send');
