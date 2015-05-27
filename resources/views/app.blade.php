<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RMACRAO</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapseable">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">RMACRAO</a>
			</div>

			<div class="collapse navbar-collapse" id="collapseable">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url('/years/') }}">Years</a></li>
					<li><a href="{{ url('/sessions/') }}">Sessions</a></li>
					<li><a href="{{ url('/speakers/') }}">Speakers</a></li>
					<li><a href="{{ url('/exhibitors/') }}">Exhibitors</a></li>
					<li><a href="http://rmacrao.org">RMACRAO.org</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		@if (Session::has('message'))
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<p>{{Session::get('message')}}</p>
			</div>
		@endif

		@if (Session::has('error'))
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
				<p>{{Session::get('error')}}</p>
			</div>
		@endif

		@yield('content')
	</div>

	<!-- Scripts -->
	<script src="/js/jquery-2.1.3.min.js"></script>
	<script src="/js/bootstrap-3.3.1.min.js"></script>

	@yield('scripts')
</body>
</html>
