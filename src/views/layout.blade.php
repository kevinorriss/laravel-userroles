<!DOCTYPE html>
<html lang="en">
<head>

	<!-- default meta tags (must come first) -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

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

	<h1 class="text-center">User Roles</h1>

	<div class="container">
	    <div class="row">
	        <div class="col-md-8 col-md-offset-2">
	        	<ul class="nav nav-tabs">
					<li {!! Request::is('roles', 'roles/*') ? 'class="active"' : '' !!}>
						<a href="{!! route('roles.index') !!}">Roles</a>
					</li>
					<li {!! Request::is('role_groups', 'role_groups/*') ? 'class="active"' : '' !!}>
						<a href="{!! route('role_groups.index') !!}">Role Groups</a>
					</li>
					<li class="disabled{!! Request::is('user_roles', 'user_roles/*') ? ' active' : '' !!}">User Roles</li>
				</ul>
	        </div>
		</div>
	</div>
	<br/>

	<!-- Maint page content -->
	@yield('content')

	<!-- JavaScripts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</body>
</html>
