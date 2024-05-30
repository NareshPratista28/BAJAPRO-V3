<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalAnswersToEssayQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('essay_question', function (Blueprint $table) {
            $table->text('answer2')->nullable()->after('answer');
            $table->text('answer3')->nullable()->after('answer2');
            $table->text('answer4')->nullable()->after('answer3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('essay_question', function (Blueprint $table) {
            $table->dropColumn(['answer2', 'answer3', 'answer4']);
        });
    }
}

