<?php
require_once __DIR__ . '/includes/layout.php';
global $pricing;
$page = [
    'path' => '/pricing',
    'title' => 'Piano Tuition Information | Fortepiano Academy',
    'description' => 'Begin with a $40 Initial Piano Assessment before receiving a recommended program, lesson length and ongoing tuition options.',
    'schema' => [business_schema(), service_schema('Fortepiano Academy Piano Tuition', '/pricing'), breadcrumb_schema([['label' => 'Home', 'href' => '/'], ['label' => 'Tuition', 'href' => '/pricing']])],
];
render_head($page);
render_header('/pricing');
?>
<main>
    <section class="section blog-hero">
        <div class="section__content container">
            <?php render_breadcrumb([['label' => 'Home', 'href' => '/'], ['label' => 'Tuition', 'href' => '/pricing']]); ?>
            <div class="stack gap-m">
                <p class="article-meta">Assessment-first enrolment</p>
                <h1>Piano tuition information</h1>
                <p class="lead">Start with a <?= e(money($pricing['assessment'])) ?> Initial Assessment. You do not need to choose a program or lesson length first.</p>
                <a class="btn btn--primary" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'pricing', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment']) ?>>Book Initial Assessment</a>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--3 grid--gap-l">
            <article class="card card--glass">
                <h2>Initial Assessment</h2>
                <p class="price-line"><?= e(money($pricing['assessment'])) ?></p>
                <p>A combined trial lesson and assessment used to understand level, goals, readiness and the most suitable pathway.</p>
            </article>
            <article class="card card--glass">
                <h2>Ongoing tuition</h2>
                <p>Foundation and Development tuition options are recommended after placement, together with the lesson length that fits the student.</p>
            </article>
            <article class="card card--glass">
                <h2>Studio or at home</h2>
                <p>Studio and selected at-home options are discussed after assessment. Any travel requirements are quoted and confirmed before booking.</p>
            </article>
        </div>
    </section>
    <section class="section section--compact"><div class="section__content container"><p class="lead center">The assessment comes first. Program placement and ongoing tuition options are recommended afterwards.</p></div></section>
    <?php render_cta_band('Begin with the assessment', 'Book the Initial Assessment to receive a recommended pathway and lesson length.', 'Book Initial Assessment', '/initial-assessment#book', 'Compare Programs', '/programs', 'pricing'); ?>
</main>
<?php render_footer(); ?>
