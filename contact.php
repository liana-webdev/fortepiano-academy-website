<?php
require_once __DIR__ . '/includes/layout.php';
global $programs;
$page = [
    'path' => '/contact',
    'title' => 'Contact Fortepiano Academy | Studio and At-Home Piano Lessons',
    'description' => 'Contact Fortepiano Academy for studio or at-home piano lessons, assessment bookings, travel quotes and program questions.',
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
            <p class="lead">Use this form for studio or at-home assessment bookings, travel quotes, program questions, pricing questions or general enquiries.</p>
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
                <div class="card card--glass">
                    <h2>At-home lesson enquiries</h2>
                    <p>Home lessons are available across listed surrounding suburbs, subject to availability. Travel fees start from <?= e(money(HOME_LESSON_TRAVEL_FEE)) ?> per visit for the return journey from Wentworth Point.</p>
                    <p>Provide your suburb and nearest cross street so the exact travel fee can be confirmed before booking.</p>
                </div>
                <div class="card">
                    <iframe class="map" title="Map to Fortepiano Academy" loading="lazy" src="https://www.google.com/maps?q=5%20Verona%20Drive%20Wentworth%20Point%20NSW%202127&output=embed"></iframe>
                </div>
                <div class="card card--soft">
                    <h2>Assessment prompt</h2>
                    <p>The Initial Assessment is the clearest starting point if you want a recommended program and lesson length.</p>
                    <div class="contact-program-summary">
                        <p><strong>Foundation</strong><span><?= e($programs['foundation']['frequency']) ?></span></p>
                        <p><strong>Development</strong><span><?= e($programs['development']['frequency']) ?></span></p>
                    </div>
                    <a class="btn btn--ghost" href="/initial-assessment#book">Book Initial Assessment</a>
                </div>
            </aside>
        </div>
    </section>
</main>
<?php render_footer(); ?>
