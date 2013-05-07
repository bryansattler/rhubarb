@layout('layouts.default')

@section('content')

	
		<!-- Single Movie View */ -->
		<div class="single_movie span12" style="margin-top:100px;">
			<div class="divShowmovies span8">
				<a class="showMovies" href="javascript:void(0);">Continue Browsing</a>
				<div class="single_movie_content">
					<div class="movierow1"></div>
				</div>
				<div class="movie_reviews"></div>
			</div> <!-- END .divShowmovies -->
			<div class="movie_cast span3"></div>
			

		</div> <!-- END .single_movie -->
		<br />
	<div id="browse" style="margin-top:50px;">

			<div class="browse-widgets">
			<span class="stretch"></span>

			<br />
			</div>

		<ul class="movieResults">
		<!--  Total count of movies results -->

			<span class="movie-count"> 
				@if( isset($movies->movies) ) 
						{{count($movies->movies)}} movies 
				@endif 
			</span>				
			@if(isset($movies->total))
			
			@foreach ($movies->movies as $movie)
				
				  <div class="movieCard" data-critics="{{$movie->ratings->critics_score}}">	
				  <li class="seenit-btn"><a href="#"><i class="fui-heart-24"></i></a></li>
				  <li><a href="javascript:void(0);" data-id="{{$movie->id}}" class="movie-detail"><img src="{{$movie->posters->detailed}}" /></a></li>
				  <li class="movieCardInfo"><a href="javascript:void(0);" data-id="{{$movie->id}}"  class="movie-detail"> {{$movie->title}} </a><div class="details"></div></li>

				  </div>
			
				@endforeach
			@endif
		</ul>
		</div>	
@endsection



@section('footer_script')

{{HTML::script('js/jquery-1.8.2.min.js')}}		
<script>// Single Movie

	$(function() {
		
		// $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
		//           disableOn: 700,
		//           type: 'iframe',
		//           mainClass: 'mfp-fade',
		//           removalDelay: 160,
		//           preloader: false,
		//           fixedContentPos: false
		//         });

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

		   // appening synopsis
		   SingleMovieDom.append("<div class='synopsis'> Synopsis: "+data.synopsis+"</div>");

		   SingleMovieDom.append("<div class='directors'><div class='directors_name'>Directed By:</div>");

		   SingleMovieDom.append("<div class='genres'>Genres:</div>");		   

		   //appending into the parent div i.e div.single_movie_content
		   SingleMovieDom.append(
		   					"<div class='releasedate'>Release Year: "+ 
		   					data.year
		   					+"<br />Theater Release: "+
		   					data.release_dates.theater 
		   					+ "<br />DVD: "+
		   					dvd
		   					+"</div>"
		   			);

		   //mapping API and Db Movie Id if it exists
		   $.post(BASE+'/movies/getmovie',{'movie_id':data.id},function(data) {
		   	if (data.status == 'save') {
		   		 $('.addtoWatchListContainer').html('<p style="color:green;">Saved in Watchlist</p>');
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

});
</script> <!-- END Single movie -->
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
	});
</script> <!-- END Add Movies to Watchlist -->


@endsection