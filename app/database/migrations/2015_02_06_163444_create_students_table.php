<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('address');
			$table->date('birthdate');
			$table->string('phone');
			$table->string('parents_mobile');
			$table->string('student_mobile');
			$table->string('email');
			$table->integer('standard_id')->unsigned();
			$table->integer('medium_id')->unsigned();
			$table->integer('stream_id')->unsigned();
			$table->string('school');
      $table->decimal('fees',15,2);
			$table->string('city');
			$table->tinyInteger('active')->default(1);
      $table->text('remember_token');
      $table->integer('year_id')->unsigned();
      $table->date('entry_date');
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
		Schema::drop('students');
	}

}
