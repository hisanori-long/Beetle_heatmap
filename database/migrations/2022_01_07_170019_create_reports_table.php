<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('species_id');
            $table->string("image_url");
            $table->geometry('location')->comment('緯度・経度');
            $table->boolean('sexual')->comment('False(オス) True(メス)');
            $table->timestamp('created_at');
            $table->integer("size")->nullable()->comment("cm");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
