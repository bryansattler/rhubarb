<!DOCTYPE htm>
<html>
<head>
	<title>{{ $title }}</title>
   	{{ Asset::styles() }}
   	{{ Asset::scripts() }}

   	<noscript>This page uses Javascript. Your browser either
		doesn't support Javascript or you have it turned off.
		To see this page as it is meant to appear please use
		a Javascript enabled browser.</noscript>

    <!-- <script src="http://js.pusher.com/2.0/pusher.min.js" type="text/javascript"></script> -->

</head>
<body>

<div id="wrap">
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
						
						@if(!Auth::check()) <!-- Show this nav if user isn't logged in -->
						<ul class="nav pull-right">
							<li>{{ HTML::link_to_route('login', 'Login') }}</li>
							<li class="btn-signup">{{ HTML::link_to_route('signup', 'Sign Up') }}</li>
						</ul>
						@else<!-- Show this nav if user is logged in-->
						<ul class="nav">
							<li>{{ HTML::link_to_route('activity', 'Activity Stream') }}</li>
							<li>{{ HTML::link_to_route('watchlist', 'Watchlist') }}</li>
							<li>{{ HTML::link_to_route('browse', 'Browse') }}</li>
							<li>{{ HTML::link_to_route('logout', 'Logout ('.Auth::user()->username.')') }}</li>
						</ul>
						@endif
				</div><!-- /.nav-collapse .collapse -->
			</div><!-- /.container for nav -->	
		</div><!-- /.navbar-inner -->			
	</div><!-- /.navbar .navbar-fixed-top -->	

	<div class="container">
		
		@if(Session::has('message'))
				<p id="message">{{ Session::get('message') }}</p>
			@endif

			@yield('content')			
	</div><!-- /.container for content -->
	<div id="push"></div>
</div><!-- /#wrap -->
	<footer class="footer">
		<div class="container">
			<p class="muted credit">&copy; Rhubarb {{ date('Y') }}</p>
		</div>
	</footer><!-- /footer -->					
</body>	
</html>