<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;

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

Route::get('getBoard', 'BoardController@getBoard');
Route::post('updateColumnTitle', 'BoardController@updateColumnTitle');
Route::post('addColumn', 'BoardController@addColumn');
Route::delete('delColumn/{id}', 'BoardController@delColumn');
Route::post('addCard', 'BoardController@addCard');
Route::post('updateCardItem', 'BoardController@updateCardItem');
Route::post('updateCardLoc', 'BoardController@updateCardLoc');
Route::get('exportDB', 'BoardController@exportDB');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
