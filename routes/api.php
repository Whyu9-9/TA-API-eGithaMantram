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
    Route::post('/logout', 'AuthAdminController@logout');

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

    Route::get('/admin/listprosesikhusus/{id_prosesi}/{id_yadnya}', 'Admin\ProsesiController@listAllProsesiKhususAdmin');

    Route::get('/admin/listprosesikhususnotyet/{id_prosesi}/{id_yadnya}', 'Admin\ProsesiController@listAllProsesiKhususNotYetAdmin');
    Route::post('/admin/addprosesikhusus/{id_prosesi}/{id_yadnya}', 'Admin\ProsesiController@addProsesiKhusus');
    Route::post('/admin/deleteprosesikhusus/{id}', 'Admin\ProsesiController@deleteProsesiKhusus');

    #yadnya
    Route::get('/admin/listallyadnyaadmin/{id_yadnya}', 'Admin\YadnyaController@listAllYadnyaAdmin');
    Route::get('/admin/detailyadnyaadmin/{id_post}', 'Admin\YadnyaController@detailYadnyaAdmin');
    Route::post('/admin/createyadnya', 'Admin\YadnyaController@createYadnya');
    Route::get('/admin/showyadnya/{id_post}','Admin\YadnyaController@showYadnya');
    Route::post('/admin/edityadnya/{id_post}', 'Admin\YadnyaController@updateYadnya');
    Route::post('/admin/deleteyadnya/{id_post}', 'Admin\YadnyaController@deleteYadnya');

    Route::get('/admin/listprosesiawalonyadnya/{id_post}', 'Admin\YadnyaController@listAllProsesiAwalYadnyaAdmin');

    Route::get('/admin/listprosesiawalnotonyadnya/{id_post}', 'Admin\YadnyaController@listAllProsesiAwalNotYetOnYadnya');
    Route::post('/admin/addprosesiawalonyadnya/{id_post}', 'Admin\YadnyaController@addProsesiAwalToYadnya');
    Route::post('/admin/upprosesiawalonyadnya/{id_post}', 'Admin\YadnyaController@upProsesiAwal');
    Route::post('/admin/downprosesiawalonyadnya/{id_post}', 'Admin\YadnyaController@downProsesiAwal');
    Route::post('/admin/deleteprosesiawalonyadnya/{id_post}', 'Admin\YadnyaController@deleteProsesiAwalFromYadnya');

    Route::get('/admin/listprosesipuncakonyadnya/{id_post}', 'Admin\YadnyaController@listAllProsesiPuncakYadnyaAdmin');

    Route::get('/admin/listprosesipuncaknotonyadnya/{id_post}', 'Admin\YadnyaController@listAllProsesiPuncakNotYetOnYadnya');
    Route::post('/admin/addprosesipuncakonyadnya/{id_post}', 'Admin\YadnyaController@addProsesiPuncakToYadnya');
    Route::post('/admin/upprosesipuncakonyadnya/{id_post}', 'Admin\YadnyaController@upProsesiPuncak');
    Route::post('/admin/downprosesipuncakonyadnya/{id_post}', 'Admin\YadnyaController@downProsesiPuncak');
    Route::post('/admin/deleteprosesipuncakonyadnya/{id_post}', 'Admin\YadnyaController@deleteProsesiPuncakFromYadnya');

    Route::get('/admin/listprosesiakhironyadnya/{id_post}', 'Admin\YadnyaController@listAllProsesiAkhirYadnyaAdmin');

    Route::get('/admin/listprosesiakhirnotonyadnya/{id_post}', 'Admin\YadnyaController@listAllProsesiAkhirNotYetOnYadnya');
    Route::post('/admin/addprosesiakhironyadnya/{id_post}', 'Admin\YadnyaController@addProsesiAkhirToYadnya');
    Route::post('/admin/upprosesiakhironyadnya/{id_post}', 'Admin\YadnyaController@upProsesiAkhir');
    Route::post('/admin/downprosesiakhironyadnya/{id_post}', 'Admin\YadnyaController@downProsesiAkhir');
    Route::post('/admin/deleteprosesiakhironyadnya/{id_post}', 'Admin\YadnyaController@deleteProsesiAkhirFromYadnya');

    Route::get('/admin/listgamelanonyadnya/{id_post}', 'Admin\YadnyaController@listAllGamelanYadnyaAdmin');

    Route::get('/admin/listgamelannotonyadnya/{id_post}', 'Admin\YadnyaController@listAllGamelanNotYetOnYadnya');
    Route::post('/admin/addgamelanonyadnya/{id_post}', 'Admin\YadnyaController@addGamelanToYadnya');
    Route::post('/admin/deletegamelanonyadnya/{id_post}', 'Admin\YadnyaController@deleteGamelanFromYadnya');

    Route::get('/admin/listtarionyadnya/{id_post}', 'Admin\YadnyaController@listAllTariYadnyaAdmin');

    Route::get('/admin/listtarinotonyadnya/{id_post}', 'Admin\YadnyaController@listAllTariNotYetOnYadnya');
    Route::post('/admin/addtarionyadnya/{id_post}', 'Admin\YadnyaController@addTariToYadnya');
    Route::post('/admin/deletetarionyadnya/{id_post}', 'Admin\YadnyaController@deleteTariFromYadnya');

    Route::get('/admin/listkidungonyadnya/{id_post}', 'Admin\YadnyaController@listAllKidungYadnyaAdmin');

    Route::get('/admin/listkidungnotonyadnya/{id_post}', 'Admin\YadnyaController@listAllKidungNotYetOnYadnya');
    Route::post('/admin/addkidungonyadnya/{id_post}', 'Admin\YadnyaController@addKidungToYadnya');
    Route::post('/admin/deletekidungonyadnya/{id_post}', 'Admin\YadnyaController@deleteKidungFromYadnya');

    #yadnyaHome
    Route::get('/admin/listyadnya','Admin\HomeController@listYadnyaMaster');
    Route::get('/admin/listdharmagita','Admin\HomeController@listDharmagitaMaster');
    Route::get('/admin/yadnya/{nama_yadnya}','Admin\HomeController@selectedHomeYadnya');
    Route::get('/admin/dharmagita/{id_post}','Admin\HomeController@selectedHomeDharmagita');

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

    Route::get('/admin/listnotapprovedmantram', 'Admin\MantramController@listNotApprovedMantram');
    Route::get('/admin/detailneedapprovalmantram/{id_post}', 'Admin\MantramController@detailMantramNeedApprovalAdmin');
    Route::post('/admin/approvemantram/{id_post}', 'Admin\MantramController@approveMantram');

    #pupuh
    Route::get('/admin/listallpupuhadmin','Admin\PupuhAdminController@listAllPupuhAdmin');
    Route::get('/admin/listkategoripupuhadmin/{id_post}','Admin\PupuhAdminController@listKategoriPupuhAdmin');
    Route::get('/admin/detailpupuhadmin/{id_post}','Admin\PupuhAdminController@detailPupuhAdmin');
    Route::get('/admin/detailbaitpupuhadmin/{id_post}','Admin\PupuhAdminController@detailBaitPupuhAdmin');
    Route::get('/admin/listvideopupuhadmin/{id_pupuh}','Admin\PupuhAdminController@listVideoPupuhAdmin');
    Route::get('/admin/listaudiopupuhadmin/{id_post}','Admin\PupuhAdminController@listAudioPupuhAdmin');
    Route::get('/admin/yadnyapupuhadmin/{id_pupuh}','Admin\PupuhAdminController@YadnyaPupuhAdmin');
    Route::post('/admin/createpupuhadmin','Admin\PupuhAdminController@createPupuhAdmin');
    Route::post('/admin/editpupuhadmin/{id_post}', 'Admin\PupuhAdminController@updatePupuhAdmin');
    Route::post('/admin/deletepupuhadmin/{id_post}', 'Admin\PupuhAdminController@deletePupuhAdmin');
    Route::get('/admin/showpupuh/{id_post}','Admin\PupuhAdminController@showPupuh');

    Route::get('/admin/showvideopupuhadmin/{id_post}','Admin\PupuhAdminController@showVideoPupuhAdmin');
    Route::post('/admin/addvideoonpupuhadmin/{id_post}', 'Admin\PupuhAdminController@addVideoToPupuhAdmin');
    Route::post('/admin/deletevideoonpupuhadmin/{id_post}', 'Admin\PupuhAdminController@deleteVideoFromPupuhAdmin');
    Route::post('/admin/editvideopupuhadmin/{id_post}', 'Admin\PupuhAdminController@updateVideoPupuhAdmin');

    Route::get('/admin/listbaitpupuhadmin/{id_post}', 'Admin\PupuhAdminController@listBaitPupuhAdmin');
    Route::post('/admin/addlirikpupuhadmin/{id_post}', 'Admin\PupuhAdminController@addLirikPupuhAdmin');
    Route::get('/admin/showlirikpupuhadmin/{id_det_post}','Admin\PupuhAdminController@showLirikPupuhAdmin');
    Route::post('/admin/editlirikpupuhadmin/{id_det_post}', 'Admin\PupuhAdminController@updateLirikPupuhAdmin');
    Route::post('/admin/deletelirikpupuhadmin/{id_post}', 'Admin\PupuhAdminController@deleteLirikPupuhAdmin');

    Route::get('/admin/showaudiopupuhadmin/{id_post}','Admin\PupuhAdminController@showAudioPupuhAdmin');
    Route::post('/admin/addaudioonpupuhadmin/{id_post}', 'Admin\PupuhAdminController@addAudioToPupuhAdmin');
    Route::post('/admin/deleteaudioonpupuhadmin/{id_post}', 'Admin\PupuhAdminController@deleteAudioFromPupuhAdmin');
    Route::post('/admin/editaudiopupuhadmin/{id_post}', 'Admin\PupuhAdminController@updateAudioPupuhAdmin');

    Route::get('/admin/listyadnyanotonpupuh/{id_post}', 'Admin\PupuhAdminController@listAllYadnyaNotYetOnPupuh');
    Route::post('/admin/addyadnyaonpupuh/{id_post}', 'Admin\PupuhAdminController@addYadnyaToPupuh');
    Route::post('/admin/deleteyadnyaonpupuh/{id_post}', 'Admin\PupuhAdminController@deleteYadnyaFromPupuh');

    #laguanak
    Route::get('/admin/listalllaguanakadmin','Admin\LaguAnakAdminController@listAllLaguAnakAdmin');
    Route::get('/admin/listkategorilaguanakadmin/{id_post}','Admin\LaguAnakAdminController@listKategoriLaguAnakAdmin');
    Route::get('/admin/detaillaguanakadmin/{id_post}','Admin\LaguAnakAdminController@detailLaguAnakAdmin');
    Route::get('/admin/detailbaitlaguanakadmin/{id_post}','Admin\LaguAnakAdminController@detailBaitLaguAnakAdmin');
    Route::get('/admin/listvideolaguanakadmin/{id_lagu_anak}','Admin\LaguAnakAdminController@listVideoLaguAnakAdmin');
    Route::get('/admin/listaudiolaguanakadmin/{id_post}','Admin\LaguAnakAdminController@listAudioLaguAnakAdmin');
    Route::get('/admin/yadnyalaguanakadmin/{id_lagu_anak}','Admin\LaguAnakAdminController@YadnyaLaguAnakAdmin');
    Route::post('/admin/createlaguanakadmin','Admin\LaguAnakAdminController@createLaguAnakAdmin');
    Route::post('/admin/editlaguanakadmin/{id_post}', 'Admin\LaguAnakAdminController@updateLaguAnakAdmin');
    Route::post('/admin/deletelaguanakadmin/{id_post}', 'Admin\LaguAnakAdminController@deleteLaguAnakAdmin');
    Route::get('/admin/showlaguanak/{id_post}','Admin\LaguAnakAdminController@showLaguAnak');

    Route::get('/admin/showvideolaguanakadmin/{id_post}','Admin\LaguAnakAdminController@showVideoLaguAnakAdmin');
    Route::post('/admin/addvideoonlaguanakadmin/{id_post}', 'Admin\LaguAnakAdminController@addVideoToLaguAnakAdmin');
    Route::post('/admin/deletevideoonlaguanakadmin/{id_post}', 'Admin\LaguAnakAdminController@deleteVideoFromLaguAnakAdmin');
    Route::post('/admin/editvideolaguanakadmin/{id_post}', 'Admin\LaguAnakAdminController@updateVideoLaguAnakAdmin');

    Route::get('/admin/listbaitlaguanakadmin/{id_post}', 'Admin\LaguAnakAdminController@listBaitLaguAnakAdmin');
    Route::post('/admin/addliriklaguanakadmin/{id_post}', 'Admin\LaguAnakAdminController@addLirikLaguAnakAdmin');
    Route::get('/admin/showliriklaguanakadmin/{id_det_post}','Admin\LaguAnakAdminController@showLirikLaguAnakAdmin');
    Route::post('/admin/editliriklaguanakadmin/{id_det_post}', 'Admin\LaguAnakAdminController@updateLirikLaguAnakAdmin');
    Route::post('/admin/deleteliriklaguanakadmin/{id_post}', 'Admin\LaguAnakAdminController@deleteLirikLaguAnakAdmin');

    Route::get('/admin/showaudiolaguanakadmin/{id_post}','Admin\LaguAnakAdminController@showAudioLaguAnakAdmin');
    Route::post('/admin/addaudioonlaguanakadmin/{id_post}', 'Admin\LaguAnakAdminController@addAudioToLaguAnakAdmin');
    Route::post('/admin/deleteaudioonlaguanakadmin/{id_post}', 'Admin\LaguAnakAdminController@deleteAudioFromLaguAnakAdmin');
    Route::post('/admin/editaudiolaguanakadmin/{id_post}', 'Admin\LaguAnakAdminController@updateAudioLaguAnakAdmin');

    Route::get('/admin/listyadnyanotonlaguanak/{id_post}', 'Admin\LaguAnakAdminController@listAllYadnyaNotYetOnLaguAnak');
    Route::post('/admin/addyadnyaonlaguanak/{id_post}', 'Admin\LaguAnakAdminController@addYadnyaToLaguAnak');
    Route::post('/admin/deleteyadnyaonlaguanak/{id_post}', 'Admin\LaguAnakAdminController@deleteYadnyaFromLaguAnak');

    #kakawin
    Route::get('/admin/listallkakawinadmin','Admin\KakawinController@listAllKakawinAdmin');
    Route::get('/admin/listkategorikakawinadmin/{id_post}','Admin\KakawinAdminController@listKategoriKakawinAdmin');
    Route::get('/admin/detailkakawinadmin/{id_post}','Admin\KakawinAdminController@detailKakawinAdmin');
    Route::get('/admin/detailbaitkakawinadmin/{id_post}','Admin\KakawinAdminController@detailBaitKakawinAdmin');
    Route::get('/admin/detailartikakawinadmin/{id_post}','Admin\KakawinAdminController@detailArtiKakawinAdmin');
    Route::get('/admin/listvideokakawinadmin/{id_sekar_agung}','Admin\KakawinAdminController@listVideoKakawinAdmin');
    Route::get('/admin/listaudiokakawinadmin/{id_post}','Admin\KakawinAdminController@listAudioKakawinAdmin');
    Route::get('/admin/yadnyakakawinadmin/{id_sekar_agung}','Admin\KakawinAdminController@YadnyaKakawinAdmin');
    Route::post('/admin/createkakawinadmin','Admin\KakawinAdminController@createKakawinAdmin');
    Route::post('/admin/editkakawinadmin/{id_post}', 'Admin\KakawinAdminController@updateKakawinAdmin');
    Route::post('/admin/deletekakawinadmin/{id_post}', 'Admin\KakawinAdminController@deleteKakawinAdmin');
    Route::get('/admin/showkakawin/{id_post}','Admin\KakawinAdminController@showKakawin');

    Route::get('/admin/showvideokakawinadmin/{id_post}','Admin\KakawinAdminController@showVideoKakawinAdmin');
    Route::post('/admin/addvideoonkakawinadmin/{id_post}', 'Admin\KakawinAdminController@addVideoToKakawinAdmin');
    Route::post('/admin/deletevideoonkakawinadmin/{id_post}', 'Admin\KakawinAdminController@deleteVideoFromKakawinAdmin');
    Route::post('/admin/editvideokakawinadmin/{id_post}', 'Admin\KakawinAdminController@updateVideoKakawinAdmin');

    Route::get('/admin/listbaitkakawinadmin/{id_post}', 'Admin\KakawinAdminController@listBaitKakawinAdmin');
    Route::post('/admin/addlirikkakawinadmin/{id_post}', 'Admin\KakawinAdminController@addLirikKakawinAdmin');
    Route::get('/admin/showlirikkakawinadmin/{id_det_post}','Admin\KakawinAdminController@showLirikKakawinAdmin');
    Route::post('/admin/editlirikkakawinadmin/{id_det_post}', 'Admin\KakawinAdminController@updateLirikKakawinAdmin');
    Route::post('/admin/deletelirikkakawinadmin/{id_post}', 'Admin\KakawinAdminController@deleteLirikKakawinAdmin');

    Route::get('/admin/showaudiokakawinadmin/{id_post}','Admin\KakawinAdminController@showAudioKakawinAdmin');
    Route::post('/admin/addaudioonkakawinadmin/{id_post}', 'Admin\KakawinAdminController@addAudioToKakawinAdmin');
    Route::post('/admin/deleteaudioonkakawinadmin/{id_post}', 'Admin\KakawinAdminController@deleteAudioFromKakawinAdmin');
    Route::post('/admin/editaudiokakawinadmin/{id_post}', 'Admin\KakawinAdminController@updateAudioKakawinAdmin');

    Route::get('/admin/listyadnyanotonkakawin/{id_post}', 'Admin\KakawinAdminController@listAllYadnyaNotYetOnKakawin');
    Route::post('/admin/addyadnyaonkakawin/{id_post}', 'Admin\KakawinAdminController@addYadnyaToKakawin');
    Route::post('/admin/deleteyadnyaonkakawin/{id_post}', 'Admin\KakawinAdminController@deleteYadnyaFromKakawin');
});

