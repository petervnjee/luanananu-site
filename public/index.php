<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('log_errors', '1');

try {
    require dirname(__DIR__) . '/app/bootstrap.php';
    $site = new App\Models\Site();
    $router = new App\Router($site, new App\Controllers\PageController($site));
    // Plesk must provide HTTPS from the actual connection; arbitrary proxy headers are not trusted.
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_SERVER['HTTP_HOST'] ?? '', $https)
        ->send($_SERVER['REQUEST_METHOD'] === 'HEAD');
} catch (Throwable $error) {
    error_log((string) $error);
    http_response_code(500);
    header('Content-Type: text/html; charset=UTF-8');
    header('Cache-Control: no-store');
    header('X-Robots-Tag: noindex');
    header('X-Content-Type-Options: nosniff');
    header_remove('X-Powered-By');
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'HEAD') {
        echo '<!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Temporarily unavailable | Luana Nanu</title><main><h1>Temporarily unavailable</h1><p>Please try again shortly.</p></main></html>';
    }
}
