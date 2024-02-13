<?php

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

Route::post('/verify-email', [UserController::class, 'verifyEmail'])->middleware('auth.jwt');
