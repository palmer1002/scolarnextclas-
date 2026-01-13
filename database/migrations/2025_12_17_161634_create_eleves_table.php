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
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('matricule', 100)->unique();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->date('date_naissance');
            $table->string('email', 150)->unique()->nullable();
            $table->text('adresse')->nullable();
            $table->string('classe', 100);
            $table->enum('genre', ['Masculin', 'Féminin']);
            $table->date('date_inscription');
            $table->date('date_modification')->nullable();
            $table->string('nom_parent', 150)->nullable();
            $table->string('contact_parent', 100)->nullable();
            $table->timestamps();

            // Clé étrangère
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            // Index
            $table->index(['nom', 'prenom']);
            $table->index('classe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};