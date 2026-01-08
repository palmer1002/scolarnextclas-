<?php

$dir = __DIR__.'/../resources/views';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$errors = [];
foreach ($rii as $file) {
    if ($file->isDir()) {
        continue;
    }
    if (substr($file->getFilename(), -6) !== '.blade.php') {
        continue;
    }
    $path = $file->getPathname();
    $content = file_get_contents($path);
    // Count @section (but not @show) and @endsection occurrences
    $sectionCount = preg_match_all('/@section\b/i', $content, $m1);
    $endCount = preg_match_all('/@endsection\b/i', $content, $m2);
    $showCount = preg_match_all('/@show\b/i', $content, $m3);
    // @show closes a @section too (short form), so treat @show as an end
    $effectiveEndCount = $endCount + $showCount;
    if ($sectionCount !== $effectiveEndCount) {
        $errors[] = [
            'file' => $path,
            'sections' => $sectionCount,
            'endvariants' => $endCount,
            'show' => $showCount,
            'effectiveEnd' => $effectiveEndCount,
        ];
    }
}
if (empty($errors)) {
    echo "All Blade files have matching @section and @endsection/@show counts.\n";
    exit(0);
}
foreach ($errors as $e) {
    echo "Mismatch in: {$e['file']}\n";
    echo "  @section: {$e['sections']}  @endsection: {$e['endvariants']}  @show: {$e['show']}  effective ends: {$e['effectiveEnd']}\n";
}
exit(1);
