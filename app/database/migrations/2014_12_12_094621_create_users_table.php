<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('firstname')->nullable();
			$table->string('lastname')->nullable();
			$table->string('email')->nullable();
			$table->string('password');
			$table->boolean('temp_password');
            $table->integer('role_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->text('remember_token');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');

	}

}
