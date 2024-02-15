<?php

use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\EducationalDetailController;
use App\Http\Controllers\JobExperienceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/jobs-pulse/admin/login', [UserController::class, 'loginSuperUser']);

Route::post('/company/register', [UserController::class, 'registerCompany']);
Route::post('/company/login', [UserController::class, 'loginCompany']);

Route::post('/candidate/register', [UserController::class, 'registerCandidate']);
Route::post('/candidate/login', [UserController::class, 'loginCandidate']);

Route::get('/resend-otp', [UserController::class, 'resendVerificationOTP'])->name('resend.otp')->middleware('auth.jwt');
Route::post('/verify-email', [UserController::class, 'verifyEmail'])->name('verify')->middleware('auth.jwt');
Route::post('/request-password-reset', [UserController::class, 'sendPasswordResetOTP']);
Route::post('/verify-reset-otp', [UserController::class, 'verifyPasswordResetOTP']);
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('password.reset')->middleware('auth.jwt');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('password.change')->middleware('auth.jwt');

Route::get('/user/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth.jwt');
Route::post('/user/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth.jwt');
Route::get('/candidate/profile', [CandidateProfileController::class, 'show'])->name('candidate.profile.show')->middleware('auth.jwt');
Route::post('/candidate/profile', [CandidateProfileController::class, 'save'])->name('candidate.profile.save')->middleware('auth.jwt');

Route::post('/education', [EducationalDetailController::class, 'save'])->name('education.save')->middleware('auth.jwt');
Route::get('/education/{id}', [EducationalDetailController::class, 'show'])->name('education.show')->middleware('auth.jwt');
Route::get('/candidate/education/{profileId}', [EducationalDetailController::class, 'showAll'])->name('education.showAll')->middleware('auth.jwt');

Route::post('/training', [TrainingController::class, 'create'])->name('training.create')->middleware('auth.jwt');
Route::post('/training/{id}', [TrainingController::class, 'update'])->name('training.update')->middleware('auth.jwt');
Route::get('/training/{id}', [TrainingController::class, 'show'])->name('training.show')->middleware('auth.jwt');
Route::get('/candidate/training/{profileId}', [TrainingController::class, 'showAll'])->name('training.showAll')->middleware('auth.jwt');
Route::delete('/training/{id}', [TrainingController::class, 'delete'])->name('training.delete')->middleware('auth.jwt');

Route::post('/job-experience', [JobExperienceController::class, 'create'])->name('job.experience.create')->middleware('auth.jwt');
Route::post('/job-experience/{id}', [JobExperienceController::class, 'update'])->name('job.experience.update')->middleware('auth.jwt');
Route::get('/job-experience/{id}', [JobExperienceController::class, 'show'])->name('job.experience.show')->middleware('auth.jwt');
Route::get('/candidate/job-experience/{profileId}', [JobExperienceController::class, 'showAll'])->name('job.experience.showAll')->middleware('auth.jwt');
Route::delete('/job-experience/{id}', [JobExperienceController::class, 'delete'])->name('job.experience.delete')->middleware('auth.jwt');
