@layout('layouts.default')

@section('content')

	@if(!Auth::check())
		<?php
		$apikey = 'caw7u9euxvcwuabe5zjwe9tg';
		?>

		<h1>Welcome to Rhubarb</h1>
		<h2>Find Movies You'll Love... and fast!</h2>
		<p>Have an account? {{ HTML::link_to_route('login', 'Login') }} <p>

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
		$count = count($movies);

?>

		<!-- Single Movie View */ -->

	    <div class="single_movie container-fluid">
		    <div class="row-fluid"><!-- BEGIN row-fluid #1 -->		    	
			    <div class="divShowmovies span8">
			    	<a class="showMovies btn" href="javascript:void(0);">Continue Browsing</a>
			    	<div class="single_movie_content"> <!-- BEGIN single_movie_content -->	
					</div><!-- END single_movie_content -->
			    </div>	
			    <div class="movie_cast span3"></div><!-- END Cast Sidebar -->
			    <div class="span8"> <!-- BEGIN Critic Reviews -->
		    		<div class="movie_reviews"></div>
		    	</div><!-- END Critic Reviews-->	
		    </div><!-- END row-fluid -->
	    </div>	<!-- container-fluid" -->	
		<br />

	<!-- Movie Dropdown options API calls -->	
	<?php 
			$upcommingMovies = "http://api.rottentomatoes.com/api/public/v1.0/lists/movies/upcoming.json?apikey=".$apikey;
			$opening = "http://api.rottentomatoes.com/api/public/v1.0/lists/movies/opening.json?apikey=".$apikey;
			$newReleases = "http://api.rottentomatoes.com/api/public/v1.0/lists/dvds/new_releases.json?apikey=".$apikey;
			$upcommingDVDs = "http://api.rottentomatoes.com/api/public/v1.0/lists/dvds/upcoming.json?apikey=".$apikey;
			$currentDVDs = "http://api.rottentomatoes.com/api/public/v1.0/lists/dvds/current_releases.json?apikey=".$apikey;
	 ?>	

<?php		

	echo '<div id="browse" class="container-fluid">'; // BEGIN browse nav
		echo '<div class="span12">'; // BEGIN span12
			echo '<div class="movie-count span2">' . $count . ' movies</div>'; // results count
			echo '<div class="tomatometer span5">'; // BEGIN tomatometer
				echo '<div class="row-fluid">';
					echo '<div class="span5">'; // tm label & icon
						echo '<h5 class="tmLabel">Tomatometer <img src="img/rottentomatoes/rotten-12.png" class="tm-icon-small"/></h5>';
					echo '</div>';
					echo '<div class="span7">'; // slider
						echo '<div id="slider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false" style="float:left;">';
						echo '<div class="ui-slider-segment"></div>';
						echo '<div class="ui-slider-segment"></div>';
						echo '<div class="ui-slider-segment"></div>';
						echo '<div class="ui-slider-range ui-widget-header ui-slider-range-min" style="width: 0%;"></div>';
						echo '<a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 25%;"></a><img src="img/rottentomatoes/fresh-12.png" class="tm-icon-small fresh"/>';
					echo '</div>';
				echo '</div>';
			echo '</div>'; // END tomatometer

		echo '</div>';// END span12
					echo '<div class="sortdd span5">'; // BEGIN dropdown
					echo '<div id="dk_container_herolist" class="dk_container span3 dk_shown dk_theme_default" tabindex="1">';
						echo '<h5 class="sortDk">Sort by</h5>';
						echo '<a class="dk_toggle">
							<span class="dk_label">Upcoming Movies</span>
							<span class="select-icon"></span>
						</a>';
						echo '<div class="dk_options">';
							echo '<ul class="dk_options_inner">';
							echo '<li class="">
							<a href="#" data-dk-dropdown-value="0">Choose your results</a>
							</li>';
							echo '<li class="">
							<a href="'.$upcommingMovies.'" data-dk-dropdown-value="Upcoming">Upcoming Movies</a>
							</li>';
							echo '<li class="">
							<a href="'.$opening.'" data-dk-dropdown-value="Opening">Opening Movies</a>
							</li>';
							echo '<li class="">
							<a href="'.$newReleases.'" data-dk-dropdown-value="New">New Releases DVDs</a>
							</li>';
							echo '<li class="">
							<a href="'.$upcommingDVDs.'" data-dk-dropdown-value="UpDVDs">Upcoming DVDs</a>
							</li>';
							echo '<li class="">
							<a href="'.$currentDVDs.'" data-dk-dropdown-value="NewDVDs">Current DVDs</a>
							</li>';
							echo '</ul>';
						echo '</div>'; // end .dk_options
					echo '</div>'; // end .dk_options

				echo '</div>'; // end #dk_container_herolist
			echo '</div>'; // END dropdown
	echo '</div>'; // END browse nav			

			echo '<span class="stretch"></span>';	
			echo '<br />';

		echo '<ul class="movieResults">';
			foreach ($movies as $movie) {
			 $watchlist = isset(Movie::where_movie_id_and_watched($movie->id, 'YES')->first()->id) ? 'watchlistClass' : '';	
			  echo '<div class="movieCard" data-critics="'.$movie->ratings->audience_score.'">';	
  			  echo '<li class="seenit-btn '.$watchlist.'"><a href="javascript:void(0);" data-id="'.$movie->id.'" class="grabmovietowatchlist"><i class="fui-heart-24"></i></a></li>';
			  echo '<li><a href="javascript:void(0);" data-id="'.$movie->id.'" class="movie-detail"><img src="'. $movie->posters->detailed .'" /></a></li>';

			  echo '<li class="movieCardInfo"><a href="javascript:void(0);" data-id="'.$movie->id.'"  class="movie-detail">' . $movie->title . '</a><div class="details"></div></li>';

			  echo '</div>';
			}
		echo '</ul>';
		echo '</div>';	
		?>
		@endif

