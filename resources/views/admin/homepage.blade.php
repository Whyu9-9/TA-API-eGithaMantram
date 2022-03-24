@extends('admin/layouts.app')

@section('konten')
<div class="row">
    <div class="col-lg-12">
    	<h1 class="page-header">Dashboard</h1>
	</div>
</div>
<div class="row">
    @foreach($dashboard as $dash)
    @if($dash->nama_kategori != '')
    <div class="col-xs-6 col-md-2 col-lg-2">
        <div class="panel panel-teal">
            <div class="panel-body">
                <span>{{$dash->nama_kategori}}</span>
                @if ($dash->id_post != '')
                    <h1 class="text-center" style="margin: 1em 0 0.5em; color: white; font-weight: bold">{{$dash->id_post}}</h1>
                @else
                    <h1 class="text-center" style="margin: 1em 0 0.5em; color: white; font-weight: bold">Tidak ada data</h1>
                @endif
            </div>
        </div>
    </div>
    {{-- @else
    <div class="col-xs-6 col-md-2 col-lg-2">
        <div class="panel panel-teal">
            <div class="panel-body">
                <span>Umum</span>
                <h1 class="text-center" style="margin: 1em 0 0.5em; color: white; font-weight: bold">{{$dash->id_post}}</h1>
            </div>
        </div>
    </div> --}}
    @endif
    @endforeach
</div>
@endsection