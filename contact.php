<?php
require_once __DIR__ . '/includes/layout.php';
$page = [
    'path' => '/contact',
    'title' => 'Contact Fortepiano Academy | Wentworth Point Piano Lessons',
    'description' => 'Contact Fortepiano Academy for piano lesson enquiries, initial assessment bookings, program questions and studio details.',
    'schema' => [business_schema(), breadcrumb_schema([['label' => 'Home', 'href' => '/'], ['label' => 'Contact', 'href' => '/contact']])],
];
render_head($page);
render_header('/contact');
?>
<main>
    <section class="section blog-hero">
        <div class="section__content container">
            <?php render_breadcrumb([['label' => 'Home', 'href' => '/'], ['label' => 'Contact', 'href' => '/contact']]); ?>
            <h1>Contact Fortepiano Academy</h1>
            <p class="lead">Use this form for assessment bookings, program questions, pricing questions or general enquiries.</p>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--2 grid--gap-xl align-start">
            <?php render_contact_form('contact', 'Send Enquiry'); ?>
            <aside class="stack gap-s">
                <div class="card card--glass">
                    <h2>Studio details</h2>
                    <p><?= e(SITE_ADDRESS) ?></p>
                    <p><a href="tel:<?= e(SITE_PHONE_LINK) ?>"<?= tracking_attrs('phone_click', ['page_type' => 'contact', 'cta_position' => 'contact_card']) ?>><?= e(SITE_PHONE) ?></a></p>
                    <p><a href="mailto:<?= e(SITE_EMAIL) ?>"<?= tracking_attrs('email_click', ['page_type' => 'contact', 'cta_position' => 'contact_card']) ?>><?= e(SITE_EMAIL) ?></a></p>
                </div>
                <div class="card">
                    <iframe class="map" title="Map to Fortepiano Academy" loading="lazy" src="https://www.google.com/maps?q=5%20Verona%20Drive%20Wentworth%20Point%20NSW%202127&output=embed"></iframe>
                </div>
                <div class="card card--soft">
                    <h2>Assessment prompt</h2>
                    <p>The Initial Assessment is the clearest starting point if you want a recommended program and lesson length.</p>
                    <a class="btn btn--ghost" href="/initial-assessment#book">Book Initial Assessment</a>
                </div>
            </aside>
        </div>
    </section>
</main>
<?php render_footer(); ?>
