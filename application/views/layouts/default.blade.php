<!DOCTYPE htm>
<html>
<head>
	<title>{{ $title }}</title>
   	{{ Asset::styles() }}
   	{{ Asset::scripts() }}

    <script src="http://js.pusher.com/2.0/pusher.min.js" type="text/javascript"></script>

</head>
<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand replace" href="/"></a>
				<div class="nav-collapse collapse">
						
						@if(!Auth::check())
						<ul class="nav pull-right">
							<li>{{ HTML::link_to_route('login', 'Login') }}</li>
							<li class="btn-signup">{{ HTML::link_to_route('signup', 'Sign Up') }}</li>
						</ul>
						@else
						<ul class="nav">
						<li>{{ HTML::link_to_route('activity', 'Activity Stream') }}</li>
						<li>{{ HTML::link_to_route('watchlist', 'Watchlist') }}</li>
						<li>{{ HTML::link_to_route('browse', 'Browse') }}</li>
						<li>{{ HTML::link_to_route('logout', 'Logout ('.Auth::user()->username.')') }}</li>
						</ul>
						@endif
				</div>
			</div><!-- end container -->	
		</div><!-- end navbar-inner -->			
	</div><!-- end navbar-->	

	<div class="container">
		
		@if(Session::has('message'))
				<p id="message">{{ Session::get('message') }}</p>
			@endif

			@yield('content')
		<footer class="footer">
			<p class="footer-copyright">&copy; Rhubarb {{ date('Y') }}</p>
		</footer><!-- end footer -->	
			
	</div>			
</body>	
</html>