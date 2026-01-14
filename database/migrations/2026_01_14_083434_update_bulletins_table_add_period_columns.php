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
        Schema::table('bulletins', function (Blueprint $table) {
            $table->enum('type_periode', ['Trimestre', 'Semestre'])->after('eleve_id');
            $table->tinyInteger('numero_periode')->after('type_periode');
            
            // On supprime les anciennes colonnes si elles existent
            $table->dropColumn(['trimestre', 'semestre']);
        });
    }

    public function down(): void
    {
        Schema::table('bulletins', function (Blueprint $table) {
            $table->dropColumn(['type_periode', 'numero_periode']);
            $table->unsignedTinyInteger('trimestre')->nullable();
            $table->unsignedTinyInteger('semestre')->nullable();
        });
    }
};
