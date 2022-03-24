<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'Kategori_P@homepage');
// Route::get('/home','Kategori_P@homepage');

Route::get('/admin','Admin@index');
Route::get('/login','Admin@login');
Route::post('/login_auth','Admin@login_auth');
Route::get('/logout','Admin@logout');
Route::get('/index','Admin@index');
//Operator Admin
Route::get('/admin/operator','Admin@operator');
Route::get('/admin/tambah_operator','Admin@tambah_operator');
Route::post('/admin/input_operator','Admin@input_operator');
Route::get('/admin/edit_admin/{id_user}','Admin@edit_operator');
Route::put('/admin/update_operator/{id_user}','Admin@update_operator');
Route::get('/admin/delete_admin/{id_user}', 'Admin@delete_operator');
Route::get('/admin/cari','Admin@cari_operator');
//Kategori Yadnya
Route::get('/category/{id_kategori}','Kategori@detil_kategori');
Route::get('/kategori/tambah_kategori','Kategori@tambah_kategori');
Route::post('/kategori/input_kategori','Kategori@input_kategori');
Route::get('/kategori/detil_kategoriku','Kategori@kategoriku');
Route::get('/kategori/edit_kategoriku/{id_kategori}', 'Kategori@edit_kategoriku');
Route::put('/kategori/update_kategoriku/{id_kategori}','Kategori@update_kategoriku');
Route::get('/kategori/hapus_kategoriku/{id_kategori}', 'Kategori@delete_kategoriku');
Route::get('/kategori/tambah_post_kategori/{id_kategori}','Kategori@tambah_post_kategori');
Route::post('/kategori/input_post_kategori','Kategori@input_post_kategori');
Route::get('/kategori/edit_post_k/{id_post}','Kategori@edit_post_k');
Route::put('/kategori/update_post_k/{id_post}','Kategori@update_post_k');
Route::get('/kategori/cari_post_k','Kategori@cari_post_k');
Route::get('/kategori/delete_post_k/{id_post}','Kategori@delete_post_k');
Route::get('/kategori/detil_post_k/{id_post}','Kategori@detil_post_k');
Route::get('/kategori/detil_post_kp/{id_parent_post}/{id_post}/{id_tag}','Kategori@detil_post_kp');
Route::get('/kategori/detil_post_kk/{id_parent_post}/{id_post}/{id_tag}/{spesial}','Kategori@detil_post_kk');
Route::get('/kategori/list_tag','Kategori@list_tag');
Route::get('/kategori/list_prosesi/{id_kategoriku}','Kategori@list_prosesi');
Route::post('/kategori/input_list_kategoriku','Kategori@input_list_kategoriku');
Route::post('/kategori/input_list_prosesiku','Kategori@input_list_prosesiku');
Route::post('/kategori/input_list_kp_pros','Kategori@input_list_kp_pros');
Route::get('/kategori/delete_list_kategoriku/{id_det_post}','Kategori@delete_list_kategoriku');
Route::get('/kategori/delete_list_prosesiku/{id_det_post}','Kategori@delete_list_prosesiku');
Route::post('/kategori/input_list_kp','Kategori@input_list_kp');
Route::post('/kategori/input_list_kp_gam','Kategori@input_list_kp_gam');
Route::post('/kategori/input_list_kk_gam','Kategori@input_list_kk_gam');
Route::post('/kategori/input_list_kp_tab','Kategori@input_list_kp_tab');
Route::post('/kategori/input_list_kk_tab','Kategori@input_list_kk_tab');
Route::get('/kategori/delete_list_kp/{id_det_post}','Kategori@delete_list_kp');
Route::get('/kategori/reposisi_prosesiku/{id_post}/{id_status}','Kategori@drop_down_prosesi');
Route::post('/kategori/input_reposisi_prosesiku','Kategori@input_drop_prosesi');

//Tag
Route::get('/tags/{id_tag}','Tag@detil_tag');
Route::get('/tag/detil_tagku','Tag@tagku');
Route::get('/tag/edit_tagku/{id_tag}', 'Tag@edit_tagku');
Route::put('/tag/update_tagku/{id_tag}','Tag@update_tagku');
Route::get('/tag/tambah_tag','Tag@tambah_tag');
Route::post('/tag/input_tag','Tag@input_tag');
Route::get('/tag/hapus_tagku/{id_tag}','Tag@delete_tagku');
Route::post('/tag_d','Tag@tag_dinamis');
Route::get('/tag/tambah_post_tag/{id_tag}','Tag@tambah_post_tag');
Route::post('/tag/input_post_tag','Tag@input_post_tag');
Route::get('/tag/edit_post_t/{id_post}','Tag@edit_post_t');
Route::put('/tag/update_post_t/{id_post}','Tag@update_post_t');
Route::get('/tag/cari_post_t','Tag@cari_post_t');
Route::get('/tag/delete_post_t/{id_post}','Tag@delete_post_t');
Route::get('/tag/detil_post_t/{id_tag}/{id_post}','Tag@detil_post_t');
Route::get('/tag/drop_down_t/{id}','Tag@drop_down_tag');

//List Tag
Route::get('/tag/dropdown', 'Tag@list_tag');
Route::get('/tag/dropdown_gam', 'Tag@list_tag_gamelan');
Route::get('/tag/dropdown_tabuh', 'Tag@list_tag_tabuh');
Route::get('/tag/dropdown_tabuh/select', 'Tag@list_tag_tabuh_select');
Route::post('/tag/input_list_tagku','Tag@input_list_tagku');
Route::post('/tag/input_list_tabuh','Tag@input_list_tabuh');
Route::post('/tag/input_list_gamelan','Tag@input_list_gamelan');
Route::get('/tag/delete_list_tagku/{id_det_post}','Tag@delete_list_tagku');


// Route::get('/tag/tambah_detil_post_t/{id_post}','Tag@tambah_detil_post_t');
//Pengguna
Route::post('/pengguna/searching','Kategori_P@cari_p');
Route::get('/tag_pengguna/{id_tag}','Tag_P@index_p');
Route::get('/tag_pengguna/detil/{id_post}/{id_tag}','Tag_P@detail_post_t');
Route::get('/kategori_pengguna/{id_kategori}','Kategori_P@index_k');
Route::get('/kategori_pengguna/detil/{id_post}/{id_kategori}','Kategori_P@detail_post_k');
Route::get('/kategori_pengguna/prosesi/{id_post}/{id_parent_post}','Kategori_P@detail_prosesi_k');
Route::get('/kategori_pengguna/detil_kk/{id_parent_post}/{id_post}/{id_tag}/{spesial}','Kategori_P@detail_prosesi_kk');

Route::get('/cache', 'Admin@routeCache');
