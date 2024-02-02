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


/////////// INSERT DB ////////////

/*Insertar 4 Usuarios de manera automatica con GPT*/
Route::get('/createUserGPT', [UserController::class, 'chat']);

/*Insertar 4 Programas y programs prarcipants de manera automatica con GPT*/
Route::get('/createProgramGPT', [ProgramController::class, 'chat']);

/*Insertar 4 Challenger de manera automatica con GPT*/
Route::get('/createChallengeGPT', [ChallengerController::class, 'chat']);

/*Insertar 4 Companie de manera automatica con GPT*/
Route::get('/createCompanieGPT', [CompanyController::class, 'chat']);


///////// CONSULT DB ///////////

/*Consultar usuarios*/
Route::get('/userConsult', [UserController::class, 'indexAll']);

/*Consultar compañias*/
Route::get('/companyConsult', [CompanyController::class, 'indexAll']);

/*Consultar programas*/
Route::get('/programConsult', [ProgramController::class, 'indexAll']);

/*Consultar challenge*/
Route::get('/challengeConsult', [ChallengerController::class, 'indexAll']);



