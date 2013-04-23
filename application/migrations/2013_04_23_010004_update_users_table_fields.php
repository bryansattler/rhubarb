<?php

class Update_Users_Table_Fields {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table){
			$table->increments('id');
		    $table->string('firstname', 200);
		    $table->string('lastname', 200);
		    $table->string('username', 200);
		    $table->text('password');
		    $table->string('email');
		    $table->string('role_id');
		    $table->integer('status');	
			$table->timestamps();
		});
	}


	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}