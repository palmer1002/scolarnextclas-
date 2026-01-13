<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ajouter la colonne matiere_id
        Schema::table('notes', function (Blueprint $table) {
            $table->unsignedBigInteger('matiere_id')->nullable()->after('eleve_id');
            $table->foreign('matiere_id')->references('id')->on('matieres')->onDelete('cascade');
        });

        // Si la table matieres existe et contient des données, on essaie de migrer les données
        if (Schema::hasTable('matieres')) {
            $notes = DB::table('notes')->get();
            foreach ($notes as $note) {
                $matiere = DB::table('matieres')->where('nom', $note->matiere)->first();
                if ($matiere) {
                    DB::table('notes')
                        ->where('id', $note->id)
                        ->update(['matiere_id' => $matiere->id]);
                }
            }
        }

        // Supprimer l'ancienne colonne matiere
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn('matiere');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->string('matiere')->after('eleve_id');

            // Restaurer les données de matiere depuis matiere_id
            $notes = DB::table('notes')->get();
            foreach ($notes as $note) {
                if ($note->matiere_id) {
                    $matiere = DB::table('matieres')->where('id', $note->matiere_id)->first();
                    if ($matiere) {
                        DB::table('notes')
                            ->where('id', $note->id)
                            ->update(['matiere' => $matiere->nom]);
                    }
                }
            }

            // Supprimer la colonne matiere_id
            $table->dropForeign(['matiere_id']);
            $table->dropColumn('matiere_id');
        });
    }
};