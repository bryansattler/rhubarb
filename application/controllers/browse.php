<?php

class Browse_Controller extends Base_Controller {

	public $restful = true;

	public function get_index() 
	{
		return View::make('browse.index')
		->with('title', 'Rhubarb - Browse Movies');
	} 

/* Display Movie View */
	// public function get_movie() {
	// 	return View::make('browse.movie')
	// 		->with('title', 'Rhubarb - Movie');
	// } 




}
