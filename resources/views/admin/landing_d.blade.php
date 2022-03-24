<!DOCTYPE html>
<html>
<body>
	<div class="panel">
		<div class="panel-body">
			<h2 class="text-center" style="margin-bottom: 1em">
				E-Upacara
			</h2>
			<h3>Selamat Datang, {{Session::get('name')}}</h3>
			<h3>Email : {{Session::get('email')}}</h3>
			<h3>Status Login : {{Session::get('login')}}</h3>
			@foreach($kategori as $kat)
			<p>{{$kat->id_post}} </p>
			<p>{{$kat->nama_kategori}}</p>
			<p>{{$kat->nama_tag}}</p>
			<p>{{$kat->nama_post}}</p>
			<p>{{$kat->deskripsi}}</p>
			<p>{{$kat->id_kategori}}</p>
			@endforeach
			<a href="/logout" class="btn btn-primary btn-block">Logout</a>
		</div>
	</div>
</body>
</html>