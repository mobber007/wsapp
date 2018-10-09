<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('external_id')->unique();
			$table->string('affiliate');
			$table->integer('price')->default(0);
			$table->integer('old_price')->nullable()->default(0);
			$table->string('title');
			$table->string('slug')->unique();
			$table->text('description')->nullable();
			$table->string('event_url')->unique();
			$table->string('url')->unique();
			$table->string('thumbnail')->unique();
			$table->string('subcategory')->nullable();

			$table->integer('category_id')->unsigned()->nullable();
			$table->foreign('category_id')
			->references('id')
			->on('categories')
			->onUpdate('cascade');

			$table->integer('brand_id')->unsigned()->nullable();
			$table->foreign('brand_id')
			->references('id')
			->on('brands')
			->onUpdate('cascade');

			$table->string('keywords')->nullable();
			$table->enum('type', ['normal', 'featured', 'popular']);
			$table->boolean('status')->default(0);

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
		Schema::drop('products');
	}

}
