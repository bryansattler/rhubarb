<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

Route::get('/', array('as'=>'/', 'uses'=>'browse@index'));
Route::get('profile', array('as' => 'profile','uses' => 'users@profile' )); 
Route::get('signup', array('as'=>'signup', 'uses'=>'users@new'));
Route::get('login', array('as'=>'login', 'uses'=>'users@login'));
Route::get('logout', array('as'=>'logout', 'uses'=>'users@logout'));


Route::controller('movies');
Route::controller('watchlist');

Route::post('signup', array('before'=>'csrf', 'uses'=>'users@create'));
Route::post('login', array('before'=>'csrf', 'uses'=>'users@login'));

//profile updates 
Route::post('profile',function()
{
	$img = Input::file('profile_picture');
	$user = User::find(Auth::user()->id);
	$user->firstname = Input::get('firstname');
	$user->lastname = Input::get('lastname');
	$user->email = Input::get('email');

	if ($img) {
		$thumb = path('public').'pics/'.Auth::user()->id.'_thumb.jpg';
		$smallthumb = path('public').'pics/'.Auth::user()->id.'_smallthumb.jpg';

	    // Save a normal thumbnail & small thumbnail
	    $success_thumb = Resizer::open( $img )->resize( 150 , 150 , 'crop' )->save( $thumb , 90 );
	    $success_smallthumb = Resizer::open( $img )->resize( 24 , 24 , 'crop' )->save( $smallthumb , 90 );

	    if ( $success_thumb && $success_smallthumb ) {
	        $user->image_thumb = URL::base().'/pics/'.Auth::user()->id.'_thumb.jpg';
	        $user->image_small_thumb =  URL::base().'/pics/'.Auth::user()->id.'_smallthumb.jpg';
		}
	}

	if ($user->save()) {
		return Redirect::to('profile')->with('message', 'You have updated your profile successfully');
	}
	return Redirect::to('profile')->with('message','Error in updating your profile. Try again.');
});

// route that handles changing password
Route::post('changepassword',function()
{

	if (Auth::check()) {
			$user = User::find(Auth::user()->id);
			$password = Input::get('new_password');
			$repassword = Input::get('password_confirmation');
			
			if ($repassword == $password) {
				$user->password = Hash::make($password);
				$user->save();
				return Redirect::to('profile')
						->with('message', "Password changed successfully!");
			}
			return Redirect::to('profile')
						->with('message', "Password does not match");
	}
		return Redirect::to('login')
						->with('message', "Unauthorized Access.");
});


Route::get('search',function()
{
	$apikey = 'caw7u9euxvcwuabe5zjwe9tg';
	return View::make('search.search',array('title' => 'Search'))->with(array('apikey' => '$apikey'));
});

Route::post('search',function()
{
		$searchkeyword = Input::get('search');
		$apikey = 'caw7u9euxvcwuabe5zjwe9tg';
		$num_page = rand(10,50);
		$endpoint = "http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=".$apikey."&q=".$searchkeyword."&page_limit=".$num_page;
		// setup curl to make a call to the endpoint
		$session = curl_init($endpoint);

		// indicates that we want the response back
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		// exec curl and get the data back
		$data = curl_exec($session);

		// remember to close the curl session once we are finished retrieving the data
		curl_close($session);

		// decode the json data to make it easier to parse the php
		$movies = json_decode($data);
		
		return View::make('search.search', array('title' => "Search " , 'movies' => $movies) )->with(array('apikey' => $apikey));

});


// Route::controller(Controller::detect());
/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application. The exception object
| that is captured during execution is then passed to the 500 listener.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function($exception)
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});