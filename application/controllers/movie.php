<?php

class Browse_Controller extends Base_Controller {

	public $restful = true;

/* Display Movie View */
	public function get_movie() {
		return View::make('browse.movie')
			->with('title', 'Rhubarb - Movie');
	} 




}
