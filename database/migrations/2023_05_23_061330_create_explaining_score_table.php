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
        Schema::create('explaining_score', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references("id")->on("users");
            $table->integer('content_id')->unsigned();
            $table->foreign('content_id')->references('id')->on('contents');
            $table->integer('konteks_penjelasan');
            $table->integer('keruntutan');
            $table->integer('kebenaran');
            $table->boolean('is_accepted')->default(false);
            $table->unsignedBigInteger("essay_question_id");
            $table->foreign('essay_question_id')->references("id")->on("essay_question");
            $table->unsignedBigInteger("user_answer_id");
            $table->foreign('user_answer_id')->references("id")->on("user_answer");
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
        Schema::dropIfExists('explaining_score');
    }
};
