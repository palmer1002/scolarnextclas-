<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('eleve_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Période scolaire
            $table->enum('type_periode', ['Trimestre', 'Semestre']);
            $table->tinyInteger('numero_periode')->comment('1, 2 ou 3 pour Trimestre / 1 ou 2 pour Semestre');

            $table->string('matiere');
            $table->decimal('note', 4, 2);
            $table->integer('coefficient')->default(1);
            $table->string('annee_scolaire');

            $table->timestamps();

            // Index optimisé
            $table->index(['eleve_id', 'type_periode', 'numero_periode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
