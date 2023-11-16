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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('code');
            $table->string('type')->default('numeric')->comment('Type of discount, e.g., percentage or numeric');
            $table->decimal('discount', 9, 2);
            $table->date('date_start');
            $table->date('date_end');
            $table->tinyInteger('sigle_use')->default('0')->comment('How many time a user can use it, e.g., 0 = many times or 1 = single time');;
            $table->tinyInteger('status')->default('0');
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
        Schema::dropIfExists('coupon');
    }
};
