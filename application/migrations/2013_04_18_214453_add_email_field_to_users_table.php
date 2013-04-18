<?php

class Add_Email_Field_To_Users_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users', function($table)
            {
                $table->string('email');
            });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users', function($table)
            {
                $table->drop_column('email');
            });
	}

}