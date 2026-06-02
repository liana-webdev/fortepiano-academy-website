<?php
require_once __DIR__ . '/includes/layout.php';
global $pricing;
$page = [
    'path' => '/pricing',
    'title' => 'Piano Lesson Pricing | Fortepiano Academy',
    'description' => 'View Fortepiano Academy assessment, setup and monthly piano program pricing for Foundation and Development pathways.',
    'schema' => [business_schema(), service_schema('Fortepiano Academy Piano Lesson Pricing', '/pricing'), breadcrumb_schema([['label' => 'Home', 'href' => '/'], ['label' => 'Pricing', 'href' => '/pricing']])],
];
render_head($page);
render_header('/pricing');
?>
<main>
    <section class="section blog-hero">
        <div class="section__content container">
            <?php render_breadcrumb([['label' => 'Home', 'href' => '/'], ['label' => 'Pricing', 'href' => '/pricing']]); ?>
            <div class="stack gap-m">
                <p class="article-meta">Monthly structured tuition</p>
                <h1>Piano lesson pricing</h1>
                <p class="lead">Pricing reflects structured program placement, lesson length and the level of support needed for each student.</p>
                <a class="btn btn--primary" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'pricing', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment']) ?>>Book Initial Assessment</a>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section__content container">
            <div class="grid grid--2 grid--gap-l">
                <article class="card card--glass"><h2>Initial Assessment</h2><p class="price-line"><?= e(money($pricing['assessment'])) ?></p><p>Required first step for placement and recommendation.</p></article>
                <article class="card card--glass"><h2>Program Setup</h2><p class="price-line"><?= e(money($pricing['setup'])) ?></p><p>Applies only if continuing, when enrolment and individual term planning are prepared.</p></article>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--2 grid--gap-l">
            <article class="card card--glass">
                <h2>Foundation Program</h2>
                <table class="pricing-table"><tbody>
                    <?php foreach ($pricing['foundation'] as $row): ?><tr><th><?= e($row['length']) ?></th><td><?= e(money($row['price'])) ?>/month</td></tr><?php endforeach; ?>
                </tbody></table>
                <p class="muted">Steady weekly pathway with regular practice structure.</p>
            </article>
            <article class="card card--glass program-card--recommended">
                <span class="program-reco">Recommended</span>
                <h2>Development Program</h2>
                <table class="pricing-table"><tbody>
                    <?php foreach ($pricing['development'] as $row): ?><tr><th><?= e($row['length']) ?></th><td><?= e(money($row['price'])) ?>/month</td></tr><?php endforeach; ?>
                </tbody></table>
                <p class="muted">Stronger structure for supported progress, AMEB readiness and accountability.</p>
            </article>
        </div>
    </section>
    <section class="section section--compact"><div class="section__content container"><p class="lead center">Tuition is billed monthly in advance. Lessons are offered through structured programs rather than casual single bookings.</p></div></section>
    <?php render_cta_band('Begin with assessment first', 'The assessment is the cleanest way to confirm the right lesson length and monthly program.', 'Book Initial Assessment', '/initial-assessment#book', 'Contact Fortepiano Academy', '/contact', 'pricing'); ?>
</main>
<?php render_footer(); ?>
