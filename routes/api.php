<?php

use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyPluginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EducationalDetailController;
use App\Http\Controllers\EmployeeController;
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
use App\Models\Blog;
use App\Models\Company;
use App\Models\EducationalDetail;
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

Route::post('/request-password-reset', [UserController::class, 'sendPasswordResetOTP']);
Route::post('/verify-reset-otp', [UserController::class, 'verifyPasswordResetOTP']);

Route::get('/company/{id}', [CompanyController::class, 'show'])->name('company.show');

Route::get('/job-category', [JobCategoryController::class, 'index'])->name('job.category.index');
Route::get('/job-category/{id}', [JobCategoryController::class, 'show'])->name('job.category.show');

Route::get('/job/{id}', [JobController::class, 'show'])->name('job.show');
Route::get('/job/category/{categoryId}', [JobController::class, 'showAll'])->name('job.showAll');
Route::get('/job', [JobController::class, 'search'])->name('job.search');
Route::get('/company-job', [JobController::class, 'getCompanyJobs'])->name('job.by.company');

Route::get('/job/{id}/applications/count', [JobApplicationController::class, 'receivedApplicationCount'])->name('job.application.count');

Route::get('/blog-category/{companyId}/company', [BlogCategoryController::class, 'index'])->name('blog.category.index');
Route::get('/blog-category/{id}', [BlogCategoryController::class, 'show'])->name('blog.category.show');

Route::get('/blog/index/{companyId}', [BlogController::class, 'index'])->name('blog.index.by.company');
Route::get('/blog/category/{categoryId}', [BlogController::class, 'indexByCategory'])->name('blog.index.by.category');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');

