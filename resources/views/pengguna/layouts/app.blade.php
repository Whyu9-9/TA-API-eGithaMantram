<!DOCTYPE html>
<html>
<head>
	<title>E-Upacara</title>
</head>
<body>
	@include('pengguna/layouts.head')

	@include('pengguna/layouts.navigation')

	<div class="container pt-5">
		@yield('konten')
	</div>

@include('pengguna/layouts.footer')

</body>
</html>