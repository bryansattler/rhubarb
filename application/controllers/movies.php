<?php

class Movies_Controller extends Base_Controller {


	public function action_index() 
	{
		return View::make('browse.movie')
		->with('title', 'Rhubarb');
	}

	public function action_getmovie()
	{

	   	if (! Input::get('movie_id') ) {
	   		return Response::json(array('status' => 'failed','message'=>'Failed on response'));
	   	}

	   $movie = Movie::where_movie_id_and_tosee(Input::get('movie_id'),'YES')->first();
	   $watched = Movie::where_movie_id_and_watched(Input::get('movie_id'), 'YES')->first();
	   // dd(Input::get('movie_id'));
	   if (isset($movie->id)) {
	   	   return Response::json(array('status' => 'save', 'message' => 'Added to watchlist'));	
	   }elseif(isset($watched->id)){
	   	 return Response::json(array('status' => 'save', 'message' => 'You have watched this movie'));	
	   }
	   return Response::json(array('status' => 'failed','message'=>'Failed on response'));
	}


	public function action_save()
	{
		
			$endpoint = Input::get('movie_link') ;
			// setup curl to make a call to the endpoint
			$session = curl_init($endpoint);

			// indicates that we want the response back
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

			// exec curl and get the data back
			$data = curl_exec($session);

			// remember to close the curl session once we are finished retrieveing the data
			curl_close($session);

			// decode the json data to make it easier to parse the php
			$movie = json_decode($data);
			if ($movie === NULL) return Response::json(array('status' => 'failed','message'=>'Failed on API response'));

			// show the results from the API
			// $movies = $search_results->movies;
			$movieDetails['title'] = $movie->title;
			$movieDetails['year'] = $movie->year;
			$movieDetails['release_theater'] = isset($movie->release_dates->theater) ? $movie->release_dates->theater : "Not Given";
			$movieDetails['release_dvd'] = isset($movie->release_dates->release_dvd) ? $movie->release_dates->release_dvd : "Not Given";
			$movieDetails['synopsis'] = $movie->synopsis;
			$movieDetails['movie_id'] = $movie->id;
			$movieDetails['watched'] = 'NO';
			$movieDetails['tosee'] = 'YES';

			$user = User::find(Auth::user()->id);
			$movie = $user->movies()->insert($movieDetails);
			if ($movie) {
				return Response::json(array('status' => 'save', 'message' => 'green'));	
			}
			return Response::json(array('status' => 'failed','message'=>'Failed on save'));
	}

	public function action_addremovemovie()
	{
		if (Request::ajax()) {
			 $movie_id = Input::get('movie_id');
			 $fieldName = Input::get('fieldname');
			 if ($fieldName == 'delete') {
			 	 $movie = Movie::where_movie_id($movie_id)->first();
			 	 if ($movie->delete()) {
			 	 	return Response::json(array('status' => 'success', 'message' => 'Movie Deleted'));
			 	 }
			 }elseif($fieldName =='tosee'){
			 	 $user = User::find(Auth::user()->id);
			 	 $addMovie['movie_id'] = $movie_id;
			 	 $addMovie['tosee'] = 'YES';
			 	 $addMovie['watched'] = 'NO';
			 	 $movie = $user->movies()->insert($addMovie);
			 	 if ($movie) {
			 	 	return Response::json(array('status' => 'save', 'message' => 'Movie Saved'));	
			 	 }
			 	 return Response::json(array('status' => 'failed','message' =>'Failed to save'));
			 }
		}
		return Response::json(array('status' => 'failed','message' =>'Unknown Request'));
	}
}
