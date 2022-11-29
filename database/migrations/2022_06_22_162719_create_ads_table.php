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
        Schema::create('ads', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer("price");
            $table->integer("user_id");
            $table->string("status");
            $table->string("title");
            $table->string("url");
            $table->string("category_id");
            $table->string("projectavito_id");
            $table->string("category_name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
};
