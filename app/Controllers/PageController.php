<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Site;
use App\Response;

final class PageController
{
    public function __construct(private readonly Site $site) {}

    public function show(string $path): Response
    {
        return $this->render($path, $this->site->pages[$path]);
    }

    public function error(int $status): Response
    {
        $messages = [
            400 => ['Invalid address', 'Please check the address or choose a page below.'],
            404 => ['Page not found', 'This address does not match a page on the site. Explore the research or get in touch below.'],
            405 => ['Method not allowed', 'This website supports browsing with GET and HEAD requests.'],
        ];
        [$title, $description] = $messages[$status];
        return $this->render('', [
            'view' => 'error', 'label' => $title, 'title' => $title . ' | Luana Nanu',
            'description' => $description, 'status' => $status,
        ], $status);
    }

    public function sitemap(): Response
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($this->site->pages as $path => $_) {
            $xml .= '  <url><loc>' . e(Site::ORIGIN . $path) . "</loc></url>\n";
        }
        return new Response(200, $xml . "</urlset>\n", ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    private function render(string $path, array $page, int $status = 200): Response
    {
        $site = $this->site;
        $canonical = Site::ORIGIN . $path;
        $schema = $status === 200 ? $site->schema($path, $page) : null;
        // View names come only from the trusted page registry or the error handler.
        ob_start();
        try {
            require __DIR__ . '/../Views/layout.php';
            $html = ob_get_contents();
        } finally {
            ob_end_clean();
        }
        $headers = $status === 200 ? [] : ['X-Robots-Tag' => 'noindex', 'Cache-Control' => 'no-store'];
        if ($status === 405) {
            $headers['Allow'] = 'GET, HEAD';
        }
        return new Response($status, $html, $headers);
    }
}
