<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onDelete('cascade');

            $table->integer('section_id')->nullable()->unsigned();
            $table->foreign('section_id')
                ->references('id')
                ->on('course_sections')
                ->onDelete('cascade');

            $table->text("sessionGUID")->nullable();
            $table->integer("status")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_sessions');
    }
}
