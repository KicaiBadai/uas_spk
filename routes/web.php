<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\TopsisController;
use App\Http\Controllers\DashboardController;


Route::get('/', [DashboardController::class, 'index']);

Route::resource('schools', SchoolController::class);
Route::resource('players', PlayerController::class);
Route::resource('criteria', CriterionController::class);

Route::get('/assessments', [AssessmentController::class, 'index']);
Route::post('/assessments', [AssessmentController::class, 'store']);

Route::get('/topsis', [TopsisController::class, 'index']);
Route::post('/topsis/calculate', [TopsisController::class, 'calculate']);