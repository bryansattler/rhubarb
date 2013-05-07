<?php

class Browse_Controller extends Base_Controller {

	public $restful = true;

	public function get_index() 
	{
		return View::make('browse.index')
		->with('title', 'Rhubarb - Browse Movies');
	} 
}
