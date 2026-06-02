<?php
require_once __DIR__ . '/includes/layout.php';
$page = [
    'path' => '/programs',
    'title' => 'Piano Programs | Foundation and Development | Fortepiano Academy',
    'description' => 'Compare the Foundation and Development piano programs at Fortepiano Academy and understand which pathway best suits your child.',
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
                <p class="lead">Fortepiano Academy uses programs because meaningful piano progress needs a pathway, not random casual bookings.</p>
                <div class="actions">
                    <a class="btn btn--primary" href="/pricing"<?= tracking_attrs('view_pricing', ['page_type' => 'programs']) ?>>See Pricing</a>
                    <a class="btn btn--ghost" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'programs', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment']) ?>>Book Initial Assessment</a>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--2 grid--gap-l" data-analytics-view="program_compare_view" data-analytics-page-type="programs">
            <article class="card card--glass program-card">
                <h2>Foundation Program</h2>
                <p>A steady starting pathway for students who need regular weekly structure and families who can support consistent home practice.</p>
                <ul class="tick-list">
                    <li>One lesson per week</li>
                    <li>Term-based learning plan</li>
                    <li>Weekly practice diary</li>
                    <li>Studio recital participation</li>
                    <li>Limited support outside lesson hours</li>
                </ul>
            </article>
            <article class="card card--glass program-card program-card--recommended">
                <span class="program-reco">Recommended</span>
                <h2>Development Program</h2>
                <p>The default pathway for stronger progress, regular guidance, AMEB readiness and more teacher involvement.</p>
                <ul class="tick-list">
                    <li>Two lessons per week</li>
                    <li>More detailed term planning</li>
                    <li>Stronger accountability and reporting</li>
                    <li>AMEB preparation where appropriate</li>
                    <li>Better fit for serious graded progress</li>
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
    <?php render_cta_band('Start with the right pathway', 'The assessment allows Liana to recommend the program and lesson length that actually fits.', 'Book Initial Assessment', '/initial-assessment#book', 'See Pricing', '/pricing', 'programs'); ?>
</main>
<?php render_footer(); ?>
