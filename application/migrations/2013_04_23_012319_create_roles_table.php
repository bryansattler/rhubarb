<?php

class Create_Roles_Table {    

	public function up()
    {
		Schema::create('roles', function($table) {
			$table->increments('id');
			$table->string('role');
			$table->string('description');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('roles');

    }

}