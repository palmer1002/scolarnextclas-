<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Eleve;
use App\Models\Note;

$eleves = Eleve::all();
foreach($eleves as $e) {
    echo "ID: {$e->id}, Name: {$e->nomComplet}\n";
}

$notes = Note::all();
foreach($notes as $n) {
    echo "NOTE ID: {$n->id}, Eleve: {$n->eleve_id}, Note: {$n->note}, Type: {$n->type_evaluation}\n";
}
