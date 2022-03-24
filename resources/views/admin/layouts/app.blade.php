<!DOCTYPE html>
<html>
<head>
	<title>E-Upacara</title>
</head>
<body>
	@include('admin/layouts.head')

	@include('admin/layouts.navigator')

	@include('admin/layouts.sidebar')
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		@yield('konten')
	</div>

@include('admin/layouts.footer')

</body>
</html>