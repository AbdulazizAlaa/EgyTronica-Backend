<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('color_code')->default(1);
            $table->string('status')->default('Stable');
            $table->string('advice')->default('All Fine.');
            $table->string('output_efficiency')->default('100');
            $table->string('temp')->default('40');
            $table->string('humidity')->default('17');
            $table->string('run_time')->default('0,0');
            $table->string('refresh_time')->default('5');
            $table->string('last_maintainance')->default('1/1/2000');
            $table->timestamps();
        });
        Schema::table('boards', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
