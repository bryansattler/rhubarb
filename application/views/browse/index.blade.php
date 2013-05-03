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

		// show the results from the API
		$movies = $search_results->movies;

?>

		<!-- Single Movie View. Hidden by default until movie title */ -->
		<div class="single_movie span12">
			<div class="divShowmovies"><a class="showMovies" href="javascript:void(0);">Show All Movies</a>
				<div class="single_movie_content"></div>
			</div> <!-- END .divShowmovies -->
			
		</div> <!-- END .single_movie -->
		<br />


<?php		
		echo '<div class="browse">';

			echo '<div class="browse-widgets">';

				// Total count of movies results
				echo '<span class="movie-count">25 movies</span>';

				// Tomatometer
				echo '<h5 class="tmLabel">Tomatometer</h5>';
				echo '<img src="img/rottentomatoes/rotten-12.png" class="tm-icon-small"/>';
				echo '<div class=tomatometer>';
					
					echo '<div id="slider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">';
						echo '<div class="ui-slider-segment"></div>';
						echo '<div class="ui-slider-segment"></div>';
						echo '<div class="ui-slider-segment"></div>';
						echo '<div class="ui-slider-range ui-widget-header ui-slider-range-min" style="width: 0%;"></div>';
						echo '<a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 25%;"></a>';
					echo '</div>'; // end #slider
				echo '</div>'; // end .tomatometer
				echo '<img src="img/rottentomatoes/fresh-12.png" class="tm-icon-small fresh"/>';
				//  Sort by Dropdown 
				echo '<div id="dk_container_herolist" class="dk_container span3 dk_shown dk_theme_default" tabindex="1">';
					echo '<h5 class="sortDk">Sort by</h5>';
					echo '<a class="dk_toggle">
						<span class="dk_label">Upcoming Movies</span>
						<span class="select-icon"></span>
					</a>';
					echo '<div class="dk_options">';
						echo '<ul class="dk_options_inner">';
						echo '<li class="">
						<a data-dk-dropdown-value="0">Choose your results</a>
						</li>';
						echo '<li class="dk_option_current">
						<a data-dk-dropdown-value="Upcoming">Upcoming Movies</a>
						</li>';
						echo '<li class="">
						<a data-dk-dropdown-value="Opening">Opening Movies</a>
						</li>';
						echo '<li class="">
						<a data-dk-dropdown-value="New">New Releases DVDs</a>
						</li>';
						echo '<li class="">
						<a data-dk-dropdown-value="UpDVDs">Upcoming DVDs</a>
						</li>';
						echo '<li class="">
						<a data-dk-dropdown-value="NewDVDs">New Release DVDs</a>
						</li>';
						echo '</ul>';
					echo '</div>'; // end .dk_options
				echo '</div>'; // end .dk_options

			echo '</div>'; // end #dk_container_herolist
			echo '<span class="stretch"></span>';	
			echo '<br />';
		echo '<ul class="movieResults">';
			foreach ($movies as $movie) {
			  echo '<div class="movieCard">';	
			  echo '<li><img src="'. $movie->posters->detailed .'"</li>';
			  // echo '<li class="movieCardInfo"><a href="movie" class="movie">' . $movie->title . '</a></li>';

			  echo '<li class="movieCardInfo"><a href="javascript:void(0);" data-id="'.$movie->id.'" class="movie-detail">' . $movie->title . '</a><div class="details"></div></li>';


			  /*
			  	
			  	Need to link to get the id of that movie,
			  	pass it to a variable
			  	get that variable and use it to display movie info detail page
			  	with AJAX replacing the contents of browse div
			  	http://developer.rottentomatoes.com/docs/read/json/v10/Movie_Info

			   */

			  echo '</div>';
			}
		echo '</ul>';
		echo '</div>';	
			?>
		@endif
@endsection

@section('footer_script')

		
<script>

	$(function() {

		$('.single_movie').hide();
		
		//a anchor tag which shows back all the movies when in Single Movie
		$('.showMovies').on('click',function(e) {
			 $('div.browse').show();
			 $('.single_movie').hide()
		});

		// anchor tag that shows single movie on to the .single_movie div
		$('a.movie-detail').on('click',function(e) {
			$('div.browse').fadeOut('slow');
			e.preventDefault();
			var movieid = $(this).attr('data-id');
			var link = "http://api.rottentomatoes.com/api/public/v1.0/movies/"+movieid+".json?apikey=<?php echo $apikey; ?>";
			
			 // send off the query
			  $.ajax({
				    url: link,
				    dataType: "jsonp",
				    success: searchCallback
				  });
			});
		

		// callback for when we get back the results 
		function searchCallback(data) {
		   
		   //shows the single movie div
		   $('.single_movie').show();

		   // captures the manipulatable DIV
		   var SingleMovieDom = $('.single_movie_content');
		   //setting the $('.single_movie_content') to empty (because if we want to go back again and display it will clear previous data)
		   SingleMovieDom.html(''); 
		   //checks if the runtime of movie has data or not
		   runtime =  data.runtime ? data.runtime+" mins" : "Unavailable";

		   // appends div.image to the $('.single_movie_content') you can access the css select as .image or you can change it if you'd like
		   // I have done nothing with it just given the name
		   SingleMovieDom.append("<div class='image'><img src='"+data.posters.profile+"' /></div>");

		   //same as above but its for movie title
		   SingleMovieDom.append("<div class='heading'>Movie Name: "+data.title+"</div>");

		   //appening into the parent div i.e div.single_movie_content
		   SingleMovieDom.append("<div class='releasedate'> Year: "+ data.year +"<br />Release Date: "+data.release_dates.theater +"</div>");

		   //apppening runtime 
		   SingleMovieDom.append("<div class='runtime'>Run Time: "+runtime+" </div>");

		   //appening the audience score
		   SingleMovieDom.append("<div class='criticalscore'>Score: "+data.ratings.audience_score+"%</div>");

		   // appening synopsis
		   SingleMovieDom.append("<div class='synopsis'> Synopsis: "+data.synopsis+"</div>");

		   //appending artists / Casts
		   SingleMovieDom.append("<div class='artists'><div class='artist_names'><h2>Cast:</h2></div></div>");

		   // capturing artists DOM to artist
		   var artist = $('.artists');

		   // looping through abridged_cast because its an array
		   $.each(data.abridged_cast, function(i, value) {
			   	artist.append("<div class='cast'>"+value.name+"</div>")
		    });

		   //shortening the long synopsis
		   $(".synopsis").each(function(i){
			    len=$(this).text().length;
			    if(len>250)
			    {
			      $(this).text($(this).text().substr(0,250)+'...');
			    }
			  });
		}

});
</script>



@endsection
