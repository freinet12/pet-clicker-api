<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PetImageController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

//Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// Route::get('/email/verify', function () {
//     return "you must verify your email.";
// })->middleware('auth:sanctum')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return "email verified successfully";
// })->middleware(['auth:sanctum', 'signed'])->name('verification.verify');



Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'pet-images'], function () {
    /**
     * Pet Images
     */
    Route::get('/', [PetImageController::class, 'index']);
    Route::get('/me', [PetImageController::class, 'userImages']);
    Route::get('/{pet_image}', [PetImageController::class, 'show']);
	Route::post('/upload', [PetImageController::class, 'store']);
    Route::delete('/{pet_image}',  [PetImageController::class, 'destroy']);

    /**
     * Likes
     */
    Route::post('/{pet_image}/like', [LikeController::class, 'store']);
    Route::delete('/likes/{pet_image}', [LikeController::class, 'destroy']);

    /**
     * Comments
     */
    Route::post('/comment', [CommentController::class, 'store']);
    Route::patch('/comment/{id}', [CommentController::class, 'update']);
    Route::delete('/comment/{id}', [CommentController::class, 'destroy']);
});


