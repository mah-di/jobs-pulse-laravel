<?php

use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyPluginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EducationalDetailController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobExperienceController;
use App\Http\Controllers\PluginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SavedJobController;
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

Route::get('/user', [UserController::class, 'getUser'])->name('user.get')->middleware('auth.jwt');
Route::get('/resend-otp', [UserController::class, 'resendVerificationOTP'])->name('resend.otp')->middleware('auth.jwt');
Route::post('/verify-email', [UserController::class, 'verifyEmail'])->name('verify')->middleware('auth.jwt');
Route::post('/request-password-reset', [UserController::class, 'sendPasswordResetOTP']);
Route::post('/verify-reset-otp', [UserController::class, 'verifyPasswordResetOTP']);
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('password.reset')->middleware('auth.jwt');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('password.change')->middleware('auth.jwt');

Route::get('/company/{id}', [CompanyController::class, 'show'])->name('company.show')->middleware('auth.jwt');
Route::post('/company', [CompanyController::class, 'update'])->name('company.update')->middleware('auth.jwt');
Route::get('/company/activity/check', [CompanyController::class, 'isActive'])->name('company.check')->middleware('auth.jwt');
Route::post('/company/activity/{id}', [CompanyController::class, 'updateActivity'])->name('company.update.activity')->middleware('auth.jwt');
Route::post('/company/approve', [CompanyController::class, 'approve'])->name('company.approve')->middleware('auth.jwt');
Route::post('/company/restrict', [CompanyController::class, 'restrict'])->name('company.restrict')->middleware('auth.jwt');

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

Route::post('/job-category', [JobCategoryController::class, 'create'])->name('job.category.create')->middleware('auth.jwt');
Route::post('/job-category/{id}', [JobCategoryController::class, 'update'])->name('job.category.update')->middleware('auth.jwt');
Route::get('/job-category', [JobCategoryController::class, 'index'])->name('job.category.index')->middleware('auth.jwt');
Route::get('/job-category/{id}', [JobCategoryController::class, 'show'])->name('job.category.show')->middleware('auth.jwt');
Route::delete('/job-category/{id}', [JobCategoryController::class, 'delete'])->name('job.category.delete')->middleware('auth.jwt');

Route::post('/job', [JobController::class, 'create'])->name('job.create')->middleware('auth.jwt');
Route::post('/job/{id}', [JobController::class, 'update'])->name('job.update')->middleware('auth.jwt');
Route::post('/job/{id}/availability', [JobController::class, 'updateAvailability'])->name('job.availability.update')->middleware('auth.jwt');
Route::post('/approve-job', [JobController::class, 'approve'])->name('job.approve')->middleware('auth.jwt');
Route::post('/restrict-job', [JobController::class, 'restrict'])->name('job.restrict')->middleware('auth.jwt');
Route::get('/job/{id}', [JobController::class, 'show'])->name('job.show')->middleware('auth.jwt');
Route::get('/job/category/{categoryId}', [JobController::class, 'showAll'])->name('job.showAll')->middleware('auth.jwt');
Route::get('/job', [JobController::class, 'search'])->name('job.search')->middleware('auth.jwt');
Route::get('/company/job', [JobController::class, 'getCompanyJobs'])->name('job.by.company')->middleware('auth.jwt');
Route::get('/jobs-pulse/admin/job/{status}', [JobController::class, 'getJobsByStatus'])->name('job.by.status')->middleware('auth.jwt');
Route::get('/jobs-pulse/admin/count/job', [JobController::class, 'getJobsCount'])->name('job.count')->middleware('auth.jwt');

