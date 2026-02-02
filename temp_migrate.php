<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

Schema::table('notes', function (Blueprint $table) {
    if (!Schema::hasColumn('notes', 'type_evaluation')) {
        $table->enum('type_evaluation', ['Interrogation', 'Devoir', 'Composition'])->default('Interrogation')->after('note');
    }
    if (!Schema::hasColumn('notes', 'num_evaluation')) {
        $table->integer('num_evaluation')->default(1)->after('type_evaluation');
    }
});

echo "Success";
