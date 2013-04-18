<!DOCTYPE htm>
<html>
<head>
	<title>{{ $title }}</title>
	{{ HTML::style('/css/style.css') }}
</head>

<body>
	<div id="container">

		<div id="header">
			{{ HTML::link('/', 'Rhubarb') }}
		</div><!-- end header -->

		<div id="nav">
			<ul>
				@if(!Auth::check())
				<li>{{ HTML::link_to_route('signup', 'Sign Up') }}</li>
				<li>{{ HTML::link_to_route('login', 'Login') }}</li>
				@else
				<li>{{ HTML::link_to_route('activity', 'Activity Stream') }}</li>
				<li>{{ HTML::link('/', 'Watch List') }}</li>
				<li>{{ HTML::link('/', 'Browse') }}</li>
				<li>{{ HTML::link_to_route('logout', 'Logout ('.Auth::user()->username.')') }}</li>
				@endif
			</ul>	
		</div><!-- end nav -->

		<div id="content">
			@if(Session::has('message'))
				<p id="message">{{ Session::get('message') }}</p>
			@endif

			@yield('content')
		</div><!-- end content -->		

		<div id="footer">
			&copy; Rhubarb {{ date('Y') }}
		</div><!-- end footer -->		

	</div><!-- end container -->		
</body>	
</html>