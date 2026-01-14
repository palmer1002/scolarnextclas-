<?php

use App\Models\Enseignant;
use App\Models\Classe;
use Illuminate\Support\Facades\DB;

echo "Checking database state...\n";

$tableExists = Schema::hasTable('classe_enseignant');
echo "Table 'classe_enseignant' exists: " . ($tableExists ? 'YES' : 'NO') . "\n";

if ($tableExists) {
    $count = DB::table('classe_enseignant')->count();
    echo "Total rows in 'classe_enseignant': " . $count . "\n";
    
    $rows = DB::table('classe_enseignant')->get();
    foreach ($rows as $row) {
        echo " - Enseignant ID: " . $row->enseignant_id . " -> Classe ID: " . $row->classe_id . "\n";
    }
}

$enseignants = Enseignant::with('classes')->get();
foreach ($enseignants as $t) {
    echo "Teacher: " . $t->first_name . " " . $t->last_name . " (ID: " . $t->id . ")\n";
    echo "Assigned Classes Count: " . $t->classes->count() . "\n";
    foreach ($t->classes as $c) {
        echo "  - Class: " . $c->nom . "\n";
    }
}
