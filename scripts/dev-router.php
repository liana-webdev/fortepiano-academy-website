<?php
declare(strict_types=1);

// Router used only by PHP's local development server for clean-URL QA.
$root = dirname(__DIR__);
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
$candidate = realpath($root . $path);

if ($candidate !== false && str_starts_with($candidate, $root) && is_file($candidate)) {
    return false;
}

$routes = [
    '/' => 'index.php',
    '/initial-assessment' => 'initial-assessment.php',
    '/programs' => 'programs.php',
    '/pricing' => 'pricing.php',
    '/faculty' => 'faculty.php',
    '/results' => 'results.php',
    '/contact' => 'contact.php',
    '/blog' => 'blog.php',
];

$normalised = $path === '/' ? '/' : rtrim($path, '/');
if ($normalised === '/teacher') {
    header('Location: /faculty', true, 301);
    exit;
}

if (isset($routes[$normalised])) {
    require $root . '/' . $routes[$normalised];
    return true;
}

if (preg_match('#^/piano-lessons-[a-z0-9-]+$#', $normalised) === 1) {
    $_GET['page'] = ltrim($normalised, '/');
    require $root . '/local.php';
    return true;
}

http_response_code(404);
require $root . '/404.php';
return true;
