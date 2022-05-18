<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('description', 1000);
            $table->integer('luck');
            $table->string('banner_image_url', 200);
            $table->string('profile_image_url', 200);
            $table->string('collection_url', 100);
            $table->string('website_url', 100);
            $table->boolean('verified');
            $table->string('category', 200);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('type', ['solana', 'opensea', 'coinciart']);
            $table->enum('boost', ['l1', 'l2', 'l3'])->nullable();
            $table->float('floor_price');
            $table->float('owners');
            $table->float('average_price');
            $table->float('count');
            $table->float('seven_day_sales');
            $table->float('one_day_sales');
            $table->unique(['title', 'collection_url', 'website_url', 'deleted_at']);
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
        Schema::dropIfExists('projects');
    }
};
