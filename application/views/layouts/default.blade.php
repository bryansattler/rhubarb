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
				<!-- Responsive Menu Button -->
	            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	              <span class="icon-bar"></span>
	              <span class="icon-bar"></span>
	              <span class="icon-bar"></span>
	            </button>
	            <!-- Logo -->				
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
	</div><!-- end content container -->
	<div id="push"></div>

	<footer class="footer">
		<div class="container">
			<p class="muted credit">&copy; Rhubarb {{ date('Y') }}</p>
		</div>
	</footer><!-- end footer -->					
</body>	
</html>