<?php

class User extends Basemodel {

	public static $rules = array(

		'username'=>'required|unique:users|alpha_dash|min:4',
		'email'=>'required|unique:users',
		'password'=>'required|alpha_num|between:4,8|confirmed',
		'password_confirmation'=>'required|alpha_num|between:4,8'
	);



	public function movies()
	{
		return $this->has_many('Movie');
	}
}