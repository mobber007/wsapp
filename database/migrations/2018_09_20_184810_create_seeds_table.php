<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seeds', function (Blueprint $table) {
          $table->increments('id');
          $table->string('product_id')->unique();
          $table->string('campaign_name')->nullable();
          $table->string('price')->default(0);
          $table->string('old_price')->nullable()->default(0);
          $table->text('title')->nullable();
          $table->text('description')->nullable();
          $table->string('brand')->nullable();
          $table->string('aff_code')->nullable();
          $table->string('url')->nullable();
          $table->text('image_urls')->nullable();
          $table->string('subcategory')->nullable();
          $table->string('category')->nullable();
          $table->boolean('product_active')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seeds');
    }
}
