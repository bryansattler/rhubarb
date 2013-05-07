<?php

class Watchlist_Controller extends Base_Controller {

	public function action_index() 
	{	
		$user = User::find(Auth::user()->id);
		$watchlistMovies = $user->movies()->get();
		$data['watchlistMoviesLeft'] = Movie::where_user_id_and_tosee(Auth::user()->id,'YES')->count();
		$data['watchedMovies'] = Movie::where_user_id_and_watched(Auth::user()->id,'YES')->count();
		$data['title'] = 'Rhubarb - My Watchlist';
		
		$data['movies'] = array();

		foreach ($watchlistMovies as $watchlist) {
			$data['movies'][] = $this->__curl($watchlist->movie_id);
		}
		// dd($data['movies']);

		return View::make('watchlist.index',$data);
	}

	/**
	 * [Ajax Call: Change the status of the movie ]
	 * @return [type] [description]
	 */
	public function action_changestatus()
	{
		//response only if the request is ajax otherwise die
		if (Request::ajax()) {
			 $name = Input::get('name');
			 $id = Input::get('movie_id');
			 if ($name == 'watched') {
			 	 $movie = Movie::where_movie_id($id)->first();
			 	 $movie->watched = "YES";
			 	 $movie->tosee = "NO";
			 	 if ($movie->save()) {
			 	 	$watchlistMoviesLeft = Movie::where_user_id_and_tosee(Auth::user()->id,'YES')->count();
			 	 	$watchedMovies = Movie::where_user_id_and_watched(Auth::user()->id,'YES')->count();
			 	 	 return  Response::json(array('status' => 'changed','message' => 'You have watched the movie' ,'watchedMovies' =>$watchedMovies , 'moviewatchlistcount' =>$watchlistMoviesLeft));
			 	 }
			 }elseif($name== 'delete'){
			 	$movie = Movie::where_movie_id($id)->first();
			 	if ($movie->delete()) {
			 		return Response::json(array('status' => 'deleted', 'message' => "You have deleted the movie"));
			 	}
			 }
		}
		die('Unknown Request');
	}	
	

	function __curl($movieid)
	{
		$apikey = 'caw7u9euxvcwuabe5zjwe9tg';
		
		// Queries Upcoming Movies 
		$curlable = "http://api.rottentomatoes.com/api/public/v1.0/movies/".$movieid.".json?apikey=".$apikey;

		// setup curl to make a call to the endpoint
		$session = curl_init($curlable);

		// indicates that we want the response back
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		// execute curl and get the data back
		$data = curl_exec($session);

		// remember to close the curl session once we are finished retrieving the data
		curl_close($session);

		// decode the json data to make it easier to parse the php
		$movie = json_decode($data);
		if ($movie === NULL) die('Error parsing json');

		// show the results from the API
		return $movie;
	}

}
