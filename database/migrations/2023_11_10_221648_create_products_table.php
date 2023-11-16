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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('price', 9, 2);
            $table->decimal('selling_price', 9, 2);
            $table->string('image');
            $table->longText('description');
            $table->string('category');
            $table->string('brand')->nullable();
            $table->string('slug')->nullable();
            $table->decimal('rating', 9, 1);
            $table->integer('quantity');
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('products');
    }
};
