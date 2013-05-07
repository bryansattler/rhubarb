<?php

class Movie extends Basemodel 
{

	public function users()
	{
		return $this->belongs_to('User');
	}
}