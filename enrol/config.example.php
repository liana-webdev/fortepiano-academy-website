<?php
declare(strict_types=1);

/**
 * Copy this file to config.php and replace the placeholders.
 * config.php is blocked from web access by .htaccess and excluded from the ZIP.
 */
return [
    'smtp' => [
        'host' => 'smtp.your-provider.example',
        'port' => 587,
        'encryption' => 'tls', // tls (port 587) or ssl (port 465)
        'username' => 'contact@fortepianoacademy.au',
        'password' => 'REPLACE_WITH_A_PRIVATE_SMTP_PASSWORD',
        'from_email' => 'contact@fortepianoacademy.au',
        'from_name' => 'Fortepiano Academy Enrolments',
        'recipient_email' => 'contact@fortepianoacademy.au',
    ],

    // TRACKING CONFIGURATION — replace only in private config.php.
    // Leave any value blank to disable that integration.
    'tracking' => [
        'gtm_container_id' => '',       // Example format: GTM-XXXXXXX
        'ga4_measurement_id' => '',      // Example format: G-XXXXXXXXXX
        'google_ads_conversion_id' => '', // Example format: AW-XXXXXXXXX
        'google_ads_conversion_label' => '',
        'meta_pixel_id' => '',
    ],

    'site' => [
        'privacy_policy_url' => '/privacy-policy.html',
        'canonical_url' => 'https://fortepianoacademy.au/enrol',
        'og_image_url' => 'https://fortepianoacademy.au/enrol/assets/img/og-image-placeholder.jpg',
    ],

    // Local-only dry-run switch. Never enable this on public hosting.
    'testing' => [
        'allow_local_test_delivery' => false,
    ],
];
