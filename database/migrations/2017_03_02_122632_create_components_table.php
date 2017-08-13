<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('board_id')->unsigned()->nullable();
            $table->string('name');
            $table->integer('type');
            $table->string('status')->default('Stable');
            $table->integer('color_code')->default(1);
            $table->string('nodes');
            $table->string('heat_loss')->default('30');
            $table->string('effect_on_power')->default('.5');
            $table->integer('close')->default(0);
            $table->integer('close_time')->default(0);
            $table->timestamps();
        });
        Schema::table('components', function(Blueprint $table){
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->unique(['board_id', 'name']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('components');
    }
}