Route::get('/job-application/{jobId}', [JobApplicationController::class, 'create'])->name('job.application.create')->middleware('auth.jwt');
Route::post('/job-application/{id}/update-status', [JobApplicationController::class, 'updateStatus'])->name('job.application.update')->middleware('auth.jwt');
Route::delete('/job-application/{id}', [JobApplicationController::class, 'delete'])->name('job.application.delete')->middleware('auth.jwt');
Route::get('/job/{id}/applications/count', [JobApplicationController::class, 'receivedApplicationCount'])->name('job.application.count')->middleware('auth.jwt');
Route::get('/job/{id}/applications', [JobApplicationController::class, 'receivedApplications'])->name('job.application.received')->middleware('auth.jwt');
Route::get('/candidate/job-applications', [JobApplicationController::class, 'candidateApplications'])->name('candidate.job.application')->middleware('auth.jwt');

Route::get('/job/save/{jobId}', [SavedJobController::class, 'create'])->name('saved.job.create')->middleware('auth.jwt');
Route::delete('/job/save/{jobId}', [SavedJobController::class, 'delete'])->name('saved.job.delete')->middleware('auth.jwt');
Route::get('/saved-jobs', [SavedJobController::class, 'showAll'])->name('saved.job.showAll')->middleware('auth.jwt');

Route::get('/plugin', [PluginController::class, 'index'])->name('plugin.index')->middleware('auth.jwt');
Route::post('/plugin', [PluginController::class, 'update'])->name('plugin.update')->middleware('auth.jwt');

Route::get('/company-plugin', [CompanyPluginController::class, 'index'])->name('company-plugin.index')->middleware('auth.jwt');
Route::get('/company-plugin/get', [CompanyPluginController::class, 'indexByCompany'])->name('company-plugin.index.get')->middleware('auth.jwt');
Route::get('/company-plugin/{pluginId}/check', [CompanyPluginController::class, 'isActive'])->name('company-plugin.check')->middleware('auth.jwt');
Route::post('/company-plugin', [CompanyPluginController::class, 'save'])->name('company-plugin.save')->middleware('auth.jwt');
Route::post('/company-plugin/approve', [CompanyPluginController::class, 'approve'])->name('company-plugin.approve')->middleware('auth.jwt');
Route::post('/company-plugin/reject', [CompanyPluginController::class, 'reject'])->name('company-plugin.reject')->middleware('auth.jwt');
Route::post('/company-plugin/{id}', [CompanyPluginController::class, 'updateStatus'])->name('company-plugin.update')->middleware('auth.jwt');
Route::delete('/company-plugin/{id}', [CompanyPluginController::class, 'delete'])->name('company-plugin.delete')->middleware('auth.jwt');

Route::get('/blog-category/{companyId}/company', [BlogCategoryController::class, 'index'])->name('blog.category.index')->middleware('auth.jwt');
Route::post('/blog-category', [BlogCategoryController::class, 'save'])->name('blog.category.save')->middleware('auth.jwt');
Route::get('/blog-category/{id}', [BlogCategoryController::class, 'show'])->name('blog.category.show')->middleware('auth.jwt');
Route::delete('/blog-category/{id}', [BlogCategoryController::class, 'delete'])->name('blog.category.delete')->middleware('auth.jwt');

Route::get('/blog/index/{companyId}', [BlogController::class, 'index'])->name('blog.index.by.company')->middleware('auth.jwt');
Route::get('/blog/category/{categoryId}', [BlogController::class, 'indexByCategory'])->name('blog.index.by.category')->middleware('auth.jwt');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show')->middleware('auth.jwt');
Route::post('/blog/create/{categoryId}', [BlogController::class, 'create'])->name('blog.create')->middleware('auth.jwt');
Route::post('/blog/{id}', [BlogController::class, 'update'])->name('blog.update')->middleware('auth.jwt');
Route::delete('/blog/{id}', [BlogController::class, 'delete'])->name('blog.delete')->middleware('auth.jwt');

Route::get('/role', RoleController::class)->name('role.index')->middleware('auth.jwt');

Route::get('/department', [DepartmentController::class, 'index'])->name('department.index')->middleware('auth.jwt');
Route::post('/department', [DepartmentController::class, 'save'])->name('department.save')->middleware('auth.jwt');
Route::delete('/department/{id}', [DepartmentController::class, 'delete'])->name('department.delete')->middleware('auth.jwt');
