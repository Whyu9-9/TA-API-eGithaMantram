<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Kategori;
use App\M_Post;
use App\M_Det_Mantram;

class MantramController extends Controller
{
    public function listAllMantramAdmin()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.is_approved')
                    ->where('tb_post.is_approved', '!=', 0)
                    ->where('tb_post.id_tag', '=', '6')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();

        foreach ($datas as $data) {
            $new_mantram[]=(object) array(
                'id_post'     => $data->id_post,
                'id_kategori' => $data->id_kategori,
                'kategori'    => $data->nama_kategori,
                'nama_post'   => $data->nama_post,
                'gambar'      => $data->gambar,
                'is_approved' => $data->is_approved,
            );
        }

        if(isset($new_mantram)){
            return response()->json($new_mantram);
        }else {
            $new_mantram = [];
            return response()->json($new_mantram);
        }
    }

    public function detailMantramAdmin($id_post)
    {
        $kategori_post = M_Post::where('tb_post.id_post',$id_post)
                            ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                            ->leftJoin('tb_detail_mantram','tb_post.id_post','=','tb_detail_mantram.mantram_id')
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_detail_mantram.jenis_mantram',
                                    'tb_detail_mantram.bait_mantra',
                                    'tb_detail_mantram.arti_mantra',
                                    'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',
                                    'tb_kategori.nama_kategori',)
                            ->first();
        $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);

        return response()->json($kategori_post);
    }

    public function createMantram(Request $request)
    {
        $check = $request->role_admin;

        if($request->kategori != "Tidak Ada"){
            $kat = M_Kategori::where('nama_kategori',$request->kategori)->first();
        }else{
            $kat = null;
        }

        $data              = new M_Post;
        $data->nama_post   = $request->nama_post;
        $data->id_tag      = 6;
        if($kat != null){
            $data->id_kategori = $kat->id_kategori;
        }else{
            $data->id_kategori = null;
        }

        if($check != 1 && $request->jenis_mantram == "Khusus") {
            $data->is_approved    = 0;
            $data->approval_notes = $request->approval_notes;
        }else{
            $data->is_approved = 1;
        }

        $data->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
        $data->deskripsi   = "<p>".$request->deskripsi."</p>";
        if($request->has('gambar')){
            $image = time().'.jpg';
            file_put_contents('gambarku/'.$image,base64_decode($request->gambar));
            $data->gambar = $image;
        }else {
            $data->gambar = '1604034202_note fix.png';
        }

        if($data->save()){
            $data_detail                = new M_Det_Mantram;
            $data_detail->mantram_id    = $data->id_post;
            $data_detail->jenis_mantram = $request->jenis_mantram;
        }

        if($data_detail->save()){
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil ditambahkan'
            ]);
        }else {
            return response()->json([
                'status' => 401,
                'message' => 'Data gagal ditambahkan'
            ]);
        }

    }

    public function showMantram($id_post)
    {
        $kategori_post = M_Post::where('tb_post.id_post',$id_post)
                            ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                            ->leftJoin('tb_detail_mantram','tb_post.id_post','=','tb_detail_mantram.mantram_id')
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_detail_mantram.jenis_mantram',
                                    'tb_detail_mantram.bait_mantra',
                                    'tb_detail_mantram.arti_mantra',
                                    'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',
                                    'tb_kategori.nama_kategori',
                                    'tb_post.approval_notes',)
                            ->first();
        $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);
        $kategori_post['video'] = 'https://youtu.be/'.$kategori_post->video;
        return response()->json($kategori_post);
    }

    public function updateMantram(Request $request, $id_post)
    {
        $check = $request->role_admin;

        $data              = M_Post::where('id_post',$id_post)->first();
        $data->nama_post   = $request->nama_post;
        $data->id_tag      = 6;

        if($request->kategori != "Tidak Ada"){
            $kat = M_Kategori::where('nama_kategori',$request->kategori)->first();
            $data->id_kategori = $kat->id_kategori;
        }else{
            $data->id_kategori = null;
        }

        if($check != 1 && $request->jenis_mantram == "Khusus") {
            $data->is_approved    = 0;
            $data->approval_notes = $request->approval_notes;
        }

        $data->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
        $data->deskripsi   = "<p>".$request->deskripsi."</p>";
        if($request->has('gambar')){
            $image = time().'.jpg';
            file_put_contents('gambarku/'.$image,base64_decode($request->gambar));
            $data->gambar = $image;
        }

        if($data->save()){
            $data_detail                = M_Det_Mantram::where('mantram_id',$id_post)->first();
            $data_detail->jenis_mantram = $request->jenis_mantram;
        }

        if($data_detail->save()){
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diubah'
            ]);
        }else {
            return response()->json([
                'status' => 401,
                'message' => 'Data gagal diubah'
            ]);
        }
    }

    public function deleteMantram($id_post)
    {
        $data = M_Post::where('id_post',$id_post)->first();
        if($data->delete()){
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ]);
        }else {
            return response()->json([
                'status' => 401,
                'message' => 'Data gagal dihapus'
            ]);
        }
    }

    public function editBait(Request $request, $id_post)
    {
        $data = M_Det_Mantram::where('mantram_id',$id_post)->first();
        $data->bait_mantra = $request->bait_mantra;
        if($data->save()){
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diubah'
            ]);
        }else {
            return response()->json([
                'status' => 401,
                'message' => 'Data gagal diubah'
            ]);
        }
    }

    public function editArti(Request $request, $id_post)
    {
        $data = M_Det_Mantram::where('mantram_id', $id_post)->first();
        $data->arti_mantra = $request->arti_mantra;
        if($data->save()){
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diubah'
            ]);
        }else {
            return response()->json([
                'status' => 401,
                'message' => 'Data gagal diubah'
            ]);
        }
    }

    public function listNotApprovedMantram()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    ->where('tb_post.is_approved', 0)
                    ->where('tb_post.id_tag', '=', '6')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();

        foreach ($datas as $data) {
            $new_mantram[]=(object) array(
                'id_post'     => $data->id_post,
                'id_kategori' => $data->id_kategori,
                'kategori'    => $data->nama_kategori,
                'nama_post'   => $data->nama_post,
                'gambar'      => $data->gambar,
            );
        }

        if(isset($new_mantram)){
            return response()->json($new_mantram);
        }else {
            $new_mantram = [];
            return response()->json($new_mantram);
        }
    }

    public function detailMantramNeedApprovalAdmin($id_post)
    {
        $kategori_post = M_Post::where('tb_post.id_post', $id_post)
                            ->where('tb_post.is_approved', '!=' ,1)
                            ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                            ->leftJoin('tb_detail_mantram','tb_post.id_post','=','tb_detail_mantram.mantram_id')
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_detail_mantram.jenis_mantram',
                                    'tb_detail_mantram.bait_mantra',
                                    'tb_detail_mantram.arti_mantra',
                                    'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',
                                    'tb_post.approval_notes',
                                    'tb_kategori.nama_kategori',)
                            ->first();
        $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);

        return response()->json($kategori_post);
    }

    public function approveMantram(Request $request, $id_post)
    {
        $data = M_Post::where('id_post', $id_post)->first();

        if ($request->stats == 'yes'){
            $data->is_approved = 1;
        }else{
            $data->is_approved = 2;
        }

        if($data->save()){
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diubah'
            ]);
        }else {
            return response()->json([
                'status' => 401,
                'message' => 'Data gagal diubah'
            ]);
        }
    }
}
