<?php

use App\Http\Controllers\ContinentsController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::post('/sanctum/csrf-cookie', TokenController::class);
Route::post('/logout', fn () => Auth::logout());
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/countries/{continent}/{sorting}', [CountryController::class, 'index'])->name('countries.index');
    Route::get('/country/{id}', [CountryController::class, 'show']);
    Route::post('/country/create', [CountryController::class, 'store']);
    Route::get('/continents', [ContinentsController::class, 'index']);
});
