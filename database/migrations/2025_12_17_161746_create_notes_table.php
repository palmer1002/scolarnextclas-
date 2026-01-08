<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD
class CreateNotesTable extends Migration
=======
return new class extends Migration
>>>>>>> f243e701f34d54ffbbf44046e3b5884852dcc6cb
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

<<<<<<< HEAD
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
=======
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
>>>>>>> f243e701f34d54ffbbf44046e3b5884852dcc6cb
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
<<<<<<< HEAD
}
=======
};
>>>>>>> f243e701f34d54ffbbf44046e3b5884852dcc6cb
