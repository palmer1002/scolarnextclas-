<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulletinsTable extends Migration
{
    public function up(): void
    {
        Schema::create('bulletins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained()->onDelete('cascade'); 
            $table->unsignedTinyInteger('trimestre')->nullable(); // 1, 2 ou 3
            $table->unsignedTinyInteger('semestre')->nullable();  // 1 ou 2
            $table->decimal('moyenne', 5, 2); // moyenne calculée
            $table->string('annee_scolaire', 9); // ex: "2025-2026"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bulletins');
    }
}