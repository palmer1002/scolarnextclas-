<?php
$dir = __DIR__ . '/../storage/framework/views';
$files = glob($dir . '/*');
foreach ($files as $f) {
    if (is_file($f)) unlink($f);
}
echo "Cleared compiled views in $dir\n";
