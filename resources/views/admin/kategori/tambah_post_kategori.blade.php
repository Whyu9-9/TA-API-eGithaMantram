@extends('admin/layouts.app',['data' => $data])

@section('konten')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Tambah {{$kategori->nama_kategori}}
		</h1>
	</div>
<!-- 	<div class="col-lg-6"> -->
		<div class="panel panel-default">
			<form class="form" action="/kategori/input_post_kategori" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="id_kategori" value="{{$kategori->id_kategori}}">
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label">Nama Upacara Yadnya<span class="text-danger">*</span></label>
								<input type="text" name="nama_post" class="form-control" required>
								@if($errors->has('nama_post'))
								<div class="text-danger">
									{{$errors->first('nama_post')}}
								</div>
								@endif
							</div>
							<div class="form-group">
								<label class="control-label">Link Video</label>
								<input type="text" name="video" class="form-control" required>
							</div>
							<div class="form-group">
								<label class="control-label">Deskripsi<span class="text-danger">*</span></label>
								<textarea name="deskripsi" class="form-control"> </textarea>
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
								<img src="{{asset('/assets/images/placeholder.png')}}" id="photo" height="240"><br>
								<input type="file" name="gambar" class="hidden" accept="{{asset('/gambarku/*')}}" id="photo-input"/>
								<button type="button" onclick="document.getElementById('photo-input').click()" style="margin-top: 8px" class="btn btn-info"><i class="fa fa-folder-open" style="margin-right: 4px"></i>Browse...</button>
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