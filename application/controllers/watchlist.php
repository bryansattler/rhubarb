<?php

class Watchlist_Controller extends Base_Controller {

	public $restful = true;

	public function get_index() 
	{
		return View::make('watchlist.index')
		->with('title', 'Rhubarb - My Watchlist');
	}
	
}
