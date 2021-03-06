<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();

            $table->integer('question_id');
            $table->foreign('question_id')->references('id')->on('questions');

            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('choice_id')->nullable();
            $table->foreign('choice_id')->references('id')->on('choices');

            $table->text('answer')->nullable();
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
        Schema::dropIfExists('answers');
    }
}
