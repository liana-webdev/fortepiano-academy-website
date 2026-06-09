<?php
require_once __DIR__ . '/includes/layout.php';
require_once __DIR__ . '/data/local-pages.php';
global $localPages;

$slug = $_GET['page'] ?? '';
if (!isset($localPages[$slug])) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}
$local = $localPages[$slug];
$page = [
    'path' => $local['path'],
    'title' => 'Studio and At-Home Piano Lessons in ' . $local['label'] . ' | Fortepiano Academy',
    'description' => 'Structured one-to-one piano lessons for ' . $local['label'] . ' families, available at the Wentworth Point studio or in your home subject to availability.',
    'image' => '/images/piano-lesson-wentworth-point.jpg',
    'schema' => [
        business_schema(),
        service_schema('Studio and at-home piano lessons in ' . $local['area'], $local['path'], $local['area']),
        breadcrumb_schema([['label' => 'Home', 'href' => '/'], ['label' => $local['label'], 'href' => $local['path']]]),
    ],
];
$faqs = [
    ['q' => 'Are at-home lessons available in ' . $local['faq_area'] . '?', 'a' => 'Yes. Liana can travel to homes in ' . $local['faq_area'] . ', subject to schedule and travel availability. Studio lessons are also available in Wentworth Point.'],
    ['q' => 'What is the travel fee for ' . $local['faq_area'] . '?', 'a' => 'Travel fees start from $15 per visit and cover the return journey from Wentworth Point. The exact fee is confirmed from your suburb and nearest cross street before booking.'],
    ['q' => 'Do students from ' . $local['faq_area'] . ' prepare for AMEB?', 'a' => 'Yes. AMEB-aligned preparation is available where it suits the student goals and readiness.'],
    ['q' => 'How do families from ' . $local['faq_area'] . ' begin?', 'a' => 'Begin with the Initial Assessment so Liana can recommend the right pathway and lesson length.'],
];
render_head($page);
render_header('');
?>
<main>
    <section class="section blog-hero">
        <div class="section__content container">
            <?php render_breadcrumb([['label' => 'Home', 'href' => '/'], ['label' => $local['label'], 'href' => $local['path']]]); ?>
            <div class="grid grid--2 grid--gap-xl align-center">
                <div class="stack gap-m">
                    <p class="article-meta">Studio and at-home piano lessons <?= e($local['label']) ?></p>
                    <h1>Structured piano lessons for <?= e($local['label']) ?> families</h1>
                    <p class="lead">Choose lessons at the Wentworth Point studio or have Liana come to your home in <?= e($local['label']) ?>, subject to availability.</p>
                    <p>At-home lessons follow the same structured program as studio lessons. Travel fees start from <?= e(money(HOME_LESSON_TRAVEL_FEE)) ?> per visit and are quoted for the return journey from Wentworth Point.</p>
                    <div class="actions">
                        <a class="btn btn--primary" href="/initial-assessment#book"<?= tracking_attrs('local_page_cta_click', ['page_type' => 'local', 'suburb_context' => $local['area'], 'cta_position' => 'hero']) ?>>Book Initial Assessment</a>
                        <a class="btn btn--ghost" href="/programs">View Programs</a>
                    </div>
                </div>
                <figure class="blog-hero__media card card--glass"><img src="/images/piano-lesson-wentworth-point.jpg" alt="Structured piano lesson at Fortepiano Academy" loading="eager"></figure>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--3 grid--gap-l">
            <article class="card"><h2>Lessons in your area</h2><p>Families in <?= e($local['label']) ?> can request a teacher who comes to their home, or attend the Wentworth Point studio.</p></article>
            <article class="card"><h2>What makes lessons structured</h2><p>Students follow assessment-led placement, term planning, practice diaries, progress feedback and clear next steps.</p></article>
            <article class="card"><h2>AMEB pathway</h2><p>AMEB preparation is available when it suits the student level, goals and readiness.</p></article>
        </div>
    </section>
    <section class="section">
        <div class="section__content container">
            <header class="section__header center"><h2>How at-home lessons work</h2></header>
            <div class="grid grid--3 grid--gap-l">
                <article class="card card--glass"><h3>Before booking</h3><p>Provide your suburb and nearest cross street. Liana confirms availability and the travel fee before the visit.</p></article>
                <article class="card card--glass"><h3>Prepare the lesson space</h3><p>The family provides timely access, a suitable acoustic or digital piano, the student's own books and a quiet place to learn.</p></article>
                <article class="card card--glass"><h3>During the visit</h3><p>Liana arrives with teaching materials, teaches the scheduled structured lesson, records the next practice steps and leaves after the lesson.</p></article>
            </div>
            <p class="muted center pad-top-m">Liana can advise families who need help choosing a suitable piano. Delayed access to the home does not extend the scheduled lesson time.</p>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--2 grid--gap-l">
            <article class="card card--glass"><h2>Programs available</h2><p>Foundation supports steady weekly learning. Development is the stronger pathway for accountability, serious progress and exam readiness.</p><a class="btn btn--ghost" href="/programs">View Programs</a></article>
            <article class="card card--glass"><h2>Initial Assessment</h2><p>The first step is a <?= e(money($pricing['assessment'])) ?> Initial Assessment to understand level, learning style, goals and recommended pathway.</p><a class="btn btn--primary" href="/initial-assessment#book">Book Initial Assessment</a></article>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--2 grid--gap-xl align-center">
            <figure class="card card--glass"><img src="/img/teacher and student holdsing cert.JPG" alt="Teacher and student holding certificate" loading="lazy"></figure>
            <div class="stack gap-s">
                <h2>Teacher credibility and results</h2>
                <p>Liana is a Russian-trained teacher who built Fortepiano Academy around structured pathways, AMEB-aligned progress, term plans and a calm professional studio environment.</p>
                <p>Studio and at-home lessons are available for <?= e($local['label']) ?> families. Home visits are subject to schedule, travel time and suitable access.</p>
            </div>
        </div>
    </section>
    <section class="section"><div class="section__content container"><header class="section__header center"><h2>Local FAQs</h2></header><?php render_faqs($faqs); ?></div></section>
    <?php render_cta_band('Start with a clear pathway', 'Book the Initial Assessment and receive a recommended program for your child.', 'Book Initial Assessment', '/initial-assessment#book', 'View Pricing', '/pricing', 'local'); ?>
</main>
<?php render_footer(); ?>
