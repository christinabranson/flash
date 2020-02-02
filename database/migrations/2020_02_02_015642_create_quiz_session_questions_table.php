<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizSessionQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_session_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('session_id')->unsigned();
            $table->foreign('session_id')
                ->references('id')
                ->on('quiz_sessions')
                ->onDelete('cascade');


            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_session_questions');
    }
}
