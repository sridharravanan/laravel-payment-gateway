<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('tutor id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            /*$table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');*/
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('sub_category')->onDelete('cascade');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('front_image_id')->nullable();
            $table->foreign('front_image_id')->references('id')->on('uploads')->onDelete('restrict');
            $table->double('amount', null, 2);
            $table->unsignedBigInteger('post_pdf_id');
            $table->foreign('post_pdf_id')->references('id')->on('uploads')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}
