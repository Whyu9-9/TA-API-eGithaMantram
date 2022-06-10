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

    #admin
    Route::get('/admin/listadmin', 'Admin\AdminController@index');
    Route::get('/admin/detailadmin/{id_user}', 'Admin\AdminController@getDetailAdmin');
    Route::post('/admin/createadmin', 'Admin\AdminController@createAdmin');
    Route::post('/admin/editadmin/{id_user}', 'Admin\AdminController@editAdmin');
    Route::post('/admin/deleteadmin/{id_user}', 'Admin\AdminController@deleteAdmin');

    #tabuh
    Route::get('/admin/listalltabuhadmin', 'Admin\TabuhController@listAllTabuhAdmin');
    Route::get('/admin/detailtabuhadmin/{id_post}', 'Admin\TabuhController@detailTabuhAdmin');
    Route::post('/admin/createtabuh', 'Admin\TabuhController@createTabuh');
    Route::get('/admin/showtabuh/{id_post}','Admin\TabuhController@showTabuh');
    Route::post('/admin/edittabuh/{id_post}', 'Admin\TabuhController@updateTabuh');
    Route::post('/admin/deletetabuh/{id_post}', 'Admin\TabuhController@deleteTabuh');
    
    #kidung
    Route::get('/admin/listallkidungadmin', 'Admin\KidungController@listAllKidungAdmin');
    Route::get('/admin/detailkidungadmin/{id_post}', 'Admin\KidungController@detailKidungAdmin');
    Route::get('/admin/listlirikkidungadmin/{id_post}', 'Admin\KidungController@detailBaitKidungAdmin');
    Route::post('/admin/createkidung', 'Admin\KidungController@createKidung');
    Route::get('/admin/showkidung/{id_post}','Admin\KidungController@showKidung');
    Route::post('/admin/editkidung/{id_post}', 'Admin\KidungController@updateKidung');
    Route::post('/admin/deletekidung/{id_post}', 'Admin\KidungController@deleteKidung');

    Route::get('/admin/lirikkidungadmin/{id_post}', 'Admin\KidungController@listBaitKidungAdmin');
    Route::post('/admin/addlirikkidung/{id_post}', 'Admin\KidungController@addLirikKidung');
    Route::get('/admin/showlirikkidung/{id_det_post}','Admin\KidungController@showLirikKidung');
    Route::post('/admin/editlirikkidung/{id_det_post}', 'Admin\KidungController@updateLirikKidung');
    Route::post('/admin/deletelirikkidung/{id_det_post}', 'Admin\KidungController@deleteLirikKidung');

    #gamelan
    Route::get('/admin/listallgamelanadmin', 'Admin\GamelanController@listAllGamelanAdmin');
    Route::get('/admin/detailgamelanadmin/{id_post}', 'Admin\GamelanController@detailGamelanAdmin');
    Route::post('/admin/creategamelan', 'Admin\GamelanController@createGamelan');
    Route::get('/admin/showgamelan/{id_post}','Admin\GamelanController@showGamelan');
    Route::post('/admin/editgamelan/{id_post}', 'Admin\GamelanController@updateGamelan');
    Route::post('/admin/deletegamelan/{id_post}', 'Admin\GamelanController@deleteGamelan');
    
    Route::get('/admin/listtabuhongamelan/{id_post}', 'Admin\GamelanController@listAllTabuhGamelanAdmin');
    Route::get('/admin/listtabuhnotongamelan/{id_post}', 'Admin\GamelanController@listAllTabuhNotYetOnGamelan');
    Route::post('/admin/addtabuhongamelan/{id_post}', 'Admin\GamelanController@addTabuhToGamelan');
    Route::post('/admin/deletetabuhongamelan/{id_post}', 'Admin\GamelanController@deleteTabuhFromGamelan');

    #tari
    Route::get('/admin/listalltariadmin', 'Admin\TariController@listAllTariAdmin');
    Route::get('/admin/detailtariadmin/{id_post}', 'Admin\TariController@detailTariAdmin');
    Route::post('/admin/createtari', 'Admin\TariController@createTari');
    Route::get('/admin/showtari/{id_post}','Admin\TariController@showTari');
    Route::post('/admin/edittari/{id_post}', 'Admin\TariController@updateTari');
    Route::post('/admin/deletetari/{id_post}', 'Admin\TariController@deleteTari');
    
    Route::get('/admin/listtabuhontari/{id_post}', 'Admin\TariController@listAllTabuhTariAdmin');
    Route::get('/admin/listtabuhnotontari/{id_post}', 'Admin\TariController@listAllTabuhNotYetOnTari');
    Route::post('/admin/addtabuhontari/{id_post}', 'Admin\TariController@addTabuhToTari');
    Route::post('/admin/deletetabuhontari/{id_post}', 'Admin\TariController@deleteTabuhFromTari');

    #prosesi
    Route::get('/admin/listallprosesiadmin', 'Admin\ProsesiController@listAllProsesiAdmin');
    Route::get('/admin/detailprosesiadmin/{id_post}', 'Admin\ProsesiController@detailProsesiAdmin');
    Route::post('/admin/createprosesi', 'Admin\ProsesiController@createProsesi');
    Route::get('/admin/showprosesi/{id_post}','Admin\ProsesiController@showProsesi');
    Route::post('/admin/editprosesi/{id_post}', 'Admin\ProsesiController@updateProsesi');
    Route::post('/admin/deleteprosesi/{id_post}', 'Admin\ProsesiController@deleteProsesi');

    Route::get('/admin/listgamelanonprosesi/{id_post}', 'Admin\ProsesiController@listAllGamelanProsesiAdmin');

    Route::get('/admin/listgamelannotonprosesi/{id_post}', 'Admin\ProsesiController@listAllGamelanNotYetOnProsesi');
    Route::post('/admin/addgamelanonprosesi/{id_post}', 'Admin\ProsesiController@addGamelanToProsesi');
    Route::post('/admin/deletegamelanonprosesi/{id_post}', 'Admin\ProsesiController@deleteGamelanFromProsesi');

    Route::get('/admin/listtarionprosesi/{id_post}', 'Admin\ProsesiController@listAllTariProsesiAdmin');

    Route::get('/admin/listtarinotonprosesi/{id_post}', 'Admin\ProsesiController@listAllTariNotYetOnProsesi');
    Route::post('/admin/addtarionprosesi/{id_post}', 'Admin\ProsesiController@addTariToProsesi');
    Route::post('/admin/deletetarionprosesi/{id_post}', 'Admin\ProsesiController@deleteTariFromProsesi');

    Route::get('/admin/listkidungonprosesi/{id_post}', 'Admin\ProsesiController@listAllKidungProsesiAdmin');

    Route::get('/admin/listkidungnotonprosesi/{id_post}', 'Admin\ProsesiController@listAllKidungNotYetOnProsesi');
    Route::post('/admin/addkidungonprosesi/{id_post}', 'Admin\ProsesiController@addKidungToProsesi');
    Route::post('/admin/deletekidungonprosesi/{id_post}', 'Admin\ProsesiController@deleteKidungFromProsesi');

    Route::get('/admin/listtabuhonprosesi/{id_post}', 'Admin\ProsesiController@listAllTabuhProsesiAdmin');

    Route::get('/admin/listtabuhnotonprosesi/{id_post}', 'Admin\ProsesiController@listAllTabuhNotYetOnProsesi');
    Route::post('/admin/addtabuhonprosesi/{id_post}', 'Admin\ProsesiController@addTabuhToProsesi');
    Route::post('/admin/deletetabuhonprosesi/{id_post}', 'Admin\ProsesiController@deleteTabuhFromProsesi');

    Route::get('/admin/listmantramonprosesi/{id_post}', 'Admin\ProsesiController@listAllMantramProsesiAdmin');

    Route::get('/admin/listmantramnotonprosesi/{id_post}', 'Admin\ProsesiController@listAllMantramNotYetOnProsesi');
    Route::post('/admin/addmantramonprosesi/{id_post}', 'Admin\ProsesiController@addMantramToProsesi');
    Route::post('/admin/deletemantramonprosesi/{id_post}', 'Admin\ProsesiController@deleteMantramFromProsesi');

    #yadnyaHome
    Route::get('/admin/listyadnya','Admin\HomeController@listYadnyaMaster');
    Route::get('/admin/yadnya/{nama_yadnya}','Admin\HomeController@selectedHomeYadnya');

    #mantram
    Route::get('/admin/listallmantram','Admin\MantramController@listAllMantramAdmin');
    Route::get('/admin/detailmantram/{id_post}','Admin\MantramController@detailMantramAdmin');
    Route::post('/admin/createmantram','Admin\MantramController@createMantram');
    Route::get('/admin/showmantram/{id_post}','Admin\MantramController@showMantram');
    Route::post('/admin/updatemantram/{id_post}','Admin\MantramController@updateMantram');
    Route::post('/admin/deletemantram/{id_post}','Admin\MantramController@deleteMantram');
    Route::post('/admin/deletemantram/{id_post}','Admin\MantramController@deleteMantram');
    Route::post('/admin/editbaitmantram/{id_post}','Admin\MantramController@editBait');
    Route::post('/admin/editartimantram/{id_post}','Admin\MantramController@editArti');
});

Route::group(['as' => 'user'], function () {
    #yadnya
    Route::get('/yadnya/{nama_yadnya}','YadnyaListController@selectedCardYadnya');
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
    Route::get('/detailgamelanprosesi/{id_post}','ProsesiListController@detailGamelan');
    Route::get('/detailkidungprosesi/{id_post}','ProsesiListController@detailKidung');
    Route::get('/detailtariprosesi/{id_post}','ProsesiListController@detailTari');
    Route::get('/detailtabuhprosesi/{id_post}','ProsesiListController@detailTabuh');
    Route::get('/detailmantramprosesi/{id_post}','ProsesiListController@detailMantram');

    Route::get('/prosesicr/{id_parent_post}/{id_post}','ProsesiListController@detailProsesiCopyReference');
    Route::get('/detailgamelanprosesicr/{id_parent_post}/{id_post}','ProsesiListController@detailGamelanProsesiCopyReference');
    Route::get('/detailprosesigamelancr/{id_post}','ProsesiListController@detailGamelanProsesi');

});