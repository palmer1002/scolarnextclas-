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
        Schema::table('parents', function (Blueprint $table) {
            if (!Schema::hasColumn('parents', 'relation')) {
                $table->string('relation', 50)->nullable()->after('profession');
            }
            if (!Schema::hasColumn('parents', 'statut')) {
                $table->enum('statut', ['active', 'inactive'])->default('active')->after('relation');
            }
            if (!Schema::hasColumn('parents', 'notes')) {
                $table->text('notes')->nullable()->after('statut');
            }
        });

        Schema::table('eleves', function (Blueprint $table) {
            // Check if column exists before adding it to avoid errors if run multiple times or dealing with existing messy schema
            if (!Schema::hasColumn('eleves', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->constrained('parents')->onDelete('set null')->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parents', function (Blueprint $table) {
            $table->dropColumn(['relation', 'statut', 'notes']);
        });

        Schema::table('eleves', function (Blueprint $table) {
             if (Schema::hasColumn('eleves', 'parent_id')) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
             }
        });
    }
};
