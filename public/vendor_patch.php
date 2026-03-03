<?php

/**
 * IBSEA Advanced Vendor Compatibility Patch (Universal Version)
 * This script recursively cleans the vendor directory of PHP 8.1+ syntax
 * that causes ParseErrors on PHP 8.0.
 */

set_time_limit(0);
echo "<h1>IBSEA Advanced Compatibility Patcher</h1><ul>";

$vendorPath = __DIR__ . '/../vendor';

if (!is_dir($vendorPath)) {
    die("Error: vendor directory not found.");
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($vendorPath));
$patchedFiles = 0;

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $filePath = $file->getRealPath();
        
        // Skip large files or certain directories if needed for performance
        if (strpos($filePath, 'composer') !== false) continue;

        $content = file_get_contents($filePath);
        $original = $content;
        $needsPatch = false;

        // 1. Fix First-Class Callable Syntax: func(...) -> Closure::fromCallable('func') or Closure::fromCallable($var)
        // Note: For simplicity and max compatibility, we just remove the (...) in common cases or use fromCallable
        if (preg_match('/(\$?\w+)\(\.\.\.\)/', $content)) {
            // Replace $handler(...) with \Closure::fromCallable($handler)
            $content = preg_replace('/(\$\w+)\(\.\.\.\)/', '\Closure::fromCallable($1)', $content);
            // Replace word(...) with 'word' (likely a function name)
            $content = preg_replace('/(?<!\$)([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)\(\.\.\.\)/', "'$1'", $content);
            $needsPatch = true;
        }

        // 2. Fix Readonly Classes & Properties (PHP 8.2+)
        if (strpos($content, 'readonly class') !== false) {
            $content = str_replace('readonly class', 'class', $content);
            $needsPatch = true;
        }
        if (preg_match('/public readonly /', $content)) {
            $content = str_replace('public readonly ', 'public ', $content);
            $needsPatch = true;
        }
        if (preg_match('/private readonly /', $content)) {
            $content = str_replace('private readonly ', 'private ', $content);
            $needsPatch = true;
        }
        if (preg_match('/protected readonly /', $content)) {
            $content = str_replace('protected readonly ', 'protected ', $content);
            $needsPatch = true;
        }

        // 3. Fix Enums (PHP 8.1+) - Only for simple cases like the one in brick/math
        if (strpos($content, 'enum RoundingMode') !== false) {
            $content = str_replace('enum RoundingMode', 'class RoundingMode', $content);
            $content = preg_replace('/case (\w+);/', 'public const $1 = \'$1\';', $content);
            $needsPatch = true;
        }

        // 4. Fix attributes (PHP 8.3 Specifics like Override)
        if (strpos($content, 'use Override;') !== false) {
            $content = str_replace('use Override;', '', $content);
            $needsPatch = true;
        }
        if (strpos($content, '#[Override]') !== false) {
            $content = str_replace('#[Override]', '', $content);
            $needsPatch = true;
        }

        if ($needsPatch) {
            file_put_contents($filePath, $content);
            $patchedFiles++;
        }
    }
}

echo "</ul>";
echo "<h3>Patching Complete!</h3>";
echo "<p>Total files modified: <strong>$patchedFiles</strong></p>";
echo "<p>Please try your password reset again. If errors persist, please tell us the NEW error message!</p>";
