@extends('admin/layouts.app',['data' => $data])

@section('konten')
<link rel="stylesheet" href="{{asset('/assets/select2/select2.min.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="modal fade" id="tag-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
					<span aria-hidden="true">
						&times;
					</span>
				</button>
				<h4 class="modal-title">
					Tambah Data
					<span class="add-item-label"></span>
				</h4>
			</div>
			<form class="form" action="/tag/input_list_tagku/" method="POST">
				{{ csrf_field() }}
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label">
							<span class="add-item-label"></span>
						</label>
						<select name="id_parent_post" style="width:100%;" class="list-tag" class="form-control" required></select>
					</div>
				</div>
					<input type="hidden" name="id_post" value="{{$tag_post->id_post}}"/>
					<input type="hidden" name="id_tag" class="id-tag" value=""/>
					<input type="hidden" name="id_tagku" value="{{$tag_post->id_tag}}">
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</form>
	</div>
</div>
<br>
<div class="modal fade" id="tag-modal-tabuh" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
					<span aria-hidden="true">
						&times;
					</span>
				</button>
				<h4 class="modal-title">
					Tambah Data
					<span class="add-item-label"></span>
				</h4>
			</div>
			<form class="form" action="/tag/input_list_tabuh/" method="POST">
				{{ csrf_field() }}
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label">
							<span class="add-item-label"></span>
						</label>
						<select name="id_parent_post" id="list-tag-tabuh" style="width:100%;" class="list-tag-tabuh" class="form-control" required></select>
					</div>
				</div>
					<input type="hidden" name="id_post" value="{{$tag_post->id_post}}"/>
					<input type="hidden" name="id_tag" class="id-tag-tabuh" value=""/>
					<input type="hidden" name="id_root_post" class="id-root-post" value=""/>
					<input type="hidden" name="id_tagku" value="{{$tag_post->id_tag}}">
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</form>
	</div>
</div>
<br>
<div class="row">
	<div class="col-lg-3">
		@if($tag_post->gambar != '')
		<img src="/gambarku/{{$tag_post->gambar}}" width="100%">
		@else
		<img src="/assets/images/placeholder.png" width="100%">
		@endif
	</div>
	<div class="col-lg-9">
		<h1 class="page-header" style="margin: 0">
			{{$tag_post->nama_post}}
			<br>
		</h1>
		<div>{!! $tag_post->deskripsi !!}</div>
		<div class="mapouter">
			<div class="gmap_canvas">
				<iframe width="910" height="480" src="https://www.youtube.com/embed/{{ $tag_post->video }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<style>
					.mapouter{position:relative;text-align:center; display:block; height:95%;width:100%;}
					.gmap_canvas {overflow:hidden;background:none!important;height:95%;width:100%;}
				</style>
			</div>
		</div>
	</div>
</div>
<hr>
@if (Session::has('after_save'))
<div class="row">
	<div class="col-lg-12">
		<div class="alert alert-{{ Session::get('after_save.alert') }} alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{{ Session::get('after_save.title') }}</strong> {{ Session::get('after_save.text-1') }}, {{ Session::get('after_save.text-2') }}
		</div>
	</div>
</div>
@endif
<div class="panel-group" id="accordion">
	@foreach($drop_d as $drop)
	<div class="panel panel-primary">
		<div class="panel-heading" role="tab" id="headingFive">
			<a style="text-decoration: none; color: #232323;" class="collapsed drop" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$drop->id_tag}}" aria-expanded="true" aria-controls="collapseFive" data-idt="{{$drop->id_tag}}" data-idp="{{Request::segment(3)}}">
				{{$drop->nama_tag}}
			</a>
		</div>
		<div id="collapse{{$drop->id_tag}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive">
			<div class="panel-body">
				<div class="row isi{{$drop->id_tag}}">
					@if (!empty($drop->det_pos))
						@foreach ($drop->det_pos as $item)
							@if ($drop->id_tag == $item->id_tag)
					<!-- Katanya Pake Foreach lagi -->
					<div class="col-lg-2">
						<div class="card" style="background-image: url('/gambarku/{{$item->gambar}}')">
							<!-- Bagaimana caranya mengetahui bahwa tabuh A kepemilikan Gamelan A -->
							<div class="card-body">
								@if ($item->nama_post2 !='')
									{{$item->nama_post}}
									({{$item->nama_post2}})
								@else
									{{$item->nama_post}}
								@endif
								{{-- {{$item->nama_tag}}
								{{$item->id_post}} --}}
							</div>
							<button type="button" class="btn btn-delete btn-sm btn-danger btn-card" data-toggle="modal" data-target="#exampleModal{{$item->id_det_post}}">
								Hapus
							</button>

							<div class="modal fade" id="exampleModal{{$item->id_det_post}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										Apakah anda yakin ingin menghapus data ini ?
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
										<a data-id="#/{{$item->id_post}}" href="/tag/delete_list_tagku/{{$item->id_det_post}}" type="button" class="btn btn-primary">Hapus</a>
									</div>
									</div>
								</div>
							</div>
							{{-- <a data-id="#/{{$item->id_post}}" href="/tag/delete_list_tagku/{{$item->id_det_post}}" class="btn btn-delete btn-sm btn-danger btn-card">Hapus</a> --}}
						</div>
					</div>
							@endif
						@endforeach
					@else
						{{-- tidak ada data --}}
					@endif
					<!-- Katanya Pake EndForeach lagi -->
					<div class="col-lg-2">
					@if ($drop->id_tag =='5')
					@php
					$result = [];	
					@endphp
							@foreach ($drop->det_pos as $item2)
								{{-- @if ($item2 !='') --}}
									@php
									$result[] = $item2->id_root_post;
									// $result[] = $item2->id_root_post;
									@endphp
								{{-- @endif --}}
							@endforeach
							@php
								$DAT=implode(',', array_unique($result));
							@endphp
						<a class="card tag-button-tabuh" id="tag-button-tabuh" data-toggle="modal" href="#" data-target="#tag-modal-tabuh" data-tags="{{ $drop->id_tag }}" data-gmbl="{{$DAT}}"><i class="fa fa-plus fa-4x"></i></a>
					@else
						<a class="card tag-button" data-toggle="modal" href="#" data-target="#tag-modal" data-tag="{{ $drop->id_tag }}"><i class="fa fa-plus fa-4x"></i></a>
					@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	@endforeach
