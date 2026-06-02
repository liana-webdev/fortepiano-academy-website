<?php
require_once __DIR__ . '/includes/layout.php';
global $pricing;
$page = [
    'path' => '/initial-assessment',
    'title' => 'Initial Piano Assessment | Fortepiano Academy',
    'description' => 'Book an Initial Piano Assessment to understand your child level, readiness and recommended program pathway at Fortepiano Academy.',
    'schema' => [business_schema(), service_schema('Initial Piano Assessment', '/initial-assessment'), breadcrumb_schema([['label' => 'Home', 'href' => '/'], ['label' => 'Initial Assessment', 'href' => '/initial-assessment']])],
];
$faqs = [
    ['q' => 'Is this a trial lesson?', 'a' => 'It includes real teaching, but its main purpose is assessment and placement.'],
    ['q' => 'Do we need prior experience?', 'a' => 'No. Beginners are welcome.'],
    ['q' => 'Will we get a recommendation afterwards?', 'a' => 'Yes. You receive a recommended program, lesson length and next step within 24 hours.'],
    ['q' => 'Do we need to enrol on the day?', 'a' => 'No. The assessment comes first so you can decide with clarity.'],
];
render_head($page);
render_header('/initial-assessment');
?>
<main>
    <section class="section blog-hero">
        <div class="section__content container">
            <?php render_breadcrumb([['label' => 'Home', 'href' => '/'], ['label' => 'Initial Assessment', 'href' => '/initial-assessment']]); ?>
            <div class="grid grid--2 grid--gap-xl align-center">
                <div class="stack gap-m">
                    <p class="article-meta">First step</p>
                    <h1>Initial Piano Assessment</h1>
                    <p class="lead"><?= e(money($pricing['assessment'])) ?> assessment lesson for placement, readiness and pathway recommendation.</p>
                    <p>The Initial Assessment is a combined trial lesson and assessment, not a casual try-and-see lesson. It helps determine current level, learning style, readiness, goals and the most suitable starting pathway.</p>
                    <a class="btn btn--primary" href="#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'assessment', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment']) ?>>Book Initial Assessment</a>
                </div>
                <figure class="blog-hero__media card card--glass">
                    <img src="/images/beginner-piano-lesson.jpg" alt="Beginner piano student in a structured lesson" loading="eager">
                </figure>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--3 grid--gap-l">
            <article class="card card--glass"><h2>What happens</h2><p>Students work through real lesson material, observation, level checks and simple musical tasks that reveal coordination, rhythm, listening and focus.</p></article>
            <article class="card card--glass"><h2>What is assessed</h2><p>Reading, rhythm, posture, hand use, coordination, response to correction, confidence, goals and overall fit.</p></article>
            <article class="card card--glass"><h2>What happens after</h2><p>You receive a recommended program, suggested lesson length and next-step outline within 24 hours.</p></article>
        </div>
    </section>
    <section class="section">
        <div class="section__content container">
            <div class="grid grid--2 grid--gap-xl align-start">
                <div class="stack gap-s">
                    <p class="article-meta">If continuing</p>
                    <h2>Program Setup and enrolment</h2>
                    <p>Program Setup is <?= e(money($pricing['setup'])) ?> only if you continue. It covers enrolment setup, terms, and preparation of an individual term plan.</p>
                    <p>A clear beginning makes everything easier: enquiry, Initial Assessment, recommendation, Program Setup, individual term plan, then lessons begin.</p>
                </div>
                <?php render_contact_form('assessment', 'Book Initial Assessment'); ?>
            </div>
        </div>
    </section>
    <section class="section"><div class="section__content container"><header class="section__header center"><h2>Assessment FAQs</h2></header><?php render_faqs($faqs); ?></div></section>
</main>
<?php render_footer(); ?>
