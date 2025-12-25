<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();

            /* Relations */
            $table->foreignId('eleve_id')
                  ->constrained('eleves')
                  ->onDelete('cascade');

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('encaisser_par')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            /*  Identification  */
            $table->string('numero_recu', 50)->unique()->nullable();
            $table->string('reference', 100)->nullable()->comment('Référence interne/externe');

            /*  Montants */
            $table->decimal('montant', 12, 2)->comment('Montant à payer');
            $table->decimal('montant_total', 12, 2)->default(0)->comment('Montant total (pour les paiements partiels)');
            $table->decimal('montant_restant', 12, 2)->default(0)->comment('Montant restant à payer');
            $table->decimal('montant_paye', 12, 2)->default(0)->comment('Montant déjà payé');

            /*  Dates */
            $table->date('date_paiement')->nullable()->comment('Date effective du paiement');
            $table->date('date_echeance')->nullable()->comment('Date limite de paiement');
            $table->date('prochain_paiement')->nullable()->comment('Pour paiements récurrents');

            /*  Période scolaire */
            $table->enum('type_periode', ['Trimestre', 'Semestre', 'Mois', 'Annuel'])->nullable();
            $table->tinyInteger('numero_periode')->unsigned()->nullable()
                  ->comment('1-3 pour Trimestre, 1-2 pour Semestre, 1-12 pour Mois');
            $table->string('periode_libelle', 50)->nullable()->comment('Ex: "Trimestre 1", "Septembre 2025"');
            $table->string('annee_scolaire', 20)->nullable()->comment('Format: 2025-2026');

            /* Type & mode de paiement */
           
            $table->enum('type_paiement', [
                'Scolarité', 
                'Cantine', 
                'Transport', 
                'Fournitures', 
                'Activités',
                'Assurance',
                'Autre'
            ])->default('Scolarité');
            
            $table->enum('mode_paiement', [
                'espèces',
                'chèque',
                'virement',
                'carte_bancaire',
                'mobile_money',
                'autre'
            ])->default('espèces');

            /*  Infos bancaire */
            $table->string('banque', 100)->nullable();
            $table->string('numero_cheque', 50)->nullable();
            $table->string('reference_virement', 100)->nullable();
            $table->string('operateur_mobile', 50)->nullable()->comment('Orange Money, MTN Mobile Money, etc.');

            /* Statut */
            $table->enum('statut', [
                'brouillon',
                'en_attente', 
                'partiel', 
                'payé', 
                'annulé',
                'remboursé'
            ])->default('brouillon');

            /* Récurrence */
            $table->boolean('is_recurrent')->default(false);
            $table->enum('frequence_recurrence', [
                'mensuel',
                'trimestriel',
                'semestriel',
                'annuel'
            ])->nullable();

            /*  Documents & notes */
            $table->string('preuve_paiement')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->string('motif_annulation', 255)->nullable();

            /*  Audit */
            $table->timestamp('date_validation')->nullable();
            $table->timestamp('date_annulation')->nullable();

            /* Timestamps */
            $table->timestamps();
            $table->softDeletes();

            /*  Index */
           
            $table->index(['eleve_id', 'statut']);
            $table->index(['type_periode', 'numero_periode']);
            $table->index(['annee_scolaire', 'type_paiement']);
            $table->index(['date_echeance', 'statut']);
            $table->index(['date_paiement']);
            $table->index(['numero_recu']);
            $table->index(['type_paiement']);
            $table->index(['mode_paiement']);
            $table->index(['is_recurrent']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};