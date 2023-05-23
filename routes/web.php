<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/save-item-code', 'SearchController@saveItemCode')->name('saveItemCode');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');



Route::post('/save-item-code', [SearchController::class, 'saveItemCode'])->name('saveItemCode');

Route::get('/search/{itemCode}', [ItemController::class, 'search']);

Route::post('/saveItem', 'HomeController@saveItem')->name('saveItem');
