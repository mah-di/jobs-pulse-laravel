<?php

use App\Http\Controllers\UserController;
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

Route::get('/', fn () => view('pages.index'))->name('home.view');

Route::get('/signup', fn () => view('pages.auth.signup'))->name('signup.view');
Route::get('/login', fn () => view('pages.auth.login'))->name('login.view');
Route::get('/jobs-pulse/super-user/login', fn () => view('pages.auth.superuser-login'))->name('superUser.login.view');
Route::get('/send-otp', fn () => view('pages.auth.send-otp'))->name('send.otp.view');
Route::get('/verify-otp', fn () => view('pages.auth.verify-reset-otp'))->name('verify.otp.view');

Route::get('/jobs', fn () => view('pages.jobs'))->name('jobs.view');
Route::get('/job/{id}', fn ($id) => view('pages.job-details'))->name('job.details.view');
Route::get('/company/{id}', fn ($id) => view('pages.company'))->name('company.view');

Route::middleware(['redirect.anon', 'auth.jwt'])->group(function () {

    Route::get('/verify', fn () => view('pages.auth.verify'))->name('verify.view');
    Route::get('/reset-password', fn () => view('pages.auth.reset-password'))->name('password.reset.view');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/candidate/profile', fn () => view('pages.candidate.profile'))->name('candidate.profile.view');
    Route::get('/candidate/dashboard', fn () => view('pages.candidate.dashboard'))->name('candidate.dashboard.view');
    Route::get('/candidate/applications', fn () => view('pages.candidate.job-applications'))->name('candidate.applications.view');
    Route::get('/candidate/saved-jobs', fn () => view('pages.candidate.saved-jobs'))->name('candidate.savedJobs.view');

});
