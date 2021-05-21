<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_posts', function (Blueprint $table) {
			$table->unsignedBigInteger('post_id');
			$table->foreign('post_id')->references('id')->on('posts');
			$table->unsignedBigInteger('tag_id');
			$table->foreign('tag_id')->references('id')->on('tags');
			$table->primary(['post_id','tag_id']);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_posts');
    }
}
