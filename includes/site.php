<?php
declare(strict_types=1);

const SITE_URL = 'https://fortepianoacademy.au';
const SITE_NAME = 'Fortepiano Academy';
const SITE_EMAIL = 'contact@fortepianoacademy.au';
const SITE_PHONE = '+61 482 176 777';
const SITE_PHONE_LINK = '+61482176777';
const SITE_ADDRESS = '5 Verona Drive, Wentworth Point NSW 2127';
const SITE_ABN = '98117712543';
const GOOGLE_REVIEW_URL = 'https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChZDSUhNMG9nS0VJQ0FnSUN0LXR1TlRBEAE!2m1!1s0x0:0x8eef43b6cdb2eea0!3m1!1s2@1:CIHM0ogKEICAgICt-tuNTA%7CCgwIqIiUtwYQ4MbrywE%7C?hl=en-AU';

$pricing = [
    'assessment' => 40,
    'setup' => 80,
    'foundation' => [
        ['length' => '30 min', 'price' => 300],
        ['length' => '45 min', 'price' => 340],
        ['length' => '60 min', 'price' => 380],
    ],
    'development' => [
        ['length' => '30 min', 'price' => 610],
        ['length' => '45 min', 'price' => 690],
        ['length' => '60 min', 'price' => 770],
    ],
];

$navItems = [
    ['label' => 'Home', 'href' => '/'],
    ['label' => 'Assessment', 'href' => '/initial-assessment'],
    ['label' => 'Programs', 'href' => '/programs'],
    ['label' => 'Pricing', 'href' => '/pricing'],
    ['label' => 'Teacher', 'href' => '/teacher'],
    ['label' => 'Results', 'href' => '/results'],
    ['label' => 'Blog', 'href' => '/blog'],
    ['label' => 'Contact', 'href' => '/contact'],
];

function e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function money(int $amount): string
{
    return '$' . number_format($amount);
}

function canonical(string $path): string
{
    return SITE_URL . ($path === '/' ? '/' : '/' . ltrim($path, '/'));
}

function business_schema(): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => ['LocalBusiness', 'MusicSchool'],
        '@id' => SITE_URL . '/#business',
        'name' => SITE_NAME,
        'url' => SITE_URL . '/',
        'telephone' => SITE_PHONE,
        'email' => SITE_EMAIL,
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => '5 Verona Drive',
            'addressLocality' => 'Wentworth Point',
            'addressRegion' => 'NSW',
            'postalCode' => '2127',
            'addressCountry' => 'AU',
        ],
        'areaServed' => [
            'Wentworth Point',
            'Rhodes',
            'Sydney Olympic Park',
            'Newington',
            'Homebush',
            'Lidcombe',
        ],
    ];
}

function breadcrumb_schema(array $items): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => array_map(
            fn(array $item, int $index): array => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['label'],
                'item' => canonical($item['href']),
            ],
            $items,
            array_keys($items)
        ),
    ];
}

function service_schema(string $name, string $url, string $area = 'Wentworth Point'): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $name,
        'serviceType' => 'Private piano lessons',
        'areaServed' => $area,
        'provider' => [
            '@id' => SITE_URL . '/#business',
        ],
        'url' => canonical($url),
    ];
}

function render_json_ld(array $schema): void
{
    echo '<script type="application/ld+json">' . PHP_EOL;
    echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    echo PHP_EOL . '</script>' . PHP_EOL;
}

function tracking_attrs(string $event, array $params = []): string
{
    $attrs = ' data-analytics-event="' . e($event) . '"';
    foreach ($params as $key => $value) {
        $attrs .= ' data-analytics-' . e(str_replace('_', '-', $key)) . '="' . e((string) $value) . '"';
    }
    return $attrs;
}
?>
