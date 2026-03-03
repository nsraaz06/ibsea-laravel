<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $blade) {
            $blade->id();
            $blade->unsignedBigInteger('author_id')->nullable();
            $blade->string('title');
            $blade->string('slug')->unique();
            $blade->string('category')->default('News');
            $blade->longText('content')->nullable();
            $blade->string('featured_image')->nullable();
            $blade->string('status')->default('Draft');
            $blade->boolean('show_on_slider')->default(false);
            $blade->timestamp('published_at')->nullable();
            $blade->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
