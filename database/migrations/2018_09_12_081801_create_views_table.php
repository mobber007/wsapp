<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewsTable extends Migration
{

  public function up()
  {
    Schema::create('views', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->ipAddress('visitor');
        $table->morphs('viewable');
        $table->timestamp('viewed_at')->useCurrent();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      Schema::dropIfExists('views');
  }
}
