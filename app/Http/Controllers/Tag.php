<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use App\M_Tag;
use App\M_Post;
use App\M_Det_Post;
use App\M_Kategori;
// use App\M_Tingkatan;
use Response;
class Tag extends Controller
{
    public function detil_tag($id_tag)
    {
        $namas = M_Tag::where('tb_tag.id_tag',$id_tag)->first();
    	$tag = M_Post::where('tb_tag.id_tag',$id_tag)
    	->leftJoin('tb_kategori','tb_post.id_kategori','=','tb_kategori.id_kategori')
    	->join('tb_tag','tb_post.id_tag','=','tb_tag.id_tag')
    	->select('tb_post.id_post','tb_post.nama_post','tb_kategori.nama_kategori','tb_post.deskripsi','tb_tag.id_tag', 'tb_tag.nama_tag')
        ->paginate(10);
        // $tingkatan = M_Tingkatan::where('tb_tag.id_tag',$id_tag)
        // ->leftJoin('tb_tag','tb_tingkatan.id_tag','=','tb_tag.id_tag')
        // ->select('tb_tag.id_tag','tb_tag.nama_tag','tb_tingkatan.id_tingkatan','tb_tingkatan.nama_tingkatan','tb_tingkatan.deskripsi')
        // ->get();
    	return view('admin/tag/tag_detil', compact('tag','namas'));
    }
    public function tagku()
    {
        $tag = M_Tag::paginate(10);
        return view('admin/tag/detil_tagku',['tag'=>$tag]);
    }
    public function tambah_tag()
    {
        return view('admin/tag/tambah_tag');
    }
    public function input_tag(Request $request)
    {
        $this->validate($request,[
            'nama_tag' => 'required|unique:tb_tag',
            'deskripsi' => 'required|unique:tb_tag',
        ]);
        $data = new M_Tag();
        $data->nama_tag = $request->nama_tag;
        $data->deskripsi = $request->deskripsi;
        $data->save();
        return redirect('admin');
    }
    public function edit_tagku($id_tag)
    {
        $tag = M_Tag::find($id_tag);
        return view('admin/tag/form_u_tagku',['tag' => $tag]);
    }
    public function update_tagku($id_tag, Request $request)
    {
        $this->validate($request,[
            'nama_tag' => 'required',
            'deskripsi' => 'required',
        ]);
        $data = M_Tag::find($id_tag);
        $data->nama_tag = $request->nama_tag;
        $data->deskripsi = $request->deskripsi;
        $data->save();
        return redirect('tag/detil_tagku');
    }
    public function delete_tagku($id_tag)
    {
        $tag = M_Tag::find($id_tag);
        $tag->delete();
        return redirect('tag/detil_tagku');
    }
    public function tambah_detil_post_t($id_post)
    {
        $tag = M_Tag::select('id_tag','nama_tag')->get();
        return view('admin/tag/tambah_detil_post_t', ['tag'=>$tag]);
    }
    public function tag_dinamis(Request $request)
    {
        $id_tag=$request->get('values');
        $tags = M_Post::where('id_tag',$id_tag)->get();
        $output = [];
         foreach($tags as $row)
         {
            $output[]=[
                'id_post'=>$row->id_post,
                'nama_post'=>$row->nama_post,
            ];
         }
         return Response::json($output);
         exit;
    }
    public function tambah_post_tag($id_tag)
    {
        $tag = M_Tag::select('id_tag','nama_tag')
        ->where('tb_tag.id_tag',$id_tag)
        ->first();
        return view('admin/tag/tambah_post_tag', compact('tag'));
    }
    public function input_post_tag(Request $request)
    {
        $this->validate($request, [
            'nama_post' => 'required|unique:tb_post',
            'deskripsi' => 'required|unique:tb_post',
            'gambar' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = new M_Post();
        $youtube = $request->video;
        $file = $request->file('gambar');
        $nama_file = time()."_".$file->getClientOriginalName();
        $tujuan_upload = 'gambarku';
        $file->move($tujuan_upload,$nama_file);
        $new_key = preg_replace("#.*youtube\.com/watch\?v=#", "", $youtube);
        $data->id_tag = $request->id_tag;
        $data->nama_post = $request->nama_post;
        $data->deskripsi = $request->deskripsi;
        $data->video = $new_key;
        $data->gambar = $nama_file;
        $data->save();
        $id_tagku = $request->id_tag;
        return redirect('/tags/'.$id_tagku);
    }
    public function edit_post_t($id_post)
    {
        $tag = M_Post::where('tb_post.id_post',$id_post)->first();
        $kategori = M_Kategori::select('id_kategori','nama_kategori')->get();
        return view('admin/tag/edit_post_t',compact('tag','kategori'));
    }
    public function update_post_t($id_post, Request $request)
    {
        $this->validate($request, [
            'nama_post' => 'required',
            'deskripsi' => 'required',
        ]);
        $data = M_Post::where('tb_post.id_post',$id_post)->first();
        $data->nama_post = $request->nama_post;
        // $data->id_kategori = $request->id_kategori;
        $data->deskripsi = $request->deskripsi;
        if ($request->has('video')) {
            $youtube = $request->video;
            $new_key = preg_replace("#.*youtube\.com/watch\?v=#", "", $youtube);
            $data->video = $new_key;
        }
        else{
            $youtube = $request->old_video;
            $new_key = preg_replace("#.*youtube\.com/watch\?v=#", "", $youtube);
            $data->video = $new_key;
        }
        if ($request->hasFile('gambar')) {
            $file_path = public_path().'/gambarku/'.$data['gambar'];
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
            $file = $request->file('gambar');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = public_path('/gambarku');
            $file->move($tujuan_upload,$nama_file);
            $data->gambar = $nama_file;
        }
        $data->save();
        $id_tagku = $data->id_tag;
        return redirect('/tags/'.$id_tagku);
    }
    public function delete_post_t($id_post)
    {
        $tag = M_Post::find($id_post);
        $tag->delete();
        return redirect()->back();
    }
    public function cari_post_t(Request $request)
    {
        $cari = $request->cari;
        $id_tag = $request->id_tag;
        $namas = M_Tag::where('tb_tag.id_tag',$id_tag)->first();
        $tag = M_Post::where('tb_post.nama_post','LIKE',"%".$cari."%")->where('tb_post.id_tag',$id_tag)->paginate();
        return view('admin/tag/tag_detil',compact('namas','tag'));
    }

    public function detil_post_t($id_tag, $id_post)
    {
        $tag_post = M_Post::where('tb_post.id_post',$id_post)
                            ->leftJoin('tb_tag','tb_post.id_tag','=','tb_tag.id_tag')
                            ->select('tb_post.id_post','tb_post.nama_post','tb_post.deskripsi','tb_post.gambar','tb_post.video','tb_tag.id_tag','tb_tag.nama_tag')    
                            ->first();
        // dd($tag_post);
        $data = M_Tag::where('tb_tag.id_tag','!=',$id_tag)
                    ->select('id_tag','nama_tag')
                    ->get();

        $drop_d=[];
        $new_det=[];
        foreach ($data as $tag) {
            $id_tagku = $tag->id_tag;
            $nama_tag = $tag->nama_tag;
            $det_pos = M_Tag::where('tb_detil_post.id_post',$id_post)
            ->where('tb_detil_post.id_tag',$id_tagku)
            ->where('tb_detil_post.spesial',NULL)
            ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
            ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
            // ->leftJoin('tb_post as tb_post2','tb_detil_post.id_parent_post','=','tb_detil_post.id_root_post')
            ->select('tb_tag.id_tag', 'tb_tag.nama_tag', 'tb_post.nama_post', 'tb_post.gambar','tb_detil_post.id_post', 
            'tb_detil_post.id_parent_post','tb_detil_post.id_det_post','tb_detil_post.id_root_post')
            ->get();
            // dd($det_pos);
            foreach ($det_pos as $dp) {
                if ($dp->id_root_post!="") {
                    $nama_post2 = M_Post::where('tb_post.id_post', $dp->id_root_post)
                            ->select('nama_post')    
                            ->first();
                    $nama_post2= $nama_post2->nama_post;
                }else{
                    $nama_post2="";
                }
                
               
                $new_det[]=(object) array(
                    'id_tag' => $dp->id_tag,
                    'nama_tag' => $dp->nama_tag,
                    'nama_post' => $dp->nama_post,
                    'gambar' => $dp->gambar,
                    'id_post' => $dp->id_post,
                    'id_parent_post' => $dp->id_parent_post,
                    'id_det_post' => $dp->id_det_post,
                    'id_root_post' => $dp->id_root_post,
                    'nama_post2'=> $nama_post2,
                );
            }
            $drop_d[]=(object) array(
                'id_tag' => $id_tagku,
                'nama_tag' => $nama_tag,
                'det_pos' => $new_det,
            );
        }
        // dd($drop_d);
        if ($tag_post->nama_tag == "Gamelan Bali") {
            return view ('admin/tag/det_tag/detil_post_tag_gamelan',compact('tag_post','drop_d'));
        } 
        elseif ($tag_post->nama_tag == "Prosesi Upacara") {
            return view ('admin/tag/det_tag/detil_post_tag_prosesi',compact('tag_post','drop_d'));
        }
        elseif ($tag_post->nama_tag == "Tari Bali") {
            return view ('admin/tag/det_tag/detil_post_tag_tari',compact('tag_post','drop_d'));
        }
        elseif ($tag_post->nama_tag == "Kidung") {
            return view ('admin/tag/det_tag/detil_post_tag_kidung',compact('tag_post','drop_d'));
        }
        elseif ($tag_post->nama_tag == "Tabuh"){
            return view ('admin/tag/det_tag/detil_post_tag_tabuh',compact('tag_post','drop_d'));
        }
        else{
            return view ('admin/tag/det_tag/detil_post_tags',compact('tag_post','drop_d'));
        } 
    }

    public function drop_down_tag($id)
    {
        $datas = $id;
        $data = explode(",", $datas);
        $id_tag = $data[0];
        $id_post = $data[1];
        $kaitan_tag = M_Tag::where('tb_detil_post.id_post',$id_post)
        ->where('tb_detil_post.id_tag',$id_tag)
        ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
        ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
        ->select('tb_tag.id_tag', 'tb_tag.nama_tag', 'tb_post.nama_post', 'tb_post.gambar','tb_detil_post.id_post', 'tb_detil_post.id_parent_post')
        ->get();
        $kt_t = [];
        foreach ($kaitan_tag as $value) {
            $kt_t[]=[
                'id_tag' => $value->id_tag,
                'nama_tag' => $value->nama_tag,
                'nama_post' => $value->nama_post,
                'gambar' => $value->gambar,
                'id_post' => $value->id_post,
                'id_parent_post' => $value->id_parent_post,
            ];
        }
        return Response::json($kt_t);
        exit;
    }


    public function list_tag(Request $request){
        $list_tag = M_Post::where('id_tag', $request->id_tag)->get();
        return response()->json($list_tag);
    }

    public function list_tag_gamelan(Request $request){
        $id_tag = $request->id_tags;
        $spesial = $request->id_posts;
        // $list_tag = M_Det_Post::where('tb_detil_post.id_tag',$id_tag)
        // ->where('tb_detil_post.id_post',$spesial)
        // ->where('tb_detil_post.spesial',$spesial)
        // ->get();
        $list_tag= M_Tag::where('tb_detil_post.id_tag',$id_tag)
        ->where('tb_detil_post.id_post',$spesial)
        ->where('tb_detil_post.spesial',$spesial)
        ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
        ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
        ->select('tb_tag.id_tag', 'tb_tag.nama_tag', 'tb_post.nama_post','tb_detil_post.id_post', 'tb_detil_post.id_parent_post')
        ->get();
        return response()->json($list_tag);
    }

    public function list_tag_tabuh(Request $request){
        $id_tag = $request->id_tags;
        // $a = $request->id_gambelan;
        // $idnya=explode(',', $a);
        
        // if ($a != '') {
        //     $list_tag = M_Tag::whereIn('tb_detil_post.id_post',$idnya)
        //     ->where('tb_detil_post.id_tag',$id_tag)
        //     ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
        //     ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
        //     ->select('tb_tag.id_tag', 'tb_tag.nama_tag', 'tb_post.nama_post','tb_detil_post.id_post', 'tb_detil_post.id_parent_post', 'tb_detil_post.id_root_post')
        //     ->get();
        //     return response()->json($list_tag);
        // } else {
        //Logic Error, data select berulang
            $list_tab = M_Tag::where('tb_detil_post.id_tag', $id_tag)
            ->where('tb_detil_post.spesial',NULL)
            ->whereNotNull('tb_detil_post.id_root_post')
            ->leftJoin('tb_detil_post','tb_tag.id_tag','=','tb_detil_post.id_tag')
            ->leftJoin('tb_post','tb_detil_post.id_parent_post','=','tb_post.id_post')
            ->select('tb_tag.id_tag', 'tb_tag.nama_tag', 'tb_post.nama_post', 
            'tb_detil_post.id_post', 'tb_detil_post.id_parent_post', 'tb_detil_post.id_root_post')
            ->get();
            return response()->json($list_tab);
        // }
        
    }

    public function list_tag_tabuh_select(Request $request){
        $selectid = M_Det_Post::where('tb_detil_post.id_parent_post', $request->selectid)
        ->where('tb_detil_post.id_tag','=','5')
        ->first();
        return response()->json([
            'selectd' => $selectid->id_root_post
        ]);
        
    }

    public function input_list_tabuh(Request $request){
        $cek = M_Det_Post::where('tb_detil_post.id_parent_post', $request->id_parent_post)
        ->where('tb_detil_post.id_post', $request->id_post)
        ->count();
        if($cek < 1){
            $data = new M_Det_Post();
            $data->id_tag = $request->id_tag;
            $data->id_post = $request->id_post;
            $data->id_parent_post = $request->id_parent_post;
            $data->id_root_post = $request->id_root_post;
            $data->spesial = $request->spesial;
            $data->save();
            $id_postku = $request->id_post;
            $id_tagku = $request->id_tagku;

            $after_save = [
                'alert' => 'success',
                'title' => 'Berhasil!',
                'text-1' => 'Selamat',
                'text-2' => 'Data berhasil ditambah.'
            ];
            
            return redirect('/tag/detil_post_t/'.$id_tagku.'/'.$id_postku)->with(compact('after_save'));
        }else{
            $after_save = [
                'alert' => 'danger',
                'title' => 'Peringatan!',
                'text-1' => 'Ada kesalahan',
                'text-2' => 'Data sudah ada.'
            ];
            return redirect()->back()->with(compact('after_save'));
        }
    }

    public function input_list_gamelan(Request $request){
        $cek = M_Det_Post::where('tb_detil_post.id_parent_post', $request->id_parent_post)
        ->where('tb_detil_post.id_post', $request->id_post)
        ->count();
        if($cek < 1){

            $data = new M_Det_Post();
            $data->id_tag = $request->id_tag;
            $data->id_post = $request->id_post;
            $data->id_parent_post = $request->id_parent_post;
            $data->id_root_post = $request->id_post;
            $data->save();

            $id_postku = $request->id_post;
            $id_tagku = $request->id_tagku;

            $after_save = [
                'alert' => 'success',
                'title' => 'Berhasil!',
                'text-1' => 'Selamat',
                'text-2' => 'Data berhasil ditambah.'
            ];
            
            return redirect('/tag/detil_post_t/'.$id_tagku.'/'.$id_postku)->with(compact('after_save'));
        }else{
            $after_save = [
                'alert' => 'danger',
                'title' => 'Peringatan!',
                'text-1' => 'Ada kesalahan',
                'text-2' => 'Data sudah ada.'
            ];
            return redirect()->back()->with(compact('after_save'));
        }
    }
    public function input_list_tagku(Request $request)
    {
    $cek = M_Det_Post::where('id_parent_post', $request->id_parent_post)
    ->where('id_post', $request->id_post)
    ->count();
        if($cek < 1){
            $tag = M_Det_Post::where('id_post',$request->id_parent_post)->where('spesial',NULL)->get();
            $data = new M_Det_Post();
            $data->id_tag = $request->id_tag;
            $data->id_post = $request->id_post;
            $data->id_parent_post = $request->id_parent_post;
            
            $data->save();
            if ($data->save()) {
                foreach ($tag as $tg){
                    if ($tg != '') {
                        $tags = new M_Det_Post();
                        $tags->id_tag = $tg->id_tag;
                        $tags->id_post = $request->id_post;
                        $tags->id_parent_post = $tg->id_parent_post;
                        $tags->id_root_post = $tg->id_root_post;
                        $tags->save();
                    }
                }
            }
            $id_postku = $request->id_post;
            $id_tagku = $request->id_tagku;

            $after_save = [
                'alert' => 'success',
                'title' => 'Berhasil!',
                'text-1' => 'Selamat',
                'text-2' => 'Data berhasil ditambah.'
            ];
            
            return redirect('/tag/detil_post_t/'.$id_tagku.'/'.$id_postku)->with(compact('after_save'));
        }else{
            $after_save = [
                'alert' => 'danger',
                'title' => 'Peringatan!',
                'text-1' => 'Ada kesalahan',
                'text-2' => 'Data sudah ada.'
            ];
            return redirect()->back()->with(compact('after_save'));
        }
    }
    public function delete_list_tagku($id_det_post)
    {
        try {
            $tag = M_Det_Post::find($id_det_post);
            $tag->delete();
    
            $after_save = [
                'alert' => 'success',
                'title' => 'Berhasil!',
                'text-1' => 'Selamat',
                'text-2' => 'Data berhasil dihapus.'
            ];
            return redirect()->back()->with(compact('after_save'));
        } catch (\exception $e) {
            $after_save = [
                'alert' => 'danger',
                'title' => 'Peringatan!',
                'text-1' => 'Ada kesalahan',
                'text-2' => 'Silahkan periksa kembali.'
            ];
            return redirect()->back()->with(compact('after_save'));
        }
    }
}
