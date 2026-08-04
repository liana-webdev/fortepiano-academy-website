<?php
declare(strict_types=1);

const SITE_URL = 'https://fortepianoacademy.au';
const SITE_NAME = 'Fortepiano Academy';
const SITE_EMAIL = 'contact@fortepianoacademy.au';
const SITE_PHONE = '+61 482 176 777';
const SITE_PHONE_LINK = '+61482176777';
const SITE_ADDRESS = '5 Verona Drive, Wentworth Point NSW 2127';
const SITE_ABN = '98117712543';
const HOME_LESSON_TRAVEL_FROM = 'Wentworth Point';
const HOME_LESSON_TRAVEL_FEE = 15;
const GOOGLE_REVIEW_URL = 'https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChZDSUhNMG9nS0VJQ0FnSUN0LXR1TlRBEAE!2m1!1s0x0:0x8eef43b6cdb2eea0!3m1!1s2@1:CIHM0ogKEICAgICt-tuNTA%7CCgwIqIiUtwYQ4MbrywE%7C?hl=en-AU';
const GOOGLE_REVIEWS_PAGE_URL = 'https://www.google.com/maps/place/Fortepiano+Academy';

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
    ['label' => 'Academy', 'href' => '/#academy', 'active' => '/'],
    ['label' => 'Programs', 'href' => '/programs'],
    ['label' => 'Faculty', 'href' => '/faculty'],
    ['label' => 'Results', 'href' => '/results'],
    ['label' => 'Journal', 'href' => '/blog'],
    ['label' => 'Admissions', 'href' => '/initial-assessment'],
];

