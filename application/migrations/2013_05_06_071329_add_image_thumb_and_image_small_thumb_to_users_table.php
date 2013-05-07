<?php

class Add_Image_Thumb_And_Image_Small_Thumb_To_Users_Table {    

	public function up()
    {
		Schema::table('users', function($table) {
			$table->string('image_thumb');
			$table->string('image_small_thumb');
	});

    }    

	public function down()
    {
		Schema::table('users', function($table) {
			$table->drop_column(array('image_thumb', 'image_small_thumb'));
	});

    }

}