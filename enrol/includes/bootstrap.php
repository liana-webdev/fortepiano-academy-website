<?php
declare(strict_types=1);

const ENROL_ROOT = __DIR__ . '/..';
const CANONICAL_DOMAIN = 'fortepianoacademy.au';

function enrol_start_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_name('fortepiano_enrol');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/enrol',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function enrol_security_headers(): void
{
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}

function enrol_config(): array
{
    static $config = null;
    if (is_array($config)) {
        return $config;
    }

    $defaults = [
        'smtp' => [],
        'tracking' => [],
        'site' => [
            'privacy_policy_url' => '/privacy-policy.html',
            'canonical_url' => 'https://fortepianoacademy.au/enrol',
            'og_image_url' => 'https://fortepianoacademy.au/enrol/assets/img/og-image-placeholder.jpg',
        ],
        'testing' => ['allow_local_test_delivery' => false],
    ];

    $path = ENROL_ROOT . '/config.php';
    $custom = is_file($path) ? require $path : [];
    $custom = is_array($custom) ? $custom : [];
    $config = array_replace_recursive($defaults, $custom);
    return $config;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function enrol_csrf_token(): string
{
    $issuedAt = (int) ($_SESSION['csrf_issued_at'] ?? 0);
    if (empty($_SESSION['csrf_token']) || $issuedAt < time() - 7200) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_issued_at'] = time();
    }
    return (string) $_SESSION['csrf_token'];
}

function enrol_valid_csrf(string $token): bool
{
    $stored = (string) ($_SESSION['csrf_token'] ?? '');
    $issuedAt = (int) ($_SESSION['csrf_issued_at'] ?? 0);
    return $stored !== '' && $issuedAt >= time() - 7200 && hash_equals($stored, $token);
}

function enrol_flash_form(array $errors, array $values): void
{
    $_SESSION['form_flash'] = ['errors' => $errors, 'values' => $values];
}

function enrol_take_form_flash(): array
{
    $flash = $_SESSION['form_flash'] ?? ['errors' => [], 'values' => []];
    unset($_SESSION['form_flash']);
    return is_array($flash) ? $flash : ['errors' => [], 'values' => []];
}

function enrol_redirect(string $location): never
{
    header('Location: ' . $location, true, 303);
    exit;
}

function enrol_is_local_request(): bool
{
    $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
    $address = (string) ($_SERVER['REMOTE_ADDR'] ?? '');
    return str_starts_with($host, 'localhost') || str_starts_with($host, '127.0.0.1') || in_array($address, ['127.0.0.1', '::1'], true);
}

enrol_security_headers();
enrol_start_session();
