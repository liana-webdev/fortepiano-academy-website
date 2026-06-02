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
    'title' => $local['title'],
    'description' => $local['description'],
    'image' => '/images/piano-lesson-wentworth-point.jpg',
    'schema' => [
        business_schema(),
        service_schema($local['h1'], $local['path'], $local['area']),
        breadcrumb_schema([['label' => 'Home', 'href' => '/'], ['label' => $local['label'], 'href' => $local['path']]]),
    ],
];
$faqs = [
    ['q' => 'Are lessons located in ' . $local['faq_area'] . '?', 'a' => $local['honesty']],
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
                    <p class="article-meta">Piano lessons <?= e($local['label']) ?></p>
                    <h1><?= e($local['h1']) ?></h1>
                    <p class="lead"><?= e($local['intro']) ?></p>
                    <p><?= e($local['honesty']) ?></p>
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
            <article class="card"><h2>Who this page is for</h2><p>Families from <?= e($local['label']) ?> looking for clear one-to-one piano lessons, structured practice and long-term progress.</p></article>
            <article class="card"><h2>What makes lessons structured</h2><p>Students follow assessment-led placement, term planning, practice diaries, progress feedback and clear next steps.</p></article>
            <article class="card"><h2>AMEB pathway</h2><p>AMEB preparation is available when it suits the student level, goals and readiness.</p></article>
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
                <p><?= e($local['service_area']) ?></p>
            </div>
        </div>
    </section>
    <section class="section"><div class="section__content container"><header class="section__header center"><h2>Local FAQs</h2></header><?php render_faqs($faqs); ?></div></section>
    <?php render_cta_band('Start with a clear pathway', 'Book the Initial Assessment and receive a recommended program for your child.', 'Book Initial Assessment', '/initial-assessment#book', 'View Pricing', '/pricing', 'local'); ?>
</main>
<?php render_footer(); ?>
