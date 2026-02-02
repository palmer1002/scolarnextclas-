<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Note;

$notes = Note::all();
foreach($notes as $n) {
    echo "ID: {$n->id}, Eleve: {$n->eleve_id}, Matiere: {$n->matiere_id}, Note: {$n->note}, Type: {$n->type_evaluation}\n";
}