function academy_reviews(): array
{
    return [
        [
            'name' => 'Evasari Hermawan',
            'text' => 'We enrolled our 5-year-old two months ago and already see big improvement. Liana uses illustration and explains until he understands. Really recommended.',
            'url' => 'https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChZDSUhNMG9nS0VJQ0FnTUNJMzVYalRBEAE!2m1!1s0x0:0x8eef43b6cdb2eea0!3m1!1s2@1:CIHM0ogKEICAgMCI35XjTA%7CCgwIjLLGvwYQkPGE1gI%7C?hl=ru&g_ep=Eg1tbF8yMDI1MTAwOF8wKgBIAlAC',
        ],
        [
            'name' => 'Ying Wang',
            'text' => 'Patient, professional, and well-structured lessons. Both kids made impressive progress in two months.',
            'url' => 'https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChZDSUhNMG9nS0VJQ0FnSURIdnREcU13EAE!2m1!1s0x0:0x8eef43b6cdb2eea0!3m1!1s2@1:CIHM0ogKEICAgIDHvtDqMw%7CCgwI18WgtwYQkIy67gE%7C?hl=ru&g_ep=Eg1tbF8yMDI1MTAwOF8wKgBIAlAC',
        ],
        [
            'name' => 'Peter Lam',
            'text' => 'Our two children showed accelerated growth in reading, posture, and touch after switching to Fortepiano Academy.',
            'url' => 'https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChZDSUhNMG9nS0VJQ0FnSUN0LXR1TlRBEAE!2m1!1s0x0:0x8eef43b6cdb2eea0!3m1!1s2@1:CIHM0ogKEICAgICt-tuNTA%7CCgwIqIiUtwYQ4MbrywE%7C?hl=ru&g_ep=Eg1tbF8yMDI1MTAwOF8wKgBIAlAC',
        ],
        [
            'name' => 'Jun Yang',
            'text' => 'She taught me songs I actually want to play and the right techniques to play like a professional.',
            'url' => 'https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChdDSUhNMG9nS0VMaXltSURaOUt5cmt3RRAB!2m1!1s0x0:0x8eef43b6cdb2eea0!3m1!1s2@1:CIHM0ogKELiymIDZ9KyrkwE%7CCgwI-uDzwQYQ2MaVigM%7C?hl=en-AU&g_st=ic',
        ],
        [
            'name' => 'Danielle Eloss',
            'text' => 'Professionalism, knowledge and teaching technique. Highly recommend to anyone seeking piano lessons.',
            'url' => 'https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChZDSUhNMG9nS0VJQ0FnSUN0LXR1TlRBEAE!2m1!1s0x0:0x8eef43b6cdb2eea0!3m1!1s2@1:CIHM0ogKEICAgICt-tuNTA%7CCgwIqIiUtwYQ4MbrywE%7C?hl=ru&g_ep=Eg1tbF8yMDI1MTAwOF8wKgBIAlAC',
        ],
        [
            'name' => 'Angus Ta',
            'text' => 'Patient, thorough, and flexible. In two years my playing improved across scales and pieces.',
            'url' => 'https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChZDSUhNMG9nS0VJQ0FnSUN0LXR1TlRBEAE!2m1!1s0x0:0x8eef43b6cdb2eea0!3m1!1s2@1:CIHM0ogKEICAgICt-tuNTA%7CCgwIqIiUtwYQ4MbrywE%7C?hl=ru&g_ep=Eg1tbF8yMDI1MTAwOF8wKgBIAlAC',
        ],
        [
            'name' => 'Elizabeth Tuialii',
            'text' => 'Wonderful teacher. Very patient and encouraging with my daughter.',
            'url' => 'https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChdDSUhNMG9nS0VJQ0FnSUNkNHUzWjV3RRAB!2m1!1s0x0:0x8eef43b6cdb2eea0!3m1!1s2@1:CIHM0ogKEICAgICd4u3Z5wE%7CCgwIqIiUtwYQwPzJvwE%7C?hl=en-AU&g_st=ic',
        ],
        [
            'name' => 'Tanya Do',
            'text' => 'Both daughters have learned with Miss Liana for 3+ years. Significant improvement and they love lessons.',
            'url' => 'https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChZDSUhNMG9nS0VJQ0FnSUNkbWRDaWNnEAE!2m1!1s0x0:0x8eef43b6cdb2eea0!3m1!1s2@1:CIHM0ogKEICAgICdmdCicg%7CCgwIqIiUtwYQgL-HxwE%7C?hl=en-AU&g_st=ic',
        ],
        [
            'name' => 'Farzana Sharmeen',
            'text' => 'Friendly and skilled tutor with an amazing ability to motivate young learners.',
            'url' => 'https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChdDSUhNMG9nS0VJQ0FnSURYMzlycHRRRRAB!2m1!1s0x0:0x8eef43b6cdb2eea0!3m1!1s2@1:CIHM0ogKEICAgIDX39rptQE%7CCgsIg46TuQYQgL-PcQ%7C?hl=en-AU&g_st=ic',
        ],
        [
            'name' => 'Milton Mukando',
            'text' => 'Detailed, simplified program; very patient and flexible. Kids were very happy with each session.',
            'url' => 'https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChZDSUhNMG9nS0VJQ0FnSUNkdkxUNFpBEAE!2m1!1s0x0:0x8eef43b6cdb2eea0!3m1!1s2@1:CIHM0ogKEICAgICdvLT4ZA%7CCgwIqIiUtwYQ4OSFwAE%7C?hl=en-AU&g_st=ic',
        ],
    ];
}

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
            'Meadowbank',
            'Ryde',
            'Silverwater',
            'Concord West',
            'Melrose Park',
            'Ermington',
            'North Strathfield',
            'Liberty Grove',
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
        'availableChannel' => [
            [
                '@type' => 'ServiceChannel',
                'serviceLocation' => [
                    '@type' => 'Place',
                    'name' => 'Fortepiano Academy Wentworth Point studio',
                    'address' => SITE_ADDRESS,
                ],
            ],
            [
                '@type' => 'ServiceChannel',
                'serviceLocation' => [
                    '@type' => 'Place',
                    'name' => 'Student home in selected surrounding suburbs',
                ],
            ],
        ],
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
