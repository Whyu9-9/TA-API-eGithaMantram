<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>
        E-Upacara
    </title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="</assets/css/styles.css" rel="stylesheet">

    <style>
        .sidebar ul.nav li.parent ul li a {
            padding-left: 43px;
        }
    </style>
</head>
<body>
	<div style="padding-top: 5rem; margin: auto; width: 480px;">
		<div class="panel">
			<div class="panel-body">
				<h2 class="text-center" style="margin-bottom: 1em">
					E-Upacara
				</h2>
				@if(\Session::has('alert'))
				<div class="alert alert-danger">
					<span>
						{{Session::get('alert')}}
					</span>
				</div>
				@endif
				@if(\Session::has('alert-success'))
				<div class="alert alert-success">
					<span>
						{{Session::get('alert-success')}}
					</span>
				</div>
				@endif
				<form class="form" action="/login_auth" method="POST">
					{{ csrf_field() }}
					<input type="text" name="us_name" placeholder="Username" class="form-control" style="margin-bottom: 16px" required />
					<input type="password" name="pwd" placeholder="Password" class="form-control" style="margin-bottom: 16px" required />
					<button type="submit" class="btn btn-primary btn-block">Login</button>
				</form>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
</script>
</html>