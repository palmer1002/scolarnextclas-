<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            // Relation avec Eleve
            $table->foreignId('eleve_id')->constrained('eleves')->onDelete('cascade');

            $table->unsignedTinyInteger('trimestre'); // 1, 2 ou 3
            $table->unsignedTinyInteger('semestre');  // 1 ou 2
            $table->string('matiere', 100);
            $table->decimal('note', 5, 2); // note sur 20
            $table->unsignedInteger('coefficient')->default(1);
            $table->string('annee_scolaire', 20);

            $table->timestamps();

            $table->index(['eleve_id', 'matiere']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
}