<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$enseignants = \App\Models\Enseignant::orderBy('id', 'desc')->take(10)->get()->toArray();
echo json_encode($enseignants, JSON_PRETTY_PRINT);
