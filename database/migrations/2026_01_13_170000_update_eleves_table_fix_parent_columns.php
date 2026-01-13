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
        Schema::table('eleves', function (Blueprint $table) {
            // Rename existing columns to match Controller/View expectations
            // Note: DB::statement might be needed if renameColumn is not supported by the driver/version directly without doctrine/dbal, 
            // but modern Laravel usually handles it. If not, we'll recreate.
            // Let's assume standard Laravel behavior.
            
            // Check if old columns exist before renaming
            if (Schema::hasColumn('eleves', 'nom_parent')) {
                $table->renameColumn('nom_parent', 'parent_nom');
            } else if (!Schema::hasColumn('eleves', 'parent_nom')) {
                $table->string('parent_nom')->nullable();
            }

            if (Schema::hasColumn('eleves', 'contact_parent')) {
                $table->renameColumn('contact_parent', 'parent_telephone');
            } else if (!Schema::hasColumn('eleves', 'parent_telephone')) {
                $table->string('parent_telephone')->nullable();
            }

            // Add missing columns
            if (!Schema::hasColumn('eleves', 'parent_relation')) {
                $table->string('parent_relation')->nullable()->after('parent_nom');
            }
            
            if (!Schema::hasColumn('eleves', 'parent_email')) {
                $table->string('parent_email')->nullable()->after('parent_telephone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eleves', function (Blueprint $table) {
            if (Schema::hasColumn('eleves', 'parent_nom')) {
                $table->renameColumn('parent_nom', 'nom_parent');
            }
            if (Schema::hasColumn('eleves', 'parent_telephone')) {
                $table->renameColumn('parent_telephone', 'contact_parent');
            }
            $table->dropColumn(['parent_relation', 'parent_email']);
        });
    }
};
