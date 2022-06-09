<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\M_Post;
use App\M_Tag;

class TabuhController extends Controller
{
    public function listAllTabuhAdmin()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post','tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    ->where('tb_post.id_tag', '=', '5')->orderBy('tb_post.id_post', 'desc')
                    ->get();

        foreach ($datas as $data) {
            $new_tabuh[]=(object) array(
                'id_post'     => $data->id_post,
                'nama_post'   => $data->nama_post,
                'gambar'      => $data->gambar,
            );
        }

        return response()->json($new_tabuh);
    }

    public function detailTabuhAdmin($id_post)
    {
        $detail_post = M_Post::where('tb_post.id_post',$id_post)
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',)
                            ->first();
        $detail_post['deskripsi'] = filter_var($detail_post->deskripsi, FILTER_SANITIZE_STRING);

        return response()->json($detail_post);
    }

    public function createTabuh(Request $request)
    {
        $data              = new M_Post;
        $data->nama_post   = $request->nama_post;
        $data->id_tag      = 5;
        $data->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
        $data->deskripsi   = "<p>".$request->deskripsi."</p>";
        $data->is_approved = 1;

        if($request->has('gambar')){
            $image = time().'.jpg';
            file_put_contents('gambarku/'.$image,base64_decode($request->gambar));
            $data->gambar = $image;
        }else {
            $data->gambar = '1604034202_note fix.png';
        }

        if($data->save()){
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

    public function showTabuh($id_post)
    {
        $detail_post = M_Post::where('tb_post.id_post',$id_post)
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',)
                            ->first();
        $detail_post['deskripsi'] = filter_var($detail_post->deskripsi, FILTER_SANITIZE_STRING);
        $detail_post['video'] = 'https://youtu.be/'.$detail_post->video;
        return response()->json($detail_post);
    }

    public function updateTabuh(Request $request, $id_post)
    {
        $data_detail = M_Post::where('id_post',$id_post)->first();
        $data_detail->nama_post   = $request->nama_post;
        $data_detail->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
        $data_detail->deskripsi   = "<p>".$request->deskripsi."</p>";

        if($request->has('gambar')){
            $image = time().'.jpg';
            file_put_contents('gambarku/'.$image,base64_decode($request->gambar));
            $data_detail->gambar = $image;
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

    public function deleteTabuh($id_post)
    {
        $data_detail = M_Post::where('id_post',$id_post)->first();
        if($data_detail->delete()){
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

}
