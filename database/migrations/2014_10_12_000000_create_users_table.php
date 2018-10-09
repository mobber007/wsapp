<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('handle')->unique();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('avatar')->default('https://api.adorable.io/avatars/285/abott@adorable.png');
            $table->dateTime('last_activity')->nullable();
            $table->boolean('accepted_gdpr')->nullable();
            $table->boolean('isAnonymized')->default(0);
            $table->rememberToken();
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
}
