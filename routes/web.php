<?php

use App\Http\Controllers\UserController;
use App\Models\Company;
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

    Route::middleware('companyUser.check')->group(function () {
        Route::get('/company-dashboard', fn () => view('pages.company-admin.dashboard'))->name('company.dashboard.view');
        Route::get('/company-dashboard/company', fn () => view('pages.company-admin.company'))->name('company.view');
        Route::get('/company-dashboard/blog', fn () => view('pages.company-admin.blog'))->name('company.blog.view');
        Route::get('/company-dashboard/jobs', fn () => view('pages.company-admin.jobs'))->name('company.jobs.view');
        Route::get('/company-dashboard/employees', fn () => view('pages.company-admin.employees'))->name('company.employees.view');
        Route::get('/company-dashboard/applications', fn () => view('pages.company-admin.applications'))->name('company.applications.view')->can('takeManagerialDecision', Company::class);
        Route::get('/company-dashboard/profile', fn () => view('pages.company-admin.profile'))->name('profile.view');
        Route::get('/company-dashboard/plugins', fn () => view('pages.company-admin.plugins'))->name('company.plugins.view')->can('takeAdminDecision', Company::class);
    });

    Route::middleware('candidate.check')->group(function () {
        Route::get('/candidate/profile', fn () => view('pages.candidate.profile'))->name('candidate.profile.view');
        Route::get('/candidate/dashboard', fn () => view('pages.candidate.dashboard'))->name('candidate.dashboard.view');
        Route::get('/candidate/applications', fn () => view('pages.candidate.job-applications'))->name('candidate.applications.view');
        Route::get('/candidate/saved-jobs', fn () => view('pages.candidate.saved-jobs'))->name('candidate.savedJobs.view');
    });

});
