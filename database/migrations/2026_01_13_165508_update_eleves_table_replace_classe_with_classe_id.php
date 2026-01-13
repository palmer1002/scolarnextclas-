<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Convertir la table classes en InnoDB
        DB::statement('ALTER TABLE classes ENGINE = InnoDB');

        // 2. Ajouter la colonne classe_id si elle n'existe pas
        if (!Schema::hasColumn('eleves', 'classe_id')) {
            Schema::table('eleves', function (Blueprint $table) {
                $table->unsignedBigInteger('classe_id')->nullable()->after('date_inscription');
            });
        }

        // 3. Ajouter la contrainte de clé étrangère (si elle n'existe pas déjà - difficile à vérifier facilement, mais add constraint échouera si doublon avec même nom)
        // On suppose qu'elle n'a pas été créée car la migration précédente a échoué dessus.
        try {
            Schema::table('eleves', function (Blueprint $table) {
                $table->foreign('classe_id')->references('id')->on('classes')->onDelete('set null');
            });
        } catch (\Exception $e) {
            // Ignorer si la clé étrangère existe déjà (cas rare ici mais possible)
        }

        // Tenter de migrer les données existantes
        $eleves = DB::table('eleves')->get();
        foreach ($eleves as $eleve) {
            if (!empty($eleve->classe)) {
                 // Recherche stricte ou approximative
                $classe = DB::table('classes')->where('nom', 'LIKE', $eleve->classe . '%')->first();
                if ($classe) {
                    DB::table('eleves')->where('id', $eleve->id)->update(['classe_id' => $classe->id]);
                }
            }
        }

        Schema::table('eleves', function (Blueprint $table) {
            $table->dropColumn('classe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eleves', function (Blueprint $table) {
            $table->string('classe', 100)->nullable();
        });

        // Restaurer les données (approximatif car on perd le nom exact si supprimé)
        $eleves = DB::table('eleves')->get();
        foreach ($eleves as $eleve) {
            if ($eleve->classe_id) {
                $classe = DB::table('classes')->find($eleve->classe_id);
                if ($classe) {
                    DB::table('eleves')->where('id', $eleve->id)->update(['classe' => $classe->nom]);
                }
            }
        }

        Schema::table('eleves', function (Blueprint $table) {
            $table->dropForeign(['classe_id']);
            $table->dropColumn('classe_id');
        });
    }
};
