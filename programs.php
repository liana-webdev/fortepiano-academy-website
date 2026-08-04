<?php
require_once __DIR__ . '/includes/layout.php';
global $programs;
$page = [
    'path' => '/programs',
    'title' => 'Piano Programs | Foundation and Development | Fortepiano Academy',
    'description' => 'Compare the once-weekly Foundation Program and twice-weekly Development Program at Fortepiano Academy.',
    'schema' => [business_schema(), service_schema('Fortepiano Academy Piano Programs', '/programs'), breadcrumb_schema([['label' => 'Home', 'href' => '/'], ['label' => 'Programs', 'href' => '/programs']])],
];
render_head($page);
render_header('/programs');
?>
<main>
    <section class="section blog-hero">
        <div class="section__content container">
            <?php render_breadcrumb([['label' => 'Home', 'href' => '/'], ['label' => 'Programs', 'href' => '/programs']]); ?>
            <div class="stack gap-m">
                <p class="article-meta">Foundation and Development</p>
                <h1>Programs built for structured progress</h1>
                <p class="lead">Fortepiano Academy uses programs because meaningful piano progress needs a pathway, whether lessons take place at the studio or in your home.</p>
                <div class="actions">
                    <a class="btn btn--primary" href="/pricing"<?= tracking_attrs('view_pricing', ['page_type' => 'programs']) ?>>See Pricing</a>
                    <a class="btn btn--ghost" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'programs', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment']) ?>>Book Initial Assessment</a>
                </div>
            </div>
        </div>
    </section>
    <section class="section section--compact">
        <div class="section__content container">
            <div class="card card--glass">
                <h2>Choose studio or at-home lessons</h2>
                <p>Both programs are available at the Wentworth Point studio or at your home in a listed surrounding suburb, subject to availability. At-home lessons include a travel fee starting from <?= e(money(HOME_LESSON_TRAVEL_FEE)) ?> per visit.</p>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--2 grid--gap-l" data-analytics-view="program_compare_view" data-analytics-page-type="programs">
            <article class="card card--glass program-card">
                <h2>Foundation Program</h2>
                <p class="program-frequency"><?= e($programs['foundation']['frequency']) ?></p>
                <p><?= e($programs['foundation']['best_for']) ?></p>
                <p class="program-benefit"><strong>Main benefit:</strong> <?= e($programs['foundation']['benefit']) ?></p>
                <ul class="tick-list">
                    <li><?= e($programs['foundation']['frequency']) ?></li>
                    <li>Term-based learning plan</li>
                    <li>Weekly practice diary</li>
                    <li>Studio recital participation</li>
                    <li>Limited support outside lesson hours</li>
                </ul>
            </article>
            <article class="card card--glass program-card program-card--recommended">
                <span class="program-reco">Recommended</span>
                <h2>Development Program</h2>
                <p class="program-frequency"><?= e($programs['development']['frequency']) ?></p>
                <p><?= e($programs['development']['best_for']) ?></p>
                <p class="program-benefit"><strong>Main benefit:</strong> <?= e($programs['development']['benefit']) ?></p>
                <ul class="tick-list">
                    <li><?= e($programs['development']['frequency']) ?></li>
                    <li>Everything in Foundation</li>
                    <li>Monthly progress reports</li>
                    <li>Structured AMEB preparation where appropriate</li>
                    <li>Mock exams and readiness checks</li>
                    <li>Teacher-managed AMEB enrolment and exam fees covered</li>
                    <li>Outside-lesson support by arrangement and availability</li>
                </ul>
            </article>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--3 grid--gap-l">
            <article class="card"><h2>Moving between programs</h2><p>Students can move between Foundation and Development after progress, readiness and goals are reviewed.</p></article>
            <article class="card"><h2>Lesson length progression</h2><p>Lesson length increases when the student needs more time for technique, repertoire, theory and exam preparation.</p></article>
            <article class="card"><h2>AMEB pathway</h2><p>AMEB work is recommended when it supports the student rather than becoming pressure for its own sake.</p></article>
        </div>
    </section>
    <?php render_cta_band('Start with the right pathway', 'The assessment allows the academy to recommend the program and lesson length that actually fits.', 'Book Initial Assessment', '/initial-assessment#book', 'See Pricing', '/pricing', 'programs'); ?>
</main>
<?php render_footer(); ?>
