<?php

use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');



Route::post('/save-itemcode', [SearchController::class, 'saveItemCode'])->name('saveItemCode');



Route::post('/saveItem', [HomeController::class, 'saveItem'])->name('saveItem');

// web.php もしくは routes.php などのルート定義ファイルで定義する
Route::post('/want-item', [HomeController::class, 'wantItem'])->name('wantItem');


Route::post('/have-item', [HomeController::class, 'haveItem'])->name('haveItem');

Route::get('/ranking', [HomeController::class, 'showRanking'])->name('showRanking');


Route::put('/item', [HomeController::class, 'updateWantStatus'])->name('updateWantStatus');

Route::get('/items', [HomeController::class, 'getItems'])->name('getItems');

Route::post('/update-want-status', [HomeController::class, 'updateWantStatus'])->name('updateWantStatus');

Route::post('/check_duplicate_and_update_status', [HomeController::class, 'checkDuplicateAndUpdateStatus']);
