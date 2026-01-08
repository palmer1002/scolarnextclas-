<?php

$dir = __DIR__.'/../resources/views';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$found = [];
foreach ($rii as $file) {
    if ($file->isDir()) {
        continue;
    }
    if (substr($file->getFilename(), -6) !== '.blade.php') {
        continue;
    }
    $path = $file->getPathname();
    $content = file_get_contents($path);
    $sectionCount = preg_match_all('/@section\b/i', $content, $m1);
    $endCount = preg_match_all('/@endsection\b/i', $content, $m2);
    $showCount = preg_match_all('/@show\b/i', $content, $m3);
    $effectiveEnd = $endCount + $showCount;
    if ($sectionCount == 0 && $effectiveEnd > 0) {
        $found[] = ['file' => $path, 'end' => $effectiveEnd];
    }
}
if (empty($found)) {
    echo "No files found that contain @endsection/@show without any @section.\n";
    exit(0);
}
echo "Files with @endsection/@show and no @section:\n";
foreach ($found as $f) {
    echo " - {$f['file']} (end variants: {$f['end']})\n";
}
exit(1);