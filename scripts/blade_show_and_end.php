<?php
$dir = __DIR__ . '/../resources/views';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$found = [];
foreach ($rii as $file) {
    if ($file->isDir()) continue;
    if (substr($file->getFilename(), -6) !== '.blade.php') continue;
    $path = $file->getPathname();
    $content = file_get_contents($path);
    if (stripos($content, '@show') !== false && stripos($content, '@endsection') !== false) {
        $found[] = $path;
    }
}
if (empty($found)) {
    echo "No files contain both @show and @endsection.\n";
    exit(0);
}
foreach ($found as $f) {
    echo "Both @show and @endsection found in: $f\n";
}
exit(1);
