<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Load Laravel application
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking tables...\n";

if (Schema::hasTable('classes')) {
    echo "Table 'classes' EXISTS.\n";
    $count = DB::table('classes')->count();
    echo "Rows: $count\n";
    
    // Check Engine
    $status = DB::select("SHOW TABLE STATUS LIKE 'classes'");
    if (!empty($status)) {
        echo "Engine: " . $status[0]->Engine . "\n";
        echo "Collation: " . $status[0]->Collation . "\n";
    }
} else {
    echo "Table 'classes' DOES NOT EXIST.\n";
}

if (Schema::hasTable('eleves')) {
    echo "Table 'eleves' EXISTS.\n";
    $status = DB::select("SHOW TABLE STATUS LIKE 'eleves'");
    if (!empty($status)) {
        echo "Engine: " . $status[0]->Engine . "\n";
        echo "Collation: " . $status[0]->Collation . "\n";
    }
} else {
    echo "Table 'eleves' DOES NOT EXIST.\n";
}
