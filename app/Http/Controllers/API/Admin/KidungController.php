<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\M_Kategori;
use App\M_Post;
use App\M_Det_Kidung;
use DB;
use App\M_Det_Post;
use App\M_Tag;
use App\M_Det_Dharmagita;
use App\M_Video;
use App\M_Audio;


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

        if(isset($new_kidung)){
            return response()->json($new_kidung);
        }else {
            $new_kidung = [];
            return response()->json($new_kidung);
        }
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

    public function listVideoKidungAdmin($id_kidung)
    {
        $datas = M_Video::where('tb_video.id_dharmagita',$id_kidung)
                            ->select('tb_video.id_video',
                                    'tb_video.id_dharmagita',
                                    'tb_video.judul_video',
                                    'tb_video.gambar_video',
                                    'tb_video.video')
                            ->get();
                            if($datas->count() > 0) {
                            foreach ($datas as $data) {
                                $new_kidung[]=(object) array(
                                    'id_video'     => $data->id_video,
                                    'id_dharmagita' => $data->id_dharmagita,
                                    'judul_video'   => $data->judul_video,
                                    'gambar_video'  => $data->gambar_video,
                                    'video'         => $data->video,
                                );
                            }
                            $arr = [
                                "data" => $new_kidung
                            ];
                        }else {
                            $arr = [
                                'data' => [],
                            ];
                        }
                            return response()->json($arr);
    }

    public function listAudioKidungAdmin($id_post)
    {
        $datas = M_Audio::where('tb_audio.id_dharmagita',$id_post)
                            ->select('tb_audio.id_audio',
                                    'tb_audio.id_dharmagita',
                                    'tb_audio.judul_audio',
                                    'tb_audio.gambar_audio',
                                    'tb_audio.audio')
                            ->get();
                            if($datas->count() > 0) {
                            foreach ($datas as $data) {
                                $new_kidung[]=(object) array(
                                    'id_audio'     => $data->id_audio,
                                    'id_dharmagita' => $data->id_dharmagita,
                                    'judul_audio'   => $data->judul_audio,
                                    'gambar_audio'  => $data->gambar_audio,
                                    'audio'         => $data->audio,
                                );
                            }
                            $arr = [
                                "data" => $new_kidung
                            ];
                        }else {
                            $arr = [
                                'data' => [],
                            ];
                        }
                            return response()->json($arr);
    }

    public function YadnyaKidungAdmin($id_kidung)
    {
        $datas = M_Post::leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                 ->select('tb_post.id_post', 'tb_post.id_kategori' , 'tb_kategori.nama_kategori', 'tb_post.nama_post', 'tb_post.gambar', 'tb_detil_post.id_det_post',)
                 ->leftJoin('tb_detil_post','tb_post.id_post','=','tb_detil_post.id_post')
                ->where('tb_post.is_approved', 1)
                ->where('tb_post.id_kategori', '!=', null)
                ->where('tb_detil_post.id_tag', '=', '4')
                ->where('tb_detil_post.id_parent_post', $id_kidung)
                ->orderBy('tb_post.id_post', 'desc')
                ->get();
                if($datas->count() > 0) {
                foreach ($datas as $data) {
                    $new_kidung[]=(object) array(
                        'id'        => $data->id_det_post,
                        'id_post'     => $data->id_post,
                        'id_kategori' => $data->id_kategori,
                        'kategori'    => $data->nama_kategori,
                        'nama_post'   => $data->nama_post,
                        'gambar'      => $data->gambar,
                        
                    );
                }
                $arr = [
                    "data" => $new_kidung
                ];
            }else {
                    $arr = [
                        'data' => [],
                    ];
                }
                return response()->json($arr);
    }

    public function createKidung(Request $request)
    {
        $kat = M_Kategori::where('nama_kategori',$request->kategori)->first();

        $data              = new M_Post;
        $data->nama_post   = $request->nama_post;
        $data->id_tag      = 4;
        $data->id_kategori = $kat->id_kategori;
        // $data->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
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

    public function showKidung($id_post)
    {
        $kategori_post = M_Post::where('tb_post.id_post',$id_post)
                            ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                            ->select('tb_post.id_post',
                                    'tb_post.nama_post',
                                    // 'tb_post.video',
                                    'tb_post.gambar',
                                    'tb_post.deskripsi',
                                    'tb_kategori.nama_kategori',)
                            ->first();
        $kategori_post['deskripsi'] = filter_var($kategori_post->deskripsi, FILTER_SANITIZE_STRING);
        // $kategori_post['video'] = 'https://youtu.be/'.$kategori_post->video;

        return response()->json($kategori_post);
    }

    public function updateKidung(Request $request, $id_post)
    {
        $kat = M_Kategori::where('nama_kategori',$request->kategori)->first();

        $data              = M_Post::where('id_post',$id_post)->first();
        $data->nama_post   = $request->nama_post;
        $data->id_tag      = 4;
        $data->id_kategori = $kat->id_kategori;
        // $data->video       = preg_replace("#.*youtu\.be/#", "", $request->video);
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

    public function showVideoKidungAdmin($id_post){
        $data = M_Video::where('id_video', $id_post)->first();
        $data['video'] = 'https://youtu.be/'.$data->video;
        return response()->json($data);
    }

    public function addVideoToKidungAdmin(Request $request, $id_post){
        $data = new M_Video;
        $data->id_dharmagita = $id_post;
        $data->judul_video  = $request->judul_video;
        $data->gambar_video = $request->gambar_video;
        $data->video        = preg_replace("#.*youtu\.be/#", "", $request->video);
        $data->is_approved = 0;

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

    public function updateVideoKidungAdmin(Request $request, $id_post){
        $data = M_Video::where('id_video', $id_post)->first();
        $data->judul_video  = $request->judul_video;
        $data->gambar_video = $request->gambar_video;
        $data->video        = preg_replace("#.*youtu\.be/#", "", $request->video);

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

    public function deleteVideoFromKidungAdmin($id_post){
        $data = M_Video::where('id_video', $id_post)
                            ->first();
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

    public function showAudioKidungAdmin($id_post){
        $data = M_Audio::where('id_audio', $id_post)->first();
        return response()->json($data);
    }

    public function addAudioToKidungAdmin(Request $request, $id_post){
        $data = new M_Audio;
        $data->id_dharmagita = $id_post;
        $data->judul_audio  = $request->judul_audio;
        $data->gambar_audio = $request->gambar_audio;
        $data->audio        = $request->audio;
        $data->is_approved = 0;

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

    public function updateAudioKidungAdmin(Request $request, $id_post){
        $data = M_Audio::where('id_audio', $id_post)->first();
        $data->judul_audio  = $request->judul_audio;
        $data->gambar_audio = $request->gambar_audio;
        $data->audio        = $request->audio;

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

    public function deleteAudioFromKidungAdmin($id_post){
        $data = M_Audio::where('id_audio', $id_post)
                            ->first();
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

    public function listAllYadnyaNotYetOnKidung($id_post){
        $check = M_Post::where('tb_post.id_kategori', '!=', null)
        ->where('tb_post.id_tag', null)
                        // ->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
                        // ->leftJoin('tb_detil_post','tb_post.id_post','=','tb_detil_post.id_post')
                        // ->where('tb_post.is_approved', 1)
                        // ->where('tb_detil_post.id_tag', '=', '9')
                        // ->where('tb_detil_post.id_parent_post', $id_post)
                        ->orderBy('tb_post.id_post', 'desc')
                        ->get();

        foreach($check as $c){
            $val = M_Det_Post::where('id_post', $c->id_post)
                                ->where('id_tag', '4')
                                // ->where('tb_post.id_kategori', '!=', null)
                                ->where('id_parent_post', $id_post)
                                ->first();
            if($val == null){
                $new_check[] = (object) array(
                    'id_post'   => $c->id_post,
                    'nama_post' => $c->nama_post,
                    'gambar'    => $c->gambar,
                );
            }
        }

        if(isset($new_check)){
            $arr = [
                "data" => $new_check
            ];
            return response()->json($arr);
        }else {
            $new_check = [];
            $arr = [
                'data' => $new_check
            ];
            return response()->json($arr);
        }
    }

    public function addYadnyaToKidung(Request $request, $id_post){
        $data = new M_Det_Post;
        $data->id_post        = $request->id_kidung;
        $data->id_parent_post = $id_post;
        $data->id_tag         = 4;

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

    public function deleteYadnyaFromKidung($id_post){
        $data = M_Det_Post::where('id_det_post', $id_post)
                            ->where('id_tag',4)
                            ->first();
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
}
