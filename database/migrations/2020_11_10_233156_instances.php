<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Instances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quiz_id')->unsigned();
            $table->char('lang', 4);
            $table->integer('num_questions')->default(1);
            $table->integer('num_answers')->default(1);
            $table->integer('group')->nullable();
            $table->bigInteger('author_id')->unsigned()->nullable();
            $table->integer('position')->default(1); // Keep track of position in test
            $table->longText('data');
            $table->boolean('completed')->default(false);
            $table->integer('revision_number');
            $table->timestamps();

            $table->foreign('quiz_id')->references('id')->on('quizzes')->cascadeOnDelete();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->bigInteger('instance_id')->unsigned();
            $table->bigInteger('quiz_id')->unsigned();
            $table->bigInteger('author_id')->unsigned()->nullable();
            $table->bigInteger('item_id')->unsigned();
            $table->boolean('correct')->default(false);
            $table->timestamps();
            $table->foreign('instance_id')->references('id')->on('instances')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('answers');
        Schema::drop('instances');
    }
}
