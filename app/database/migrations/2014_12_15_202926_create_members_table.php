<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function(Blueprint $table)
			{
					$table->increments('id');
		            $table->string('name');
		            $table->integer('memberType');
		            $table->string('email');
		            $table->string('password');
		            $table->enum('status',array('1','0'));
		            $table->string('department');
		            $table->string('remember_token')->nullable();
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
		Schema::drop('members');
	}

}
