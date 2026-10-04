<?php
declare(strict_types=1);

// No framework, Composer, database, sessions, or runtime network calls required.
spl_autoload_register(static function (string $class): void {
    if (str_starts_with($class, 'App\\')) {
        $file = __DIR__ . '/' . str_replace('\\', '/', substr($class, 4)) . '.php';
        if (is_file($file)) {
            require $file;
        }
    }
});

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function asset(string $path): string
{
    static $manifest;
    $manifest ??= require __DIR__ . '/data/assets.php';
    if (!isset($manifest[$path])) {
        throw new RuntimeException('Unknown asset: ' . $path);
    }
    return e('/' . $manifest[$path]);
}
