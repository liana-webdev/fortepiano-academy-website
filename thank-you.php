<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/includes/layout.php';

$success = $_SESSION['main_site_lead_success'] ?? null;
$source = (string) ($_GET['source'] ?? '');
$confirmed = is_array($success)
    && in_array($source, ['assessment', 'contact'], true)
    && hash_equals((string) ($success['source'] ?? ''), $source)
    && (int) ($success['expires'] ?? 0) >= time();

unset($_SESSION['main_site_lead_success']);

if (!$confirmed) {
    http_response_code(404);
}

$page = [
    'path' => '/thank-you',
    'title' => $confirmed ? 'Enquiry received | Fortepiano Academy' : 'Confirmation unavailable | Fortepiano Academy',
    'description' => 'Fortepiano Academy enquiry confirmation.',
    'robots' => 'noindex, nofollow',
];

render_head($page);
render_header('');
?>
<main>
    <section class="section hero">
        <div class="section__content container">
            <div class="card stack gap-m center">
                <?php if ($confirmed): ?>
                    <p class="eyebrow">Enquiry confirmed</p>
                    <h1>Thank you — your enquiry has been received.</h1>
                    <p>Fortepiano Academy will be in touch shortly.</p>
                    <div class="actions center">
                        <a class="btn btn--primary" href="/">Return home</a>
                    </div>
                <?php else: ?>
                    <p class="eyebrow">Confirmation unavailable</p>
                    <h1>This confirmation is no longer active.</h1>
                    <p>No conversion has been recorded. Please return to the form if you still need to send an enquiry.</p>
                    <div class="actions center">
                        <a class="btn btn--primary" href="/contact#book">Return to contact</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php if ($confirmed): ?>
<script>
if (typeof window.gtag === 'function') {
    window.gtag('event', 'generate_lead', {
        form_type: <?= json_encode($source, JSON_UNESCAPED_SLASHES) ?>,
        page_type: <?= json_encode($source, JSON_UNESCAPED_SLASHES) ?>
    });
}
</script>
<?php endif; ?>
<?php render_footer(); ?>
