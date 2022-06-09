<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\M_Kategori;
use App\M_Post;
use App\M_Det_Kidung;
use DB;

class KidungController extends Controller
{
    public function listAllKidungAdmin()
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                    ->select('tb_post.id_post', 'tb_post.gambar' ,'tb_post.id_tag' , 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post')
                    ->where('tb_post.id_tag', '=', '4')
                    ->orderBy('tb_post.id_post', 'desc')
                    ->get();

        foreach ($datas as $data) {
            $new_kidung[]=(object) array(
                'id_post'     => $data->id_post,
                'id_kategori' => $data->id_kategori,
                'kategori'    => $data->nama_kategori,
                'nama_post'   => $data->nama_post,
                'gambar'      => $data->gambar,
            );
        }

        return response()->json($new_kidung);
    }

    public function detailKidungAdmin($id_post)
    {
        $kategori_post = M_Post::where('tb_post.id_post',$id_post)
                            ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',
                                    'tb_kategori.nama_kategori',)
                            ->first();
        $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);

        return response()->json($kategori_post);
    }

    public function detailBaitKidungAdmin($id_post)
    {
        $det_pros = M_Det_Kidung::where('kidung_id', $id_post)->orderBy('urutan_bait', 'ASC')->get();
        if($det_pros->count() > 0) {
            foreach ($det_pros as $d_pros) {
                $new_pros[] = (object) array(
                    'id_lirik_kidung' => $d_pros->id,
                    'urutan'          => "Lirik ke-".$d_pros->urutan_bait,
                    'bait'            => $d_pros->bait_kidung,
                );
            }
        } else {
            $new_pros = [];
        }

        return response()->json($new_pros);

    }

    public function createKidung(Request $request)
    {
        $kat = M_Kategori::where('nama_kategori',$request->kategori)->first();

        $data              = new M_Post;
        $data->nama_post   = $request->nama_post;
        $data->id_tag      = 4;
        $data->id_kategori = $kat->id_kategori;
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

    public function showKidung($id_post)
    {
        $kategori_post = M_Post::where('tb_post.id_post',$id_post)
                            ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',
                                    'tb_kategori.nama_kategori',)
                            ->first();
        $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);
        $kategori_post['video'] = 'https://youtu.be/'.$kategori_post->video;

        return response()->json($kategori_post);
    }

    public function updateKidung(Request $request, $id_post)
    {
        $kat = M_Kategori::where('nama_kategori',$request->kategori)->first();

        $data = M_Post::where('id_post',$id_post)->first();
        $data->nama_post   = $request->nama_post;
        $data->id_tag      = 4;
        $data->id_kategori = $kat->id_kategori;
        $data->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
        $data->deskripsi   = "<p>".$request->deskripsi."</p>";
        if($request->has('gambar')){
            $image = time().'.jpg';
            file_put_contents('gambarku/'.$image,base64_decode($request->gambar));
            $data->gambar = $image;
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

    public function deleteKidung($id_post)
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

    public function listBaitKidungAdmin($id_post)
    {
        $det_pros = M_Det_Kidung::where('kidung_id', $id_post)->orderBy('urutan_bait', 'ASC')->get();
        foreach ($det_pros as $d_pros) {
            $new_pros[] = (object) array(
                'id_lirik_kidung' => $d_pros->id,
                'urutan'          => $d_pros->urutan_bait,
                'bait'            => Str::limit($d_pros->bait_kidung, 30, '...'),
            );
        }
        return response()->json($new_pros);

    }

    public function addLirikKidung(Request $request, $id_post){
        $getLatestUrutan = M_Det_Kidung::select('urutan_bait')->where('kidung_id', $id_post)->orderBy('urutan_bait', 'DESC')->first();

        $data = new M_Det_Kidung;
        $data->kidung_id   = $id_post;
        $data->bait_kidung = $request->bait_kidung;

        if($getLatestUrutan){
            $data->urutan_bait = intval($getLatestUrutan->urutan_bait) + 1;
        }else {
            $data->urutan_bait = 1;
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

    public function showLirikKidung($id_det_post){
        $data = M_Det_Kidung::where('id', $id_det_post)->first();
        return response()->json($data);
    }

    public function updateLirikKidung(Request $request, $id_det_post){
        $data = M_Det_Kidung::where('id', $id_det_post)->first();
        $data->bait_kidung = $request->bait_kidung;

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

    public function deleteLirikKidung(Request $request, $id)
    {
        $data = M_Det_Kidung::where('id', $id)->first();
        if($data->delete()){
            $i = 0;
            $datas = M_Det_Kidung::where('kidung_id', $request->kidung_id)->orderBy('urutan_bait', 'ASC')->get();
            foreach ($datas as $key) {
                DB::table('tb_detail_kidung')
                    ->where('id', $key->id)
                    ->update(['urutan_bait' => $i+=1]);
            }
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
