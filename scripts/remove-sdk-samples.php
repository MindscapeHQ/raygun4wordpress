<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

// Standalone SDK demos are not part of the WordPress plugin.
$directory = __DIR__ . '/../vendor/mindscape/raygun4php/sample-apps';

if (!is_dir($directory)) {
    return;
}

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::CHILD_FIRST
);

foreach ($files as $file) {
    $removed = $file->isDir() && !$file->isLink()
        ? rmdir($file->getPathname())
        : unlink($file->getPathname());

    if (!$removed) {
        throw new RuntimeException('Could not remove SDK sample: ' . $file->getPathname());
    }
}

if (!rmdir($directory)) {
    throw new RuntimeException('Could not remove SDK sample directory: ' . $directory);
}
