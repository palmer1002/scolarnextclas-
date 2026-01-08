<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$dir = __DIR__ . '/../resources/views';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$errors = [];
foreach ($rii as $file) {
    if ($file->isDir()) continue;
    if (substr($file->getFilename(), -6) !== '.blade.php') continue;
    $path = $file->getPathname();
    $relative = str_replace(realpath(__DIR__ . '/../resources/views') . DIRECTORY_SEPARATOR, '', $path);
    try {
        // Try to render with no data, suppress exceptions from missing variables
        echo "Rendering: $relative ... ";
        $rendered = $app->make('view')->file($path, [])->render();
        echo "OK\n";
    } catch (Throwable $e) {
        echo "ERROR: ".get_class($e)." - ".$e->getMessage()."\n";
        $errors[] = ['file'=>$relative,'exception'=>get_class($e),'message'=>$e->getMessage()];
    }
}

if (empty($errors)) {
    echo "All views rendered (best-effort) without throwing exception.\n";
    exit(0);
}

echo "Errors found:\n";
foreach ($errors as $err) {
    echo " - {$err['file']}: {$err['exception']}: {$err['message']}\n";
}
exit(1);