@endsection

@section('footer_script')

		
<script>// Single Movie

	$(function() {

		$('.single_movie').hide();
		//a anchor tag which shows back all the movies when in Single Movie
		$('.showMovies').on('click',function(e) {
			 $('div#browse').show();
			 $('.single_movie').hide()
		});


		
		// anchor tag that shows single movie on to the .single_movie div
		$('a.movie-detail').live('click',function(e) {
			$('div#browse').fadeOut('slow');
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
		   
		var BASE = "<?php echo URL::base(); ?>";

		   //shows the single movie div
		   $('.single_movie').show();

		   // captures the manipulatable DIV
		   var SingleMovieDom = $('.single_movie_content');

		   //setting the $('.single_movie_content') to empty (clears previous data when user goes back)
		   
		   SingleMovieDom.html('');   
		   
		   //checks if the runtime of movie has data or not
		   runtime =  data.runtime ? data.runtime+" mins" : "Unavailable";
		   dvd = data.release_dates.dvd ? data.release_dates.dvd : "Unavailable";

		   // appends div.image to the $('.single_movie_content')
		   // SingleMovieDom.append("<div class='image'><img src='"+data.posters.detailed+"' /></div>");

		   // check the score, display fresh icon if critic_score >= 75%, else display rotten icon
		   var fresh = "<img src='img/rottentomatoes/fresh-24.png' class='tm-icon'/>";
		   var rotten = "<img src='img/rottentomatoes/rotten-24.png' class='tm-icon'/>";
		   var score = (data.ratings.audience_score >= 75) ? fresh : rotten;
		   // check the length of the rating string, if greater than 4 display
		   var rating = (data.mpaa_rating.length <= 4) ? data.mpaa_rating : "NR";
		   var rDate = data.release_dates.theater;
		   rDate = rDate.replace(/^(\d{4})\-(\d{2})\-(\d{2}).*$/, '$2/$3/$1');

		   SingleMovieDom.append("<div class='row-fluid'><div class='movietn span3'><img src='"+
				data.posters.detailed 
				+"' /></div><div class='movierow1 span9'><div class='heading'><h3>" +     
				data.title 
				+"</h3></div><div class='moviebasics'><div class='year span1'>" +
				data.year 
				+"</div><div class='mpaa_rating'>"+
				rating
				+"</div><div class='runtime span2'>"+
              	runtime
              	+"</div></div></div><div class='movierow2 span9'><div class='criticscore span4'>"+
			   	
			   	"<h4>"+ score + " " +
			   	data.ratings.audience_score
			   	+"% <small>of Critics liked it</small> <br /><small>Rate This Movie</small></h4></div>"
			   	+"<div class='span3'><h4><i class='fui-heart-24 watched-ico'></i> Seen it? <br /><small>Add to Your Movies</small></h4></div>"
			   	+"<div class='watchlist span4'><h4><i class='fui-eye-24 watched-ico'></i> Wanna see it?<div class='addtoWatchListContainer'><small><a class='addtoWatchList' href='javascript:void(0);' data-id='" +
			   	data.id
			   	+"title='Add to Watchlist'>Add to Your Watchlist</a></small></div></h4></div></div><div class='synopsis span9'>"+data.synopsis+"</div><div class='movierow3 span9'><div class='span6'><div class='directors'><small><strong>Directed By:</strong> </small></div><div class='genres'><small><strong>Genres:</strong> </div></div><div class='span6'><strong>In Theaters:</strong> "
		   		+ rDate 
	   			+ "<br /><strong>On DVD:</strong> " +
	   			dvd
	   			+ "<br /><strong>Studio:</strong> " + data.studio + "</small>");
						


		   //mapping API and Db Movie Id if it exists
		   $.post(BASE+'/movies/getmovie',{'movie_id':data.id},function(data) {
		   	if (data.status == 'save') {
		   		 $('.addtoWatchListContainer').html('<p style="color:green;">Saved in Watchlist</p>');
		   	}
		   },'json');		   


		   var genres = $('.genres');

		   $.each(data.genres,function(i,value) {
		   	   genres.append('<small>'+
		   	   	value
		   	   	+'<small>');
		   });

		   var directors = $('.directors');

		   $.each(data.abridged_directors,function(i,value) {
		   	 directors.append("<div class='directors'><small>"+
		   	 	value.name
		   	 	+
		   	 	"</small></div>")
		   });


		   // shorten the long synopsis
		   $(".synopsis").each(function(i){
			    len=$(this).text().length;
			    if(len>250)
			    {
			      $(this).text($(this).text().substr(0,250)+'...');
			    }
			  });

		   	reviewurl = "http://api.rottentomatoes.com/api/public/v1.0/movies/"+data.id+"/reviews.json?apikey=<?php echo $apikey; ?>";
		   	castUrl = "http://api.rottentomatoes.com/api/public/v1.0/movies/"+data.id+"/cast.json?apikey=<?php echo $apikey; ?>";
		   	trailerUrl = "http://api.rottentomatoes.com/api/public/v1.0/movies/"+data.id+"/clips.json?apikey=<?php echo $apikey; ?>&limit=1";
		    // display reviews
		    $.ajax({
		    	    url: reviewurl,
				    dataType: "jsonp",
				    success: review_callback
			});

		    // display cast
		    $.ajax({
		    	url: castUrl,
				dataType: "jsonp",
				success: cast_callback
		    });

		    $.ajax({
		    	    url: trailerUrl,
				    dataType: "jsonp",
				    success: trailer_callback
		    });
		}

		function cast_callback(data) {
			var movieCast = $('.movie_cast');
			if (data.total == '0') {
				return false;
			}
			movieCast.html('');
			movieCast.append("<div class='movie_cast_container'><h3>The Cast</h3></div>");
			 var cast = $('.movie_cast_container');

		   // loop through abridged_cast because its an array
			$.each(data.cast, function(i, value) {
				if(value.characters != ''){ characters = ' - (' +value.characters+')'}
				     else{characters = '';}

				         cast.append("<div class='cast'>"+value.name + characters +"</div>")
				});

		}


		function review_callback(data) {
			var movieReviews = $('.movie_reviews');
			if (data.total == '0') {
				return false;
			}
			movieReviews.html('');
			movieReviews.append("<div class='movie_review_container'><h3>Critic Reviews</h3></div>");
			 var review = $('.movie_review_container');

		   $.each(data.reviews,function(i,value) {
		   	   review.append('<div class="reviews-critics">Name: '+
		   	   		value.critic +' - '+value.date +'<br />Quote: '+value.quote
		   	   		+'<br />Publication: '+
		   	   		value.publication
					+'<br></div>');
		   });

		}

		function trailer_callback(data)
	    {
		   console.log(data);
		   movietn = $('.movietn');
		   $.each(data.clips,function(i,value) {
		   movietn.append("<div class='videolink rbutton'><a href='"+value.links.alternate+"' target='_blank'>Watch Trailer</a></div>");
		    return false;
		     });
	    }

});
</script> <!-- END Single movie -->
<script> // Tomatometer
    	$(function() {

		     //Slider Controller 
			 $( "#slider" ).slider({
			      range: "min",
			      value: 100,
			      min: 1,
			      max: 100,
			      slide: function( event, ui ) {

			      	value = ui.value; //capturing current value
			        
			        // storing all of the movies div in a variable with a class of movieCard
			        var moviefilterSliders = $('.movieResults').find('.movieCard');
			        // $('.movie-count').html(value + ' Movies');
			        var totalMovies = moviefilterSliders.length;
			        //looping through the all movie class of movieCard and filtering with hide/show
					moviefilterSliders.each(function(i,value) {
						 var count = parseInt($(value).attr('data-critics'));
						if ( count <= ui.value) {
							 $(value).show();
						}else{
							$(value).hide();
						}			
					});
					
			      }
			    });
		});

</script> <!-- END Tomatometer --> 
<script> // Sort by Dropdown
	$(function() {

		$('ul.dk_options_inner li a').on('click',function(e) {
			e.preventDefault();
			$('.dk_label').html($(this).text());
			var searchUrl = $(this).attr('href');
			if (searchUrl == '#') {
				return false;
			}
			$.ajax({
		    	    url: searchUrl,
				    dataType: "jsonp",
				    success: sort_dropdown_callback
		    });

		});

		function sort_dropdown_callback(data) {
			console.log(data);
			var movieContainer = $('ul.movieResults');
				movieContainer.html('');

			 $.each(data.movies,function(i, movie) {
			 	 
				 movieContainer.append("<div class='movieCard' data-critics='"+ movie.ratings.audience_score 
				 					+"'><li><a href='javascript:void(0);' data-id='"+movie.id+"' class='movie-detail'><img src='"+ 
				 						movie.posters.detailed +
				 					"'/></a></li><li class='movieCardInfo'><a href='javascript:void(0);' data-id='"+
				 						movie.id +
				 						"' class='movie-detail'>" + 
				 						movie.title + 
				 						"</a><div class='details'></div></li></div>");
			 });
		}		
	});
</script> <!-- END Sort by Dropdown -->

<script> // Add Movies to Watchlist
	$(function() {
		var BASE = "<?php echo URL::base(); ?>";
		$('.addtoWatchList').live('click',function(e) {
			e.preventDefault();
			var id = $(this).attr('data-id');
			var link = "http://api.rottentomatoes.com/api/public/v1.0/movies/"+id+".json?apikey=<?php echo $apikey; ?>";
			$.post(BASE+'/movies/save', {'movie_link':link}, function(data) {
				    if (data.status == 'save') {
				    	$('.addtoWatchListContainer').html('<p style="color:green;">Successfully added to watchlist</p>');
				    };
				});
		});


		$('.grabmovietowatchlist').live('click',function() {
			 var movieid = $(this).attr('data-id');
			 // console.log($(this).parent());
			 var fieldname = '';
			 if ($(this).parent().hasClass('watchlistClass')){
			 	fieldname = 'delete'; // changing it to tosee because we are changing the status of the page which is already watched
			 	$(this).parent().removeClass('watchlistClass');
			 }else{
			 	fieldname = 'tosee';
			 	$(this).parent().addClass('watchlistClass');
			 }

			 $.post(BASE+'/movies/addremovemovie', {'movie_id':movieid,'fieldname':fieldname}, function(data) {
				    if (data.status == 'save') {
				    	alert('Movie Saved');
				    }else if(data.status == 'success'){
				    	alert('Movie Removed');
				    }else{
				    	alert('Failed to process your request');
				    }
				},'json');
		});
		$('.seenit-btn').hide();

		$(".movieCard").hover(
	      function(){
	      	$(this).find('.seenit-btn').show();
	      	var currentMovie = $(this).find('.seenit-btn');
	      	 console.log(currentMovie);
	      }, 
	      function() {
	      	if ($(this).find('.seenit-btn').hasClass('watchlistClass')) {

	      	}else{
	      		$(this).find('.seenit-btn').hide();
	      	}
	      }
	    );

		$('.watchlistClass').show();

	});
</script> <!-- END Add Movies to Watchlist -->
<style>
.watchlistClass {
  border-bottom: 50px solid transparent;
  border-right: 50px solid #DB335B;
}

</style>
@endsection
