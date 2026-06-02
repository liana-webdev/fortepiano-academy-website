<?php
require_once __DIR__ . '/includes/layout.php';
http_response_code(404);
$page = [
    'path' => '/404',
    'title' => 'Page Not Found | Fortepiano Academy',
    'description' => 'The requested Fortepiano Academy page could not be found.',
    'schema' => [business_schema()],
];
render_head($page);
render_header('');
?>
<main>
    <section class="section blog-hero">
        <div class="section__content container stack gap-m">
            <h1>Page not found</h1>
            <p class="lead">The page may have moved during the website rework.</p>
            <div class="actions">
                <a class="btn btn--primary" href="/">Go Home</a>
                <a class="btn btn--ghost" href="/contact">Contact Fortepiano Academy</a>
            </div>
        </div>
    </section>
</main>
<?php render_footer(); ?>
