@extends('admin/layouts.app',['data' => $data])

@section('konten')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Edit Upacara {{$kategori->nama_post}}
		</h1>
	</div>
<!-- 	<div class="col-lg-6"> -->
		<div class="panel panel-default">
			<form class="form" action="/kategori/update_post_k/{{$kategori->id_post}}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				{{-- <input type="hidden" name="id_kategori" value="{{Request::segment(3)}}"> --}}
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">Nama Upacara Yadnya<span class="text-danger">*</span></label>
								<input type="text" name="nama_post" class="form-control" value="{{ $kategori->nama_post }}" required>
								@if($errors->has('nama_post'))
								<div class="text-danger">
									{{$errors->first('nama_post')}}
								</div>
								@endif
							</div>
							@if(strlen($kategori['video']) != 0)
							<div class="form-group">
								<label class="control-label">Video Terdahulu</label>
								<div class="mapouter">
									<div class="gmap_canvas">
										<iframe width="500" height="300" src="https://www.youtube.com/embed/{{ $kategori->video }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
										<style>
											.mapouter{position:relative;text-align:center; display:block; height:95%;width:100%;}
											.gmap_canvas {overflow:hidden;background:none!important;height:95%;width:100%;}
										</style>
									</div>
								</div>
							</div>
							@else
							<div class="form-group">
								<label class="control-label">Link Video</label>
								<input type="text" name="video" class="form-control" value="{{ $kategori->video }}" required>
							</div>
							@endif
							<div class="form-group">
								<label class="control-label">Link Video Baru</label>
								<input type="text" name="video" class="form-control">
							</div>
							<div class="form-group">
								<label class="control-label">Deskripsi<span class="text-danger">*</span></label>
								<textarea name="deskripsi" class="form-control">{{ $kategori->deskripsi }}</textarea>
								@if($errors->has('deskripsi'))
								<div class="text-danger">
									{{ $errors->first('deskripsi') }}
								</div>
								@endif
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">Gambar<span class="text-danger">*</span></label><br>
								<img src="/gambarku/{{$kategori->gambar}}" id="photo" height="240"><br>
								<input type="file" name="gambar" class="hidden" accept="{{asset('/gambarku/*')}}" id="photo-input"/>
								<button type="button" onclick="document.getElementById('photo-input').click()" style="margin-top: 8px" class="btn btn-info"><i class="fa fa-folder-open" style="margin-right: 4px"></i>Browse...</button>
							</div>
						</div>
					</div>
					<input type="hidden" name="old_video" value="{{$kategori->video}}">
				</div>
				<div class="panel-footer">
					<a href="#" class="btn btn-default">Batal</a>
					<button class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
<!-- 	</div> -->
</div>
<script type="text/javascript">

   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
</script>

<script>
	let $photo = $('#photo'),
            $photoInput = $('#photo-input')
                    $photoInput.on('change', function(e) {
            let file = e.target.files[0],
                fileReader = new FileReader();

            fileReader.onload = function(e) {
                $photo.attr('src', e.target.result);
            }

            fileReader.readAsDataURL(file);
        });

</script>
@endsection