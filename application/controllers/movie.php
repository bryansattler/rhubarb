<?php

class Browse_Controller extends Base_Controller {

	public $restful = true;

	public function get_index() 
	{
		return View::make('browse.movie')
		->with('title', 'Rhubarb');
	}

}
