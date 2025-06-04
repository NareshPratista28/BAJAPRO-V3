<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenerationHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generation_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('content_id');
            $table->string('topic_title');
            $table->longText('result');
            $table->float('generation_time');
            $table->timestamp('created_at');

            // Foreign key constraint untuk integritas referensial
            $table->foreign('content_id')
                ->references('id')
                ->on('contents')
                ->onDelete('cascade');

            // Indeks untuk meningkatkan performa query
            $table->index('content_id');
            $table->index('topic_title');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generation_history');
    }
}
