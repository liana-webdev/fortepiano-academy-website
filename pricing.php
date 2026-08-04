<?php
require_once __DIR__ . '/includes/layout.php';
global $pricing, $programs;
$page = [
    'path' => '/pricing',
    'title' => 'Piano Lesson Pricing | Fortepiano Academy',
    'description' => 'View studio and at-home piano lesson pricing, including assessment, monthly programs and home-visit travel fees.',
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
                <p class="lead">Pricing reflects structured program placement, lesson length and support. Choose studio lessons or at-home lessons with an additional travel fee.</p>
                <a class="btn btn--primary" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'pricing', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment']) ?>>Book Initial Assessment</a>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section__content container">
            <article class="card card--glass">
                <p class="article-meta">At-home lessons</p>
                <h2>Travel fees start from <?= e(money(HOME_LESSON_TRAVEL_FEE)) ?> per visit</h2>
                <p>At-home lessons, including an at-home Initial Assessment, include a separate travel fee. The fee covers the allocated teacher travelling from Wentworth Point to your home and returning from the visit.</p>
                <p>The starting fee applies to nearby addresses with an estimated total return journey of up to approximately 20 minutes. Longer travel times, tolls, parking requirements or difficult access may increase the fee. Your exact fee is confirmed before booking and is subject to availability.</p>
                <p class="muted">The travel fee is charged for each home visit and is separate from assessment, setup and monthly tuition fees.</p>
            </article>
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
                <p class="program-frequency"><?= e($programs['foundation']['frequency']) ?></p>
                <table class="pricing-table"><tbody>
                    <?php foreach ($pricing['foundation'] as $row): ?><tr><th><?= e($row['length']) ?></th><td><?= e(money($row['price'])) ?>/month</td></tr><?php endforeach; ?>
                </tbody></table>
                <p class="program-benefit"><strong>Main benefit:</strong> <?= e($programs['foundation']['benefit']) ?></p>
            </article>
            <article class="card card--glass program-card--recommended">
                <span class="program-reco">Recommended</span>
                <h2>Development Program</h2>
                <p class="program-frequency"><?= e($programs['development']['frequency']) ?></p>
                <table class="pricing-table"><tbody>
                    <?php foreach ($pricing['development'] as $row): ?><tr><th><?= e($row['length']) ?></th><td><?= e(money($row['price'])) ?>/month</td></tr><?php endforeach; ?>
                </tbody></table>
                <p class="program-benefit"><strong>Main benefit:</strong> <?= e($programs['development']['benefit']) ?></p>
            </article>
        </div>
    </section>
    <section class="section section--compact"><div class="section__content container"><p class="lead center">Tuition is billed monthly in advance. Lessons are offered through structured programs at the Wentworth Point studio or at your home, subject to travel availability.</p></div></section>
    <?php render_cta_band('Begin with assessment first', 'The assessment is the cleanest way to confirm the right lesson length and monthly program.', 'Book Initial Assessment', '/initial-assessment#book', 'Contact Fortepiano Academy', '/contact', 'pricing'); ?>
</main>
<?php render_footer(); ?>