</div>
<script src="{{asset('/assets/select2/select2.min.js')}}"></script>
<style>
	.prosesi-title {
		white-space: nowrap;
        overflow: hidden;
        display: block;
        text-overflow: ellipsis;
	}

</style>
{{-- <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
	$(document).ready(function(){
		$('.drop').click(function(){
			var id_tag=$(this).data('idt');
			var id_post=$(this).data('idp');
			var values = [];
			values.push(id_tag);
			values.push(id_post);
			
			var join_val= values.join(",");
			console.log(join_val);
			// alert(id_post);
			$.ajax({
				url:'/tag/drop_down_t/'+join_val,
				type:'GET',
				dataType:'json',
			    success:function(response)
			    {
			    	var len = 0;
			    	$(".isi$drop->['id_tag']").empty();
			    	if (response != null) {
			    		len = response.length;
			    	}
			    	if (len>0) {
			    		for(var i=0; i<len; i++){
				    		id_tag = response[i].id_tag;
			                nama_tag = response[i].nama_tag;
			                nama_post = response[i].nama_post;
			                gambar = response[i].gambar;
			                id_post = response[i].id_post;
			                id_parent_post = response[i].id_parent_post;

			                var data_tag = '<div class="panel panel-default" style="border: 1px solid #efeef4">'+
											'<img src="/#" width="10%" />'+
											'<div class="card-body">'+
												nama_post+
											'</div>'+
											'<a data-id="#" class="btn btn-delete btn-sm btn-danger btn-card">'+
												'Delete'+
											'</a>'+
										'</div>'

							$(".isi$drop->['id_tag']").append(data_tag);
				    	}
			    	}
			    	
			    },
			    error: function(response) {
			    	console.log(response);
			    }
   			});
		});
	});
</script> --}}
<script>
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	$('.list-tag').select2();
	let id_tag = {!! json_encode($tag_post->id_kategori) !!};
	let id_post = {!! json_encode($tag_post->id_post) !!};
	$('.tag-button').click(function(){
		let tag = $(this).data('tag');
		$.ajax({
			url: "/tag/dropdown",
			type: "get",
			dataType: "json",
			data: {
				id_tag:tag
			},
			success: function (data) {
				let html = '<option value="">Pilih Jenis</option>';
				for(var i=0;i < data.length; i++){
					html+='<option value="'+data[i].id_post+'">'+data[i].nama_post+'</option>';				}
				$('.list-tag').html(html);
				$('.id-tag').val(tag);
				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
	});
</script>
<script>
	$('.list-tag-tabuh').select2();
	let id_tags = {!! json_encode($tag_post->id_kategori) !!};
	let id_posts = {!! json_encode($tag_post->id_post) !!};
	$('#tag-button-tabuh').click(function(){
		let gmbl = $(this).data('gmbl');
		let tags = $(this).data('tags');
		$.ajax({
			url: "/tag/dropdown_tabuh",
			type: "get",
			dataType: "json",
			data: {
				id_tags:tags,
				id_gambelan:gmbl
			},
			success: function (data) {
				console.log(data);
				let html = '<option value="">Pilih Jenis</option>';
				for(var i=0;i < data.length; i++){
					html+='<option value="'+data[i].id_parent_post+'">'+data[i].nama_post+'</option>';
					let rot_post = data[i].id_root_post;
					$('.id-root-post').val(rot_post);				
					}
				$('#list-tag-tabuh').html(html);
				$('.id-tag-tabuh').val(tags);	
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
	});
</script>
@endsection