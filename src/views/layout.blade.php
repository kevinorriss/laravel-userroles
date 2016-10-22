<!DOCTYPE html>
<html lang="en">
<head>

	<!-- default meta tags (must come first) -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Page title -->
	<title>User Roles</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>

	<nav class="navbar navbar-default">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<span class="navbar-brand">User Roles</span>
			</div>

			<div class="collapse navbar-collapse" id="navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
					@if (Auth::user()->hasRole('role_browse'))
						<li {!! Request::is('roles', 'roles/*') ? 'class="active"' : '' !!}>
							<a href="{{ route('roles.index') }}">
								<span>Roles</span>
							</a>
						</li>
					@endif
					@if (Auth::user()->hasRole('role_group_browse'))
						<li {!! Request::is('role_groups', 'role_groups/*') ? 'class="active"' : '' !!}>
							<a href="{{ route('role_groups.index') }}">
								<span>Groups</span>
							</a>
						</li>
					@endif
					@if (Auth::user()->hasRole('user_role_browse'))
						<li {!! Request::is('user_roles', 'user_roles/*') ? 'class="active"' : '' !!}>
							<a href="{{ route('user_roles.index') }}">
								<span>Users</span>
							</a>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	<!-- Maint page content -->
	@yield('content')

	<!-- JavaScripts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</body>
</html>
