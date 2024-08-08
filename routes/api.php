<?php

use App\Http\Controllers\Generate\ImageGenerateController;
use App\Http\Controllers\Generate\ImageToImageController;
use App\Http\Controllers\Generate\TextToImageController;
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

Route::prefix('generate')->name('generate.')->group(function () {
    Route::post('img', [ImageGenerateController::class, 'generate']);
    Route::post('img/queue', [ImageGenerateController::class, 'queue']);
    Route::post('img/queue/from-prompt', [ImageGenerateController::class, 'queueFromPrompt',]);
    Route::post('img/queue/custom', [ImageGenerateController::class, 'queueCustom',]);

    Route::post('img2img/queue', [ImageToImageController::class, 'queue']);
    Route::post('txt2img/queue', [TextToImageController::class, 'queue']);
});
