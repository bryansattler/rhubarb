<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Laravel: A Framework For Web Artisans</title>
	<meta name="viewport" content="width=device-width">
	   
</head>
<body>
	<div class="wrapper">
		<header>
			<h1>Rotten Tomatoes Test</h1>

			<?php
				$apikey = 'caw7u9euxvcwuabe5zjwe9tg';
				$q = urlencode('Toy Story'); // make sure to url encode an query parameters

				// construct the query with our apikey and the query we want to make
				$endpoint = 'http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=' . $apikey . '&q=' . $q;

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

				// play with the data!
				$movies = $search_results->movies;
				echo '<ul>';
				foreach ($movies as $movie) {
				  echo '<li><a href="' . $movie->links->alternate . '">' . $movie->title . " (" . $movie->year . ")</a></li>";
				}
				echo '</ul>';

				?>
	</div>
</body>
</html>
