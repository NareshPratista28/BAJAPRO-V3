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
        Schema::table('questions', function (Blueprint $table) {
            // Tambah kolom baru yang diperlukan
            if (!Schema::hasColumn('questions', 'class_name')) {
                $table->string('class_name')->nullable();
            }
            if (!Schema::hasColumn('questions', 'test_description')) {
                $table->text('test_description')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['class_name', 'test_description']);
        });
    }
};
