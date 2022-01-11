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
            $table->double("lon", 8);
            $table->double("lat", 9);
            $table->boolean('sexual')->comment("True:オス, False:メス");
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
            $table->integer("size")->comment("cm");
            $table->char("comment", 100)->nullable();
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
