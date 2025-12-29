<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('matricule', 100)->unique();
            $table->string('nom', 100);
            $table->string('prenom', 100);

            $table->date('date_naissance')->nullable();
            $table->string('email', 150)->unique()->nullable();
            $table->text('adresse')->nullable();

            // Relation avec Classe
            $table->foreignId('classe_id')->constrained('classes')->cascadeOnDelete();

            $table->enum('genre', ['Masculin', 'Féminin']);
            $table->date('date_inscription');
            $table->date('date_modification')->nullable();

            $table->string('parent_nom', 150)->nullable();
            $table->string('parent_relation', 100)->nullable();
            $table->string('parent_telephone', 100)->nullable();

            $table->string('statut', 50)->default('actif');

            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();

            $table->index(['nom', 'prenom']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};