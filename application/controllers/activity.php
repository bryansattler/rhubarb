<?php

class Activity_Controller extends Base_Controller {

	public $restful = true;

	public function get_index() 
	{
		return View::make('activity.index')
		->with('title', 'Rhubarb - Activity Stream');
	}

}
