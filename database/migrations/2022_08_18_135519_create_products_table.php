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
            $table->string('item_id');
            $table->string('title');
            $table->text('description');
            $table->string('condition')->default('new');
            $table->integer('available_quantity')->default(0);
            $table->text('pictures')->nullable();
            $table->string('category_id');
            $table->string('category');
            $table->double('price');
            $table->integer('sold_quantity')->default(0);
            $table->string('currency_id')->default('BRL');
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
