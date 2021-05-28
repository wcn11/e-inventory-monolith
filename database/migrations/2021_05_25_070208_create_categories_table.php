<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default(100);
            $table->integer('position')->default(100);
            $table->string('description')->default(255);
            $table->tinyInteger('is_enable')->default(1);
            $table->string('slug')->default(255);
            $table->string('meta-title')->default(100);
            $table->string('meta-description')->default(150);
            $table->string('meta-keywords')->default(150);
            $table->longText('image');
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
        Schema::dropIfExists('categories');
    }
}
