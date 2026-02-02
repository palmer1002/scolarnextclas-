<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            // Skipped to avoid errors
        });
    }

    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            // Restaurer les colonnes en cas de rollback
            $table->string('trimestre')->nullable();
            $table->string('semestre')->nullable();
        });
    }
};
