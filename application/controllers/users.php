<?php

class Users_Controller extends Base_Controller {

	public $restful = true;

	public function get_new() {
		return View::make('users.new')
			->with('title', 'Rhubarb - Sign Up');
	}

	/* Create User  */
	public function post_create() {
		$validation = User::validate(Input::all());

		if ($validation->passes()) {
			User::create(array(
				'username'=>Input::get('username'),
				'password'=>Hash::make(Input::get('password'))
			));

			/* Login the user that just signed up */
			$user = User::where_username(Input::get('username'))->first();
			Auth::login($user);

			/* Redirect the User to the Activity Stream */
			return Redirect::to_route('activity')
				->with('message', "Welcome to Rhubarb! You're logged in!");
		}else {
			/* If user is not logged in, redirect to Sign Up */
			return Redirect::to_route('signup')
				->with_errors($validation)->with_input();
		}
	}

	/* Display Login Form */
	public function get_login() {
		return View::make('users.login')
			->with('title', 'Rhubarb - Login');
	}

	/* Validates login credentials */
	public function post_login() {
		$user = array(
			'username'=>Input::get('username'),
			'password'=>Input::get('password')
		);

		if (Auth::attempt($user)) {
			return Redirect::to_route('activity')
				->with('message', "You're logged in!");
		} else {
			return Redirect::to_route('login')
				->with('message', 'Your username/password combination was incorrect.')
				->with_input();
		}
	}

	/* Logout the User */
	public function get_logout() {
		if (Auth::check()) {
			Auth::logout();
			return Redirect::to_route('login')->with('message', "You're logged out. Come back soon!");
		} else {
			return Redirect::to_route('activity');
		}
	}
}