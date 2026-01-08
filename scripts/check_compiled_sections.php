<?php

$dir = __DIR__.'/../storage/framework/views';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$errors = [];
foreach ($rii as $file) {
    if ($file->isDir()) {
        continue;
    }
    $path = $file->getPathname();
    $content = file_get_contents($path);
    $start = preg_match_all('/startSection\(/i', $content, $m1);
    $stop = preg_match_all('/stopSection\(/i', $content, $m2);
    if ($start !== $stop) {
        $errors[] = ['file' => $path, 'start' => $start, 'stop' => $stop];
    } else {
        // also check if first stop comes before first start
        $posStart = stripos($content, 'startSection(');
        $posStop = stripos($content, 'stopSection(');
        if ($posStop !== false && $posStart !== false && $posStop < $posStart) {
            $errors[] = ['file' => $path, 'start' => $start, 'stop' => $stop, 'note' => 'stop appears before start'];
        }
    }
}
if (empty($errors)) {
    echo "No mismatches found in compiled views.\n";
    exit(0);
}
foreach ($errors as $e) {
    echo "Mismatch in compiled view: {$e['file']}\n";
    echo "  startSection: {$e['start']}  stopSection: {$e['stop']}";
    if (isset($e['note'])) {
        echo "  NOTE: {$e['note']}";
    }
    echo "\n";
}
exit(1);
