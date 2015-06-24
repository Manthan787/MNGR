<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearsTable extends Migration {

	public function up()
	{
		Schema::create('years', function(Blueprint $table)
		{
            $table->increments('id');
            $table->text('year');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('isCurrent');
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::table('years', function(Blueprint $table)
		{
			Schema::drop('years');
		});
	}

}
