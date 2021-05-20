<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyUserPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table)
		{
			// colonna per FK
			$table->unsignedBigInteger('user_id');

			// relazione user_id <-> id users table
			$table->foreign('user_id')
				->references('id')
				->on('users');
			// equivalentemente
			// $table->foreignId('user_id')->constrained();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('posts', function (Blueprint $table)
		{
			// elimino la relazione
			$table->dropForeign('posts_user_id_foreign');

			// elimino la colonna 
			$table->dropColumn('user_id');
		});
    }
}
