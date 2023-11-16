<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->unique('user_id', 'user_profiles_user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('address');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('postcode');
            $table->string('country');
            $table->string('mobile')->unique();
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
        Schema::dropIfExists('user_profiles');
    }
};
