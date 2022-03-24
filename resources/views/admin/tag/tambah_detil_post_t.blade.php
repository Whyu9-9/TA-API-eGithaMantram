@extends('admin/layouts.app',['data' => $data])

@section('konten')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Tambah Data
		</h1>
	</div>
</div>
<div class="panel panel-default">
	<form class="form" action="#" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label class="control-label">Nama Postingan<span class="text-danger">*</span></label>
						<input type="text" name="nama_post" class="form-control" required>
					</div>
					<div class="form-group">
						<label class="control-label">Kategori Yadnya<span class="text-danger">*</span></label>
						<select type="text" name="id_kategori" class="form-control">
							<option value="null">Umum</option>
							<option value="#">#</option>
						</select>
					</div>
					<div class="form-group">
						<label class="control-label">Link Video</label>
						<input type="text" name="video" class="form-control" required>
					</div>
					<!-- JS FIDDLE, dimana dia akan melakukan select berdasarkan tag (Gamelan, Tabuh, Tari, dll, dimana akan menyimpan di tb_detil_post dengan kolom spesial null. Nb: bisa melakukan banyak select post dalam 1 jenis tag, misal Gamelan yang memiliki relasi banyak Tabuh-->
					<div class="form-group">
						<label class="control-label">Keterkaitan dengan Tag lainnya<span class="text-danger">*</span></label>
						<select type="text" name="id_tag" class="form-control tagku" id="tagkoe">
							@foreach($tag as $t)
								<option value="{{$t->id_tag}}">{{$t->nama_tag}}</option>
							@endforeach
						</select>
					</div>
					<!-- Setelah select diatas (dimana berdasarkan database) lalu tampilkan post sesuai dengan tag yang dipilih -->
					<div class="form-group">
						<label class="control-label">Keterkaitan Post dengan Tag<span class="text-danger" >*</span></label>
						<select name="id_tag[]" class="form-control" id="tag_post">
						</select>
					</div>
					<div class="form-group">
						<label class="control-label">Deskripsi<span class="text-danger">*</span></label>
						<textarea rows="" type="text" name="deskripsi" class="form-control" id="deskripsi" required></textarea>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label class="control-label">Gambar<span class="text-danger">*</span></label><br>
							<img src="#" id="photo" height="240"><br>
							<input type="file" name="gambar" class="hidden" accept="image/*" id="photo-input"/>
							<button type="button" onclick="document.getElementById('photo-input').click()" style="margin-top: 8px" class="btn btn-info"><i class="fa fa-folder-open" style="margin-right: 4px"></i>Browse...</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<a href="#" class="btn btn-default">Batal</a>
			<button class="btn btn-primary">Simpan</button>
		</div>
	</form>
</div>
<script type="text/javascript">

   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
</script>
<script src="{{asset('/assets/ckeditor/ckeditor.js')}}"></script>
<script>
  var konten = document.getElementById("deskripsi");
    CKEDITOR.replace(konten,{
    language:'en-gb'
  });
  CKEDITOR.config.allowedContent = true;

</script>
<script>
$(document).ready(function(){

 $('.tagku').change(function(){
  if($(this).val() != '')
  {
   // var select = $(this).attr("id");
   // console.log(select);
   var value = $(this).val();
   console.log(value);
   // var dependent = $(this).data('dependent');

	   $.ajax({
	    url:'/tag_d',
	    method:"POST",
	    headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
	    data:{values:value},
	    success:function(data)
	    {
    		console.log(data);
	    	var len = 0;
            if(data != null){
                len = data.length;
            }
	     // $('#'+dependent).html(result);
	        select = document.getElementById('tag_post');

			for (var i=0; i<len; i++){
			    var opt = document.createElement('option');
			    opt.value = data[i].id_post;
			    opt.text = data[i].nama_post;
			    // opt.innerHTML = i;
			    select.appendChild(opt);
			}
	    }

   })
  }
 });

 $('#tagkoe').change(function(){
  $('#tag_post').val('');
  $("#tag_post").empty();
 });

 

});
</script>
@endsection