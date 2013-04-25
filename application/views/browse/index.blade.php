@layout('layouts.default')

@section('content')

	@if(!Auth::check())
		
	@else
		<?php
		$apikey = 'caw7u9euxvcwuabe5zjwe9tg';
		$q = urlencode('Action'); // make sure to url encode an query parameters

		// construct the query with our apikey and the query based on keywords
		// $endpoint = 'http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=' . $apikey . '&q=' . $q;

		// Queries Upcoming Movies 
		$endpoint = 'http://api.rottentomatoes.com/api/public/v1.0/lists/movies/upcoming.json?apikey=' . $apikey . '';


		// setup curl to make a call to the endpoint
		$session = curl_init($endpoint);

		// indicates that we want the response back
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		// exec curl and get the data back
		$data = curl_exec($session);

		// remember to close the curl session once we are finished retrieveing the data
		curl_close($session);

		// decode the json data to make it easier to parse the php
		$search_results = json_decode($data);
		if ($search_results === NULL) die('Error parsing json');

		/* Use jQuery Slider for tomatometer http://jqueryui.com/slider/ */

		// play with the data!
		$movies = $search_results->movies;
		echo '<div id="browse">';
		echo '<ul class="movieResults">';
			foreach ($movies as $movie) {
			  echo '<div class="movieCard">';	
			  echo '<li><img src="'. $movie->posters->detailed .'"</li>';
			  echo '<li class="movieCardInfo"><a href="movie" class="movie">' . $movie->title . '</a></li>';

			  echo '</div>';
			}
		echo '</ul>';
		echo '</div>';	
			?>
		@endif
@endsection