<?php

use App\Http\Controllers\Api\BoardController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LeaderboardController;
use Illuminate\Http\Request;
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

Route::post('/auth/', [AuthController::class, 'store'])->name('auth');

Route::resource('board', BoardController::class, [
    'only' => ['store', 'show', 'update']
]);

Route::controller(BoardController::class)->group(function() {
    Route::get('/board/over/{id}', 'over')->name('board.over');
    Route::get('/board/next/{id}', 'next')->name('board.next');
});
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
