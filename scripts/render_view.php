<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Boot the app
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $eleve = App\Models\Eleve::first();
    echo "Rendering Eleves.show...\n";
    $rendered = $app->make('view')->make('Eleves.show', ['eleve' => $eleve])->render();
    echo "Rendered successfully (first 500 chars):\n" . substr($rendered, 0, 500) . "\n";
} catch (Throwable $e) {
    echo get_class($e) . "\n";
    echo $e->getMessage() . "\n";
    echo "--- Trace ---\n";
    echo $e->getTraceAsString() . "\n";
}