Route::middleware('auth.jwt')->group(function () {
    Route::get('/user', [UserController::class, 'getUser'])->name('user.get');
    Route::get('/resend-otp', [UserController::class, 'resendVerificationOTP'])->name('resend.otp');
    Route::post('/verify-email', [UserController::class, 'verifyEmail'])->name('verify');
    Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('password.reset');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('password.change');

    Route::get('/education/{education}', [EducationalDetailController::class, 'show'])->name('education.show')->can('view', 'education');
    Route::get('/candidate/education/{profile}', [EducationalDetailController::class, 'showAll'])->name('education.showAll')->can('showQualifications', 'profile');

    Route::get('/training/{training}', [TrainingController::class, 'show'])->name('training.show')->can('view', 'training');
    Route::get('/candidate/training/{profile}', [TrainingController::class, 'showAll'])->name('training.showAll')->can('showQualifications', 'profile');

    Route::get('/job-experience/{experience}', [JobExperienceController::class, 'show'])->name('job.experience.show')->can('view', 'experience');
    Route::get('/candidate/job-experience/{profile}', [JobExperienceController::class, 'showAll'])->name('job.experience.showAll')->can('showQualifications', 'profile');

    Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');

    Route::middleware('superUser.check')->group(function () {
        Route::post('/company/approve', [CompanyController::class, 'approve'])->name('company.approve')->can('takeImportantDecision', Company::class);
        Route::post('/company/restrict', [CompanyController::class, 'restrict'])->name('company.restrict')->can('takeImportantDecision', Company::class);

        Route::post('/department', [DepartmentController::class, 'save'])->name('department.save');
        Route::delete('/department/{id}', [DepartmentController::class, 'delete'])->name('department.delete')->can('takeImportantDecision', Company::class);

        Route::post('/plugin', [PluginController::class, 'update'])->name('plugin.update')->can('takeVeryImportantDecision', Company::class);

        Route::post('/job-category', [JobCategoryController::class, 'create'])->name('job.category.create');
        Route::post('/job-category/{id}', [JobCategoryController::class, 'update'])->name('job.category.update');
        Route::delete('/job-category/{id}', [JobCategoryController::class, 'delete'])->name('job.category.delete')->can('takeImportantDecision', Company::class);

        Route::post('/approve-job', [JobController::class, 'approve'])->name('job.approve')->can('takeImportantDecision', Company::class);
        Route::post('/restrict-job', [JobController::class, 'restrict'])->name('job.restrict')->can('takeImportantDecision', Company::class);
        Route::get('/jobs-pulse/admin/job/{status}', [JobController::class, 'getJobsByStatus'])->name('job.by.status');
        Route::get('/jobs-pulse/admin/count/job', [JobController::class, 'getJobsCount'])->name('job.count');

        Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index')->can('takeVeryImportantDecision', Company::class);

        Route::get('/company-plugin', [CompanyPluginController::class, 'index'])->name('company-plugin.index')->can('takeImportantDecision', Company::class);
        Route::post('/company-plugin/approve', [CompanyPluginController::class, 'approve'])->name('company-plugin.approve')->can('takeImportantDecision', Company::class);
        Route::post('/company-plugin/reject', [CompanyPluginController::class, 'reject'])->name('company-plugin.reject')->can('takeImportantDecision', Company::class);
        Route::delete('/company-plugin/{id}', [CompanyPluginController::class, 'delete'])->name('company-plugin.delete')->can('takeVeryImportantDecision', Company::class);
    });

    Route::middleware('companyUser.check')->group(function () {
        Route::post('/company', [CompanyController::class, 'update'])->name('company.update')->can('takeManagerialDecision', Company::class);
        Route::post('/company/activity/{company}', [CompanyController::class, 'updateActivity'])->name('company.update.activity')->can('updateActivity', 'company');

        Route::post('/job', [JobController::class, 'create'])->name('job.create')->can('takeManagerialDecision', Company::class);
        Route::post('/job/{job}', [JobController::class, 'update'])->name('job.update')->can('update', 'job');
        Route::post('/job/{job}/availability', [JobController::class, 'updateAvailability'])->name('job.availability.update')->can('updateAvailability', 'job');

        Route::post('/job-application/{application}/update-status', [JobApplicationController::class, 'updateStatus'])->name('job.application.update')->can('update', 'application');
        Route::get('/job/{job}/applications', [JobApplicationController::class, 'receivedApplications'])->name('job.application.received')->can('viewApplications', 'job');

        Route::get('/company/activity/check', [CompanyController::class, 'isActive'])->name('company.check');

        Route::get('/company-plugin/get', [CompanyPluginController::class, 'indexByCompany'])->name('company-plugin.index.get');
        Route::get('/company-plugin/{plugin}/check', [CompanyPluginController::class, 'isActive'])->name('company-plugin.check');
        Route::post('/company-plugin', [CompanyPluginController::class, 'save'])->name('company-plugin.save')->can('takeAdminDecision', Company::class);
        Route::post('/company-plugin/{plugin}', [CompanyPluginController::class, 'updateStatus'])->name('company-plugin.update')->can('updateStatus', 'plugin');
    });

    Route::middleware('restrict.candidate')->group(function () {
        Route::get('/user/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::post('/user/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/company-employee', [EmployeeController::class, 'indexByCompany'])->name('employee.index.by.company');
        Route::post('/employee', [EmployeeController::class, 'create'])->name('employee.create')->can('createEmployees', Company::class);
        Route::post('/employee/{user}', [EmployeeController::class, 'assignRole'])->name('employee.assign.role')->can('updateOrDeleteEmployees', [Company::class, 'user']);
        Route::delete('/employee/{user}', [EmployeeController::class, 'delete'])->name('employee.delete')->can('updateOrDeleteEmployees', [Company::class, 'user']);

        Route::get('/role', RoleController::class)->name('role.index');

        Route::post('/blog-category', [BlogCategoryController::class, 'save'])->name('blog.category.save');
        Route::delete('/blog-category/{category}', [BlogCategoryController::class, 'delete'])->name('blog.category.delete')->can('delete', 'category');

        Route::post('/blog/create/{category}', [BlogController::class, 'create'])->name('blog.create')->can('create', [Blog::class, 'category']);
        Route::post('/blog/{blog}', [BlogController::class, 'update'])->name('blog.update')->can('update', 'blog');
        Route::delete('/blog/{blog}', [BlogController::class, 'delete'])->name('blog.delete')->can('delete', 'blog');

        Route::get('/plugin', [PluginController::class, 'index'])->name('plugin.index');
    });

    Route::middleware('candidate.check')->group(function () {
        Route::get('/candidate/profile', [CandidateProfileController::class, 'show'])->name('candidate.profile.show');
        Route::post('/candidate/profile', [CandidateProfileController::class, 'save'])->name('candidate.profile.save');

        Route::middleware('check.profile')->group(function () {
            Route::post('/education', [EducationalDetailController::class, 'save'])->name('education.save');

            Route::post('/training', [TrainingController::class, 'create'])->name('training.create');
            Route::post('/training/{training}', [TrainingController::class, 'update'])->name('training.update')->can('updateOrDelete', 'training');
            Route::delete('/training/{id}', [TrainingController::class, 'delete'])->name('training.delete')->can('updateOrDelete', 'training');

            Route::post('/job-experience', [JobExperienceController::class, 'create'])->name('job.experience.create');
            Route::post('/job-experience/{experience}', [JobExperienceController::class, 'update'])->name('job.experience.update')->can('updateOrDelete', 'experience');
            Route::delete('/job-experience/{experience}', [JobExperienceController::class, 'delete'])->name('job.experience.delete')->can('updateOrDelete', 'experience');

            Route::get('/job-application/{jobId}', [JobApplicationController::class, 'create'])->name('job.application.create');
            Route::get('/candidate/job-applications', [JobApplicationController::class, 'candidateApplications'])->name('candidate.job.application');
            Route::delete('/job-application/{id}', [JobApplicationController::class, 'delete'])->name('job.application.delete')->can('delete', 'application');
        });

        Route::get('/job/save/{jobId}', [SavedJobController::class, 'create'])->name('saved.job.create');
        Route::get('/saved-jobs', [SavedJobController::class, 'showAll'])->name('saved.job.showAll');
        Route::delete('/saved-jobs/{jobId}', [SavedJobController::class, 'delete'])->name('saved.job.delete');
        Route::delete('/saved-jobs', [SavedJobController::class, 'deleteAll'])->name('saved.job.deleteAll');
    });
});
