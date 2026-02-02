<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Bulletin;
use App\Models\Note;

echo "--- BULLETINS ---\n";
$bulletins = Bulletin::where('eleve_id', 3)->get();
foreach($bulletins as $b) {
    echo "ID: {$b->id}, Eleve: {$b->eleve_id}, Moyenne: {$b->moyenne}, Periode: {$b->type_periode} {$b->numero_periode}\n";
}

echo "--- NOTES ---\n";
$notes = Note::where('eleve_id', 3)->get();
foreach($notes as $n) {
    echo "ID: {$n->id}, Eleve: {$n->eleve_id}, Note: {$n->note}\n";
}
