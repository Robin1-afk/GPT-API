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

Route::get('/user', [UserController::class, 'chat']);
Route::get('/user1', [ChallengerController::class, 'index']);
Route::get('/user2', [CompanyController::class, 'index']);
Route::get('/user3', [ProgramController::class, 'index']);


