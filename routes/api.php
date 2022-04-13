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

Route::group(['as' => 'admin'], function () {
    Route::post('/login', 'AuthAdminController@login');
});

Route::group(['as' => 'user'], function () {
    #yadnya
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

    #kidung
    Route::get('/listkidungterbaru','KidungListController@listKidungTerbaru');
    Route::get('/listallkidung','KidungListController@listAllKidung');
    Route::get('/detailkidung/{id_post}','KidungListController@detailKidung');
    Route::get('/detailbaitkidung/{id_post}','KidungListController@detailBaitKidung');

    #mantram
    Route::get('/listmantramterbaru','MantramListController@listMantramTerbaru');
    Route::get('/listallmantram','MantramListController@listAllMantram');
    Route::get('/detailmantram/{id_post}','MantramListController@detailMantram');

    #tari
    Route::get('/listalltari','TariListController@listAllTari');
    Route::get('/detailtari/{id_post}','TariListController@detailTari');
    Route::get('/detailtabuhtari/{id_post}','TariListController@detailTabuhTari');

    #tabuh
    Route::get('/listalltabuh','TabuhListController@listAllTabuh');
    Route::get('/detailtabuh/{id_post}','TabuhListController@detailTabuh');

    #gamelan
    Route::get('/listallgamelan','GamelanListController@listAllGamelan');
    Route::get('/detailgamelan/{id_post}','GamelanListController@detailGamelan');
    Route::get('/detailtabuhgamelan/{id_post}','GamelanListController@detailTabuhGamelan');

    #prosesi
    Route::get('/listallprosesi','ProsesiListController@listAllProsesi');
    Route::get('/detailprosesi/{id_post}','ProsesiListController@detailProsesi');

});

Route::group(['as' => 'admin'], function () {
    #yadnya
    Route::get('/admin/listyadnya','Admin\HomeController@listYadnyaMaster');

    Route::get('/detailprosesicr/{id_parent_post}/{id_post}','ProsesiListController@detailGamelanProsesiCopyReference');
    Route::get('/detailprosesi/{id_post}','ProsesiListController@detailGamelanProsesi');
});