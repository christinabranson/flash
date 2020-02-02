<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSessionToQuestionsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions_log', function (Blueprint $table) {
            /*
            $table->integer('session_id')->unsigned()->nullable();
            $table->foreign('session_id')
                ->references('id')
                ->on('quiz_sessions')
                ->onDelete('cascade');
            */
            $table->text("provided_answer")->nullable();
            $table->text("correct_answer")->nullable();
            $table->integer("correct_answer_id")->unsigned()->nullable();
            $table->foreign('correct_answer_id')
                ->references('id')
                ->on('question_answers')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions_log', function (Blueprint $table) {
            //
        });
    }
}
