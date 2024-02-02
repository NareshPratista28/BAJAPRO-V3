<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('essay_question', function (Blueprint $table) {
            $table->id();
            $table->integer("question_id")->unsigned();
            $table->foreign('question_id')->references("id")->on("questions");
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references("id")->on("users");
            $table->text('question');
            $table->text('answer');
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
        Schema::dropIfExists('essay_question');
    }
};
