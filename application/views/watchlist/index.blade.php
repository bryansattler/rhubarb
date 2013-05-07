@layout('layouts.default')

@section('content')

	@if(!Auth::check())
		
	@else
	<?php $apikey = 'caw7u9euxvcwuabe5zjwe9tg'; ?>
		<h1>My Watchlist</h1>
	<!-- Movie Dropdown options API calls -->	
<!-- Single Movie View */ -->
		<div class="single_movie span12">
			<div class="divShowmovies span8">
				<a class="showMovies" href="javascript:void(0);">Continue Browsing</a>
				<div class="single_movie_content">
					<div class="movierow1"></div>
				</div>
				<div class="movie_reviews"></div>
			</div> <!-- END .divShowmovies -->
			<div class="movie_cast span3"></div>
			

		</div> <!-- END .single_movie -->

<div id="browse">		
<div class="browse-widgets">	
	<span class="movie-count"> There are <span class="count-leftmovies-dynamic"> {{$watchlistMoviesLeft}} </span> Movies in you watchlist and <span class="count-watchedmovies-dynamic">{{$watchedMovies}}</span> Movies Watched</span>

		<ul class="movieResults">
			@foreach ($movies as $movie)
			<div class="movieCard" data-critics="{{$movie->ratings->critics_score}}">
				  <li>
				  	<a href="javascript:void(0);" data-id="{{$movie->id}}" class="movie-detail"><img src="{{$movie->posters->detailed}} " /></a></li>
				  <li class="movieCardInfo">
				  	<a href="javascript:void(0);" data-id="{{$movie->id}}"  class="movie-detail">{{$movie->title}}</a>
				  	<div class="details">		
				  	</div>
				</li>
				<li class="moviestatus">
					@if(isset(Movie::where_movie_id_and_tosee($movie->id,'YES')->first()->id))
					<p style="color:green;" class="movie_{{$movie->id}} yourmoviestatus">Move is currently in your watchlist</p>
					@elseif(isset(Movie::where_movie_id_and_watched($movie->id,'YES')->first()->id))
					<p style="color:green;" class="movie_{{$movie->id}} yourmoviestatus">You have watched the movie</p>
					@else
						<p style="color:red;" class="movie_{{$movie->id}} yourmoviestatus">There is problem with this movie we'll get back to you shortly.</p>
					@endif
				</li>
				<li>
					<div class="changestatusplaceholder">
				 @if(! isset(Movie::where_movie_id_and_watched($movie->id,'YES')->first()->id))
							<a href="javascript:void(0);" class="changemoviestatus" data-id="{{$movie->id}}" data-name="watched">I've seen it</a>
				 @endif
				<a href="javascript:void(0);" class="changemoviestatus" data-id="{{$movie->id}}" data-name="delete"><small> Remove</small></a>
					</div>
				</li>
			</div>	
		@endforeach
		</ul>
	</div>
</div>

		@endif
@endsection

@section('footer_script')


<script>
	$(function() {

		$('.single_movie').hide();
		// anchor tag which shows all the movies when in Single Movie
		$('.showMovies').on('click',function(e) {
			 $('div#browse').show();
			 $('.single_movie').hide()
		});

		// anchor tag that shows single movie in the .single_movie div
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

		   // row 1 of movie info
		   SingleMovieDom.append("<div class='row-fluid movierow1'><div class='movietn'><img src='"+
		   			  data.posters.detailed
		   			  +"' /></div>" +
		   			  "<div class='heading'><h2>" +
                      data.title
                      +"</h2></div><div class='year'>"+
                      data.year
                      +"</div><div class='mpaa_rating'><span>"+
                      data.mpaa_rating
                      +"</span></div><div class='runtime'>"+
                      runtime
                      +"</div></div>");

		   // check the score, display fresh icon if critic_score >= 75%, else display rotten icon
		   var fresh = "<img src='img/rottentomatoes/fresh-24.png' class='tm-icon'/>";
		   var rotten = "<img src='img/rottentomatoes/rotten-24.png' class='tm-icon'/>";
		   var rating = (data.ratings.audience_score >= 75) ? fresh : rotten;

		   // show the audience score
		   SingleMovieDom.append("<div class='criticscore'>"+rating+"<h4>"+data.ratings.audience_score+"%</h4> of Critics liked it<span>Rate This Movie</span></div>");

		   SingleMovieDom.append("<div><i class='fui-heart-24 watched-ico'></i><h4>Seen it?</h4> Add to Your Movies</div>");

		   SingleMovieDom.append("<div class='watchlist'><i class='fui-eye-24 watched-ico'></i><h4>Wanna see it?</h4><div class='addtoWatchListContainer'><a class='addtoWatchList' href='javascript:void(0);' data-id='"+
		   	data.id
		   	+"' title='Add to Watchlist'>Add to Your Watchlist</a></div></div>");

		   // append the synopsis
		   SingleMovieDom.append("<div class='synopsis'> Synopsis: "+data.synopsis+"</div>");

		   SingleMovieDom.append("<div class='directors'><div class='directors_name'>Directed By:</div>");

		   SingleMovieDom.append("<div class='genres'>Genres:</div>");		   

		   //append release date to the parent div i.e div.single_movie_content
		   SingleMovieDom.append(
		   					"<div class='releasedate'>Release Year: "+ 
		   					data.year
		   					+"<br />Theater Release: "+
		   					data.release_dates.theater 
		   					+ "<br />DVD: "+
		   					dvd
		   					+"</div>"
		   			);

		   // map API and Movie Id if it exists
		   $.post(BASE+'/movies/getmovie',{'movie_id':data.id},function(data) {
		   	console.log(data);
		   	if (data.status == 'save') {
		   		 $('.addtoWatchListContainer').html('<p style="color:green;">'+data.message+'</p>');
		   	}
		   },'json');		   

		   var directors = $('.directors');

		   $.each(data.abridged_directors,function(i,value) {
		   	 directors.append("<div class='directors'>"+
		   	 	value.name
		   	 	+
		   	 	"</div>")
		   });

		   var genres = $('.genres');

		   $.each(data.genres,function(i,value) {
		   	   genres.append('<div class="genres_content">'+
		   	   	value
		   	   	+'</div>');
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
			image = $('.image');
			$.each(data.clips,function(i,value) {
				image.append("<div class='videolink rbutton'><a href='"+value.links.alternate+"' target='_blank'>Watch Trailer</a></div>");
				return false;
		   });
		}

		// Change Movie status
		var BASE = "<?php echo URL::base(); ?>";
			$('.changemoviestatus').on('click',function() {
				var currentInstance = $(this);
				// alert(currentInstance.attr('data-id'));
				var name = currentInstance.attr('data-name');
				var id = currentInstance.attr('data-id');
				//changing the value to watch 
				$.post(BASE +'/watchlist/changestatus',{'name':name,'movie_id':id},function(data) {
					console.log(data);

					if (data.status =='changed') {
						$('.movie_'+id).html(data.message);
						$('.count-leftmovies-dynamic').html(data.moviewatchlistcount);
						$('.count-watchedmovies-dynamic').html(data.watchedMovies);
						currentInstance.remove();
					}if(data.status == 'deleted'){
						window.location.href = BASE+'/watchlist/';
					}
				},'json');
			});		

});
</script> <!-- END Single movie -->
@endsection