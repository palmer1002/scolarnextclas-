<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
if ($app->bound('dompdf.wrapper')) {
    echo "BOUND\n";
    $instance = $app->make('dompdf.wrapper');
    echo get_class($instance)."\n";
} else {
    echo "NOT BOUND\n";
}