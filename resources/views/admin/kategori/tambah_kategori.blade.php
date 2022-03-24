@extends('admin/layouts.app',['data' => $data])

@section('konten')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Tambah Kategori Yadnya
		</h1>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-default">
			<form class="form" action="/kategori/input_kategori" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label">Nama Yadnya<span class="text-danger">*</span></label>
						<input type="text" name="nama_kategori" class="form-control" />
						@if($errors->has('nama_kategori'))
						<div class="text-danger">
							{{ $errors->first('nama_kategori') }}
						</div>
						@endif
					</div>
					<div class="form-group">
						<label class="control-label">Deskripsi Kategori<span class="text-danger">*</span></label>
						<input type="text" name="deskripsi" class="form-control"/>
						@if($errors->has('deskripsi'))
						<div class="text-danger">
							{{ $errors->first('deskripsi') }}
						</div>
						@endif
					</div>
				</div>
				<div class="panel-footer">
					<a href="/kategori/detil_kategoriku" class="btn btn-default">Batal</a>
					<button class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
</script>
@endsection