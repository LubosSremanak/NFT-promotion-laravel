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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('profile_url', 200);
            $table->string('banner_url', 200)->nullable();
            $table->string('address', 128);
            $table->string('nonce', 256);
            $table->string('name', 50)->nullable();
            $table->enum('role', ['creator', 'collector'])->nullable();
            $table->rememberToken();
            $table->unique(['address', 'nonce', 'deleted_at']);
            $table->enum('premium', ['l1', 'l2', 'l3'])->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
};
