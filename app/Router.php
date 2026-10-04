<?php
declare(strict_types=1);

namespace App;

use App\Controllers\PageController;
use App\Models\Site;

final class Router
{
    public function __construct(private readonly Site $site, private readonly PageController $controller) {}

    public function dispatch(string $method, string $uri, string $host = '', bool $https = true): Response
    {
        if (!in_array($method, ['GET', 'HEAD'], true)) {
            return $this->controller->error(405);
        }
        // Never derive a filesystem path or redirect host from visitor input.
        $rawPath = explode('?', $uri, 2)[0];
        if (!str_starts_with($rawPath, '/') || preg_match('/[\\x00-\\x20\\x7f\\\\]/', $rawPath)
            || preg_match('/%(?![0-9a-f]{2})|%(?:2f|5c|00)/i', $rawPath)) {
            return $this->controller->error(400);
        }
        $path = rawurldecode($rawPath);
        if (preg_match('/[\\x00-\\x20\\x7f\\\\]/', $path)) {
            return $this->controller->error(400);
        }
        $normalized = strtolower(preg_replace('~/+~', '/', $path));
        $normalized = rtrim($normalized, '/') ?: '/';
        $aliases = ['/index.html' => '/', '/index.php' => '/', '/index' => '/'];
        foreach ($this->site->pages as $route => $_) {
            if ($route !== '/') {
                $aliases[$route . '.html'] = $route;
                $aliases[$route . '.php'] = $route;
            }
        }
        $target = $aliases[$normalized] ?? $normalized;
        $known = isset($this->site->pages[$target]) || in_array($target, ['/sitemap.xml', '/robots.txt'], true);
        if (!$known) {
            return $this->controller->error(404);
        }
        $productionHost = in_array(strtolower($host), ['luanananu.com', 'www.luanananu.com'], true);
        if ($rawPath !== $target || ($productionHost && (!$https || strtolower($host) !== 'luanananu.com'))) {
            // Tracking parameters have no functional purpose; legacy redirects drop them.
            return new Response(301, '', ['Location' => Site::ORIGIN . $target]);
        }
        if ($target === '/sitemap.xml') {
            return $this->controller->sitemap();
        }
        if ($target === '/robots.txt') {
            return new Response(200, "User-agent: *\nAllow: /\n\nSitemap: " . Site::ORIGIN . "/sitemap.xml\n", ['Content-Type' => 'text/plain; charset=UTF-8']);
        }
        return $this->controller->show($target);
    }
}
