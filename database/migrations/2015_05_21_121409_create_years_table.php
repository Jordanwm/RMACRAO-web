<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('years', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('active');
			$table->integer('year');
			$table->string('title');
			$table->string('dates');
			$table->string('location');
			$table->string('city');
			$table->string('state');
			$table->string('motto');
			$table->longtext('president_letter');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('years');
	}

}
