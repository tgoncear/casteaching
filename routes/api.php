<?php

use App\Http\Controllers\SanctumTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeriesApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/videos',[\App\Http\Controllers\VideosApiController::class,'index']);
Route::get('/videos/{id}',[\App\Http\Controllers\VideosApiController::class,'show']);
Route::middleware(['auth:sanctum','verified'])->group(function(){
    Route::post('/videos',[\App\Http\Controllers\VideosApiController::class,'store'])->middleware(['can:videos_manage_store']);
    Route::delete('/videos/{id}',[\App\Http\Controllers\VideosApiController::class,'destroy'])->middleware(['can:videos_manage_destroy']);
    Route::put('/videos/{id}',[\App\Http\Controllers\VideosApiController::class,'update'])->middleware(['can:videos_manage_update']);
});
Route::post('/sanctum/token',\App\Http\Controllers\SanctumTokenController::class);

Route::get('/series', [ SeriesApiController::class,'index']);
Route::get('/series/{id}', [ SeriesApiController::class,'show']);
