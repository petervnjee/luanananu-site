<?php
declare(strict_types=1);

namespace App;

final class Response
{
    public function __construct(
        public readonly int $status,
        public readonly string $body = '',
        public readonly array $headers = [],
    ) {}

    public function send(bool $head = false): void
    {
        http_response_code($this->status);
        $defaults = [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Cache-Control' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'X-Frame-Options' => 'DENY',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
            // Cloudflare may inject its same-origin email decoding script.
            'Content-Security-Policy' => "default-src 'none'; script-src 'self'; style-src 'self'; img-src 'self'; font-src 'self'; base-uri 'none'; form-action 'none'; frame-ancestors 'none'",
        ];
        foreach ($this->headers + $defaults as $name => $value) {
            header($name . ': ' . $value);
        }
        header_remove('X-Powered-By');
        if (!$head) {
            echo $this->body;
        }
    }
}
