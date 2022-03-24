@extends('admin/layouts.app',['data' => $data])

@section('konten')
<meta name="csrf-token" content="{{ csrf_token() }}" />
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Edit Operator
			</h1>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default">
				<form class="form" action="/admin/update_operator/{{ $admin->id_user }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label">Nama Administrator<span class="text-danger">*</span></label>
							<input type="text" name="nama" class="form-control" value="{{ $admin->name }}" />
                            @if($errors->has('name'))
                                <div class="text-danger">
                                    {{ $errors->first('name')}}
                                </div>
                            @endif
						</div>
						<div class="form-group">
							<label class="control-label">Email<span class="text-danger">*</span></label>
							<input type="email" name="email" class="form-control" value="{{ $admin->email }}">
							    @if($errors->has('email'))
                                <div class="text-danger">
                                    {{ $errors->first('email')}}
                                </div>
                            @endif
						</div>
						<div class="form-group">
							<label class="control-label">Password<span class="text-danger"></span></label>
							<input type="password" name="pwd" class="form-control" value="{{ $admin->password }}">
							    @if($errors->has('password'))
                                <div class="text-danger">
                                    {{ $errors->first('password')}}
                                </div>
                            @endif
						</div>
						<div class="form-group">
							<label class="control-label">Konfirmasi Password<span class="text-danger"></span></label>
							<input type="password" name="konfirm" class="form-control">
							    @if($errors->has('konfirm'))
                                <div class="text-danger">
                                    {{ $errors->first('konfirm')}}
                                </div>
                            @endif
						</div>
					</div>
					<div class="panel-footer">
						<a href="/admin/operator" class="btn btn-default">Batal</a>
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