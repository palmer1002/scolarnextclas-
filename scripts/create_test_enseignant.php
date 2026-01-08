<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$enseignant = \App\Models\Enseignant::create([
    'title' => 'M.',
    'first_name' => 'Test',
    'last_name' => 'Testeur',
    'subject' => 'Test',
    'email' => 'test.enseignant@example.com',
    'phone' => '+000000000',
    'status' => 'Permanent'
]);

echo json_encode($enseignant->toArray(), JSON_PRETTY_PRINT);
