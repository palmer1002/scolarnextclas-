<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            if (!Schema::hasColumn('notes', 'type_evaluation')) {
                $table->enum('type_evaluation', ['Interrogation', 'Devoir', 'Composition'])->default('Interrogation');
            }
            if (!Schema::hasColumn('notes', 'num_evaluation')) {
                $table->integer('num_evaluation')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn(['type_evaluation', 'num_evaluation']);
        });
    }
};
