<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onDelete('cascade');


            $table->string('name', 255);
            $table->mediumText('description')->nullable();

            $table->integer('displayorder')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_sections');
    }
}
