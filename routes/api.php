<?php

use App\Http\Controllers\ChallengerController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProgramController;
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

Route::get('/createUserGPT', [UserController::class, 'chat']);

Route::get('/createProgramGPT', [ProgramController::class, 'chat']);

Route::get('/createChallengeGPT', [ChallengerController::class, 'chat']);

Route::get('/createCompanieGPT', [CompanyController::class, 'chat']);


Route::get('/userConsult', [UserController::class, 'indexAll']);
Route::get('/companyConsult', [CompanyController::class, 'indexAll']);
Route::get('/programConsult', [ProgramController::class, 'indexAll']);
Route::get('/challengeConsult', [ChallengerController::class, 'indexAll']);



