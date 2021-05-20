<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyCategoryPostsTable extends Migration
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
			$table->unsignedBigInteger('category_id')->nullable();

			// relazione category_id <-> id categories table
			$table->foreign('category_id')
				->references('id')
				->on('categories');
			// equivalentemente
			// $table->foreignId('category_id')->constrained();
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
			$table->dropForeign('posts_category_id_foreign');

			// elimino la colonna 
			$table->dropColumn('category_id');
		});
    }
}
