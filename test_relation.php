<?php
try {
    $e = \App\Models\Enseignant::first();
    $c = \App\Models\Classe::first();
    
    if (!$e) {
        echo "No teachers found.\n";
        exit;
    }
    if (!$c) {
        echo "No classes found.\n";
        exit;
    }

    echo "Teacher: " . $e->first_name . " (ID: " . $e->id . ")\n";
    echo "Class: " . $c->nom . " (ID: " . $c->id . ")\n";

    // Check current
    echo "Current classes: " . $e->classes()->count() . "\n";

    // Attach
    echo "Attaching...\n";
    $e->classes()->syncWithoutDetaching([$c->id]);
    
    // Check again
    $e->refresh();
    echo "New count: " . $e->classes()->count() . "\n";
    
    // List them
    foreach($e->classes as $cl) {
        echo " - " . $cl->nom . "\n";
    }

} catch (\Exception $ex) {
    echo "Error: " . $ex->getMessage() . "\n";
}