Route::group(['as' => 'user'], function () {
    Route::post('/register','AuthAdminController@register');
    Route::post('/login', 'AuthAdminController@login');
    Route::post('/logout', 'AuthAdminController@logout');
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
    Route::get('/listvideokidung/{id_kidung}','KidungListController@listVideoKidung');
    Route::get('/listaudiokidung/{id_post}','KidungListController@listAudioKidung');
    Route::get('/yadnyakidung/{id_post}','KidungListController@YadnyaKidung');

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

    Route::get('/prosesicr/{id_prosesi}/{id_yadnya}','ProsesiListController@detailProsesiCopyReference');

    #Dharmagita
    Route::get('/listalldharmagita','DharmagitaController@listAllDharmagita');
    Route::get('/detaillistdharmagita/{id_post}','DharmagitaController@detailListDharmagita');
    Route::get('/detaildharmagita/{id_post}','DharmagitaController@detailDharmagita');
    Route::get('/detailbaitdharmagita/{id_post}','DharmagitaController@detailBaitDharmagita');
    Route::get('/listdharmagitaterbaru','DharmagitaController@listDharmagitaTerbaru');
    Route::get('/listvideo/{id_post}','DharmagitaController@listVideo');
    Route::get('/listaudio/{id_post}','DharmagitaController@listAudio');
    Route::get('/listallgita','DharmagitaController@listAllGita');

    #Pupuh
    Route::get('/listallpupuh','PupuhController@listAllPupuh');
    Route::get('/listpupuhterbaru','PupuhController@listPupuhTerbaru');
    Route::get('/listkategoripupuh/{id_post}','PupuhController@listKategoriPupuh');
    Route::get('/listkategoripupuhuser/{id_post}/{id_user}','PupuhController@listKategoriPupuhUser');
    Route::get('/detailpupuh/{id_post}','PupuhController@detailPupuh');
    Route::get('/detailbaitpupuh/{id_post}','PupuhController@detailBaitPupuh');
    Route::get('/listvideopupuh/{id_pupuh}','PupuhController@listVideoPupuh');
    Route::get('/listaudiopupuh/{id_post}','PupuhController@listAudioPupuh');
    Route::get('/yadnyapupuh/{id_pupuh}','PupuhController@YadnyaPupuh');
    Route::post('/createpupuh','PupuhController@createPupuh');
    Route::post('/editpupuh/{id_post}', 'PupuhController@updatePupuh');
    Route::post('/deletepupuh/{id_post}', 'PupuhController@deletePupuh');
    Route::get('/showpupuh/{id_post}','PupuhController@showPupuh');
   
    Route::get('/showvideopupuh/{id_post}','PupuhController@showVideoPupuh');
    Route::post('/addvideoonpupuh/{id_post}', 'PupuhController@addVideoToPupuh');
    Route::post('/deletevideoonpupuh/{id_post}', 'PupuhController@deleteVideoFromPupuh');
    Route::post('/editvideopupuh/{id_post}', 'PupuhController@updateVideoPupuh');

    Route::get('/listbaitpupuh/{id_post}', 'PupuhController@listBaitPupuhUser');
    Route::post('/addlirikpupuh/{id_post}', 'PupuhController@addLirikPupuh');
    Route::get('/showlirikpupuh/{id_det_post}','PupuhController@showLirikPupuh');
    Route::post('/editlirikpupuh/{id_det_post}', 'PupuhController@updateLirikPupuh');
    Route::post('/deletelirikpupuh/{id_post}', 'PupuhController@deleteLirikPupuh');

    Route::get('/showaudiopupuh/{id_post}','PupuhController@showAudioPupuh');
    Route::post('/addaudioonpupuh/{id_post}', 'PupuhController@addAudioToPupuh');
    Route::post('/deleteaudioonpupuh/{id_post}', 'PupuhController@deleteAudioFromPupuh');
    Route::post('/editaudiopupuh/{id_post}', 'PupuhController@updateAudioPupuh');

    Route::get('/listyadnyanotonpupuh/{id_post}', 'PupuhController@listAllYadnyaNotYetOnPupuh');
    Route::post('/addyadnyaonpupuh/{id_post}', 'PupuhController@addYadnyaToPupuh');
    Route::post('/deleteyadnyaonpupuh/{id_post}', 'PupuhController@deleteYadnyaFromPupuh');

    #Lagu Anak
    Route::get('/listalllaguanak','LaguAnakController@listAllLaguAnak');
    Route::get('/detaillaguanak/{id_post}','LaguAnakController@detailLaguAnak');
    Route::get('/detailbaitlaguanak/{id_post}','LaguAnakController@detailBaitLaguAnak');
    Route::get('/listkategorilaguanak/{id_post}','LaguAnakController@listKategoriLaguAnak');
    Route::get('/listvideolaguanak/{id_lagu_anak}','LaguAnakController@listVideoLaguAnak');
    Route::get('/listaudiolaguanak/{id_post}','LaguAnakController@listAudioLaguAnak');
    Route::get('/yadnyalaguanak/{id_lagu_anak}','LaguAnakController@YadnyaLaguAnak');

    #Kakawin
    Route::get('/listallkakawin','KakawinController@listAllKakawin');
    Route::get('/detailkakawin/{id_post}','KakawinController@detailKakawin');
    Route::get('/detailbaitkakawin/{id_post}','KakawinController@detailBaitKakawin');
    Route::get('/listkategorikakawin/{id_post}','KakawinController@listKategoriKakawin');
    Route::get('/listvideokakawin/{id_kakawin}','KakawinController@listVideoKakawin');
    Route::get('/listaudiokakawin/{id_post}','KakawinController@listAudioKakawin');
    Route::get('/yadnyakakawin/{id_kakawin}','KakawinController@YadnyaKakawin');
});