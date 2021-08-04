<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id('id');
            $table->string('sku', 10);
            $table->string('name', 100);
            $table->bigInteger('price');
            $table->float('weight');
            $table->integer('position');
            $table->integer('category_id');
            $table->string('description', 255);
            $table->longText('image');
            $table->string('is_enable', 5);
            $table->string('slug', 255);
            $table->string('meta_title', 100);
            $table->string('meta_description', 255);
            $table->string('meta_keywords', 255);
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
        Schema::dropIfExists('product');
    }
}
