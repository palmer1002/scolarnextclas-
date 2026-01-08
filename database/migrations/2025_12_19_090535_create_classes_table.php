<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD
class CreateClassesTable extends Migration
=======
return new class extends Migration
>>>>>>> f243e701f34d54ffbbf44046e3b5884852dcc6cb
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string('nom'); // ex: "6e A"
            $table->string('niveau'); // Collège ou Lycée
            $table->string('annee_scolaire', 9); // ex: "2025-2026"
=======
            $table->string('nom', 50);
            $table->string('niveau', 20);
            $table->string('section', 50)->nullable();
            $table->integer('capacite_max')->default(30);
            $table->integer('annee_scolaire');
            $table->boolean('statut')->default(true);
            $table->text('description')->nullable();
>>>>>>> f243e701f34d54ffbbf44046e3b5884852dcc6cb
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
<<<<<<< HEAD
}
=======
};
>>>>>>> f243e701f34d54ffbbf44046e3b5884852dcc6cb
