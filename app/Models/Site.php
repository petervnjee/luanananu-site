<?php
declare(strict_types=1);

namespace App\Models;

final class Site
{
    public const ORIGIN = 'https://luanananu.com';
    public readonly array $pages;
    public readonly array $person;

    public function __construct()
    {
        $this->pages = json_decode(file_get_contents(__DIR__ . '/../data/pages.json'), true, 512, JSON_THROW_ON_ERROR);
        $this->person = json_decode(file_get_contents(__DIR__ . '/../data/person.json'), true, 512, JSON_THROW_ON_ERROR);
    }

    public function schema(string $path, array $page): array
    {
        $url = self::ORIGIN . $path;
        $person = $this->person + [
            '@id' => self::ORIGIN . '/#person',
            'url' => self::ORIGIN . '/about',
            'image' => self::ORIGIN . html_entity_decode(asset('assets/luana-nanu.webp')),
        ];
        $website = [
            '@type' => 'WebSite', '@id' => self::ORIGIN . '/#website',
            'url' => self::ORIGIN . '/', 'name' => 'Luana Nanu',
            'inLanguage' => 'en', 'publisher' => ['@id' => $person['@id']],
        ];
        $webpage = [
            '@type' => $page['type'], '@id' => $url . '#webpage',
            'url' => $url, 'name' => $page['title'], 'description' => $page['description'],
            'inLanguage' => 'en', 'isPartOf' => ['@id' => $website['@id']],
            'about' => ['@id' => $person['@id']],
        ];
        if ($path === '/about') {
            $webpage['mainEntity'] = ['@id' => $person['@id']];
        }
        $graph = [$website, $person, $webpage];
        if ($path !== '/') {
            $graph[2]['breadcrumb'] = ['@id' => $url . '#breadcrumb'];
            $graph[] = [
                '@type' => 'BreadcrumbList', '@id' => $url . '#breadcrumb',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => self::ORIGIN . '/'],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => $page['label'], 'item' => $url],
                ],
            ];
        }
        return ['@context' => 'https://schema.org', '@graph' => $graph];
    }
}
