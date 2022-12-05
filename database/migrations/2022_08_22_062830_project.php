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
      Schema::create('projects', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('name');
        $table->string('client_id');
        $table->string('client_secret');
        $table->bigInteger('user_id');
        $table->bigInteger('balance')->nullable();
        $table->string('profile_url')->nullable();
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->string('status')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('projects');
    }
};
