<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyntaxConversionHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('syntax_conversion_history')) {
            Schema::create('syntax_conversion_history', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('title')->default('Untitled Conversion');
                $table->text('java_code');
                $table->text('python_code');
                $table->text('explanation')->nullable(); // <-- langsung ditambahkan di sini
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syntax_conversion_history');
    }
}
