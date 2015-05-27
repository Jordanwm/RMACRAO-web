<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpeakersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('speakers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('session')->nullable();
			$table->string('day');
			$table->string('time');
			$table->string('location');
			$table->string('title')->nullable();
			$table->integer('year_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('speakers');
	}

}
