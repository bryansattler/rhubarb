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
	            <button class="btn btn-navbar collapsed" data-target=".nav-collapse" data-toggle="collapse" type="button">
	              <span class="icon-bar"></span>
	              <span class="icon-bar"></span>
	              <span class="icon-bar"></span>
	            </button>
	            <!-- Logo -->				
				<a class="brand replace" href="/"></a>


				@if(!Auth::check()) <!-- Show this nav if user isn't logged in -->
				<div class="nav-collapse collapse" style="height: 0px;">
						<ul class="nav pull-right">
							<li>{{ HTML::link_to_route('login', 'Login') }}</li>
							<li class="btn-header">{{ HTML::link_to_route('signup', 'Sign Up') }}</li>
						</ul>		
				</div><!-- /.nav-collapse .collapse -->

				@else<!-- Show this nav if user is logged in-->
				<div class="nav-collapse collapse" style="height: 0px;">
						<ul class="nav">
							<li class=""><a href="/watchlist"><i class="fui-eye-24"></i> Watchlist</a></li>
							<li><a href="/"><i class="fui-menu-24"></i> Browse</a></li>							
						</ul>
						<div class="nav pull-right usernav">
							<!-- <li>
								{{Form::open('search', 'POST', array('class' => 'search-input','id' => 'search-input')) }}
								{{Form::text('search')}}


								<!-- <li><button class="btn-header search-btn"><i class="icon-search icon-white"></i> </button></li> -->
								<!-- {{Form::close()}} -->

							</li>
							
							<li class="btn-header userdd"><a href="#"><i class="icon-cog icon-white"></i><span class="hidden">Search</span></a>
								<ul class="dropdown-menu" aria-labelledby="drop3" role="menu">
									<li> <a href="/profile">My Profile</a></li>
									<li>{{ HTML::link_to_route('logout', 'Logout ('.Auth::user()->username.')') }}</li>
								</ul>	
							</li>
						</div>	
					</div><!-- /.nav-collapse .collapse -->
					@endif
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

@yield('footer_script') <!-- Yields the script for the Browse view -->
</body>	
</html>