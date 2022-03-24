@extends('admin/layouts.app',['data' => $data])

@section('konten')
<meta name="csrf-token" content="{{ csrf_token() }}" />
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Edit Kategori Tag
			</h1>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default">
				<form class="form" action="/tag/update_tagku/{{ $tag->id_tag }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label">Nama Tag<span class="text-danger">*</span></label>
							<input type="text" name="nama_tag" class="form-control" value="{{ $tag->nama_tag }}" />
                            @if($errors->has('nama_tag'))
                                <div class="text-danger">
                                    {{ $errors->first('nama_tag')}}
                                </div>
                            @endif
						</div>
						<div class="form-group">
							<label class="control-label">Deskripsi<span class="text-danger">*</span></label>
							<input type="text" name="deskripsi" class="form-control" value="{{ $tag->deskripsi }}">
							    @if($errors->has('deskripsi'))
                                <div class="text-danger">
                                    {{ $errors->first('deskripsi')}}
                                </div>
                            @endif
						</div>
					</div>
					<div class="panel-footer">
						<a href="/tag/detil_tagku" class="btn btn-default">Batal</a>
						<button class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
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