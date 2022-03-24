<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login', 'AuthAdminController@login');

Route::get('/listyadnya','YadnyaListController@listYadnyaMaster');
Route::get('/listallyadnya','YadnyaListController@listAllYadnya');
Route::get('/listyadnyaterbaru','YadnyaListController@listYadnyaTerbaru');
Route::get('/detailyadnya/{id_post}','YadnyaListController@detailYadnya');
Route::get('/detailawal/{id_post}','YadnyaListController@detailAwal');
Route::get('/detailpuncak/{id_post}','YadnyaListController@detailPuncak');
Route::get('/detailakhir/{id_post}','YadnyaListController@detailAkhir');
Route::get('/detailgamelanyadnya/{id_post}','YadnyaListController@detailGamelan');
Route::get('/detailtariyadnya/{id_post}','YadnyaListController@detailTari');
Route::get('/detailkidungyadnya/{id_post}','YadnyaListController@detailKidung');


Route::get('/listkidungterbaru','KidungListController@listKidungTerbaru');
Route::get('/listallkidung','KidungListController@listAllKidung');
Route::get('/detailkidung/{id_post}','KidungListController@detailKidung');
Route::get('/detailbaitkidung/{id_post}','KidungListController@detailBaitKidung');

Route::get('/listmantramterbaru','MantramListController@listMantramTerbaru');
Route::get('/listallmantram','MantramListController@listAllMantram');
Route::get('/detailmantram/{id_post}','MantramListController@detailMantram');