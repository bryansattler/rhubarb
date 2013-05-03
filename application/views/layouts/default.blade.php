<!DOCTYPE htm>
<html>
<head>
	<title>{{ $title }}</title>
   	{{ Asset::styles() }}
   
   	<noscript>This page uses Javascript. Your browser either
		doesn't support Javascript or you have it turned off.
		To see this page as it is meant to appear please use
		a Javascript enabled browser.</noscript>

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
							<li class="btn-header">{{ HTML::link_to_route('signup', 'Sign Up') }}</li>
						</ul>
						@else<!-- Show this nav if user is logged in-->
						<ul class="nav">
							<li><a href="/activity"><i class="fui-bubble-24"></i> Activity Stream</a></li>
							<li><a href="/watchlist"><i class="fui-eye-24"></i> Watchlist</a></li>
							<li><a href="/browse"><i class="fui-menu-24"></i> Browse</a>
								<ul>
									<li><a href="#">Action &amp; Adventure</a></li>
									<li><a href="#">Art &amp; Foreign</a></li>
									<li><a href="#">Classics</a></li>
									<li><a href="#">Comedy</a></li>	
									<li><a href="#">Documentary</a></li>
									<li><a href="#">Drama</a></li>
									<li><a href="#">Horror</a></li>
									<li><a href="#">Kids &amp; Family</a></li>
									<li><a href="#">Mystery</a></li>
									<li><a href="#">Romance</a></li>
									<li><a href="#">Sci-fi &amp; Fantasy</a></li>			
								</ul>	
							</li>
							<li class="btn-header"><a href="#"><i class="icon-search icon-white"></i> </a></li>
							<li class="btn-header"><a href="#"><i class="icon-cog icon-white"></i><img src="img/user/profile-pic.png" class="pic-sm"/><span class="hidden">Search</span></a>
								<ul>
									<li> <a href="#">My Profile</a></li>
									<li>{{ HTML::link_to_route('logout', 'Logout ('.Auth::user()->username.')') }}</li>
								</ul>	
							</li>
							
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
	{{ Asset::scripts() }}
	<script>
		
	</script>
    <!-- <script src="http://js.pusher.com/2.0/pusher.min.js" type="text/javascript"></script> -->
@yield('footer_script') <!-- Yields the script for the Browse view -->
</body>	
</html>