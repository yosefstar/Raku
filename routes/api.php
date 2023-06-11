<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\SearchController;
use App\Http\Controllers\Api\WantListController;
use App\Http\Controllers\Api\SearchGenreController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/save-item-code', [SearchController::class, 'saveItemCode'])->name('saveItemCode');

Route::post('/update-want-status', [WantListController::class, 'updateWantStatus'])->name('api.update_want_status');

Route::get('/search-genre', [SearchGenreController::class, 'index'])->name('searchGenre');
