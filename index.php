<?php
require_once __DIR__ . '/includes/layout.php';
global $pricing, $programs;

$page = [
    'path' => '/',
    'title' => 'Fortepiano Academy | Piano School in Wentworth Point, Sydney',
    'description' => 'Serious one-to-one piano education at the Wentworth Point studio and in selected Sydney suburbs through the Foundation and Development programs.',
    'image' => '/img/Aveena%20February%202022.jpg',
    'body_class' => 'home-editorial',
    'preload_image' => [
        'base' => '/images/responsive/hero-lesson',
        'widths' => [480, 768, 1200, 1600],
        'sizes' => '(max-width: 760px) calc(100vw - 36px), 40vw',
    ],
    'schema' => [
        business_schema(),
        [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => SITE_NAME,
            'url' => SITE_URL . '/',
        ],
    ],
];

$homeFaqs = [
    ['q' => 'How do we begin?', 'a' => 'Begin with the $40 Initial Assessment. It is a real teaching session used to understand level, readiness, goals and the most suitable program and lesson length.'],
    ['q' => 'What is the difference between Foundation and Development?', 'a' => $programs['foundation']['frequency'] . ' in Foundation, with more independent practice between lessons. ' . $programs['development']['frequency'] . ' in Development, with closer accountability, regular reporting and stronger AMEB preparation support where appropriate.'],
    ['q' => 'Are AMEB exams compulsory?', 'a' => 'No. AMEB preparation is available where it suits the student\'s goals and readiness. Recitals, musicianship, technique and repertoire remain meaningful forms of progress without a fixed examination timeline.'],
    ['q' => 'Where are lessons taught?', 'a' => 'Lessons are available at the Wentworth Point studio and at students\' homes across selected surrounding suburbs, subject to teacher, schedule and travel availability. Travel fees start from $15 per visit.'],
];
$reviews = academy_reviews();

render_head($page);
render_header('/');
?>
<main class="fa-home">
    <section class="fa-hero" aria-labelledby="home-title">
        <div class="editorial-inner fa-hero__grid">
            <div class="fa-hero__copy">
                <p class="fa-eyebrow">Piano education &middot; Children, teenagers and adults</p>
                <h1 id="home-title">A serious piano education, made <em>clear.</em></h1>
                <p class="fa-hero__intro">One-to-one piano lessons at the Wentworth Point studio and in students' homes across selected Sydney suburbs. Begin with an Initial Assessment, then enter Foundation or Development according to goals, readiness and support needed.</p>
                <div class="fa-actions">
                    <a class="fa-button fa-button--primary" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'home', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment']) ?>>
                        <span>Book Initial Assessment</span><span aria-hidden="true">&rarr;</span>
                    </a>
                    <a class="fa-button fa-button--secondary" href="/programs">Compare Programs</a>
                </div>
            </div>
            <figure class="fa-hero__media fa-iridescent-frame">
                <?php render_responsive_picture([
                    'base' => '/images/responsive/hero-lesson',
                    'widths' => [480, 768, 1200, 1600],
                    'fallback_width' => 1200,
                    'width' => 3024,
                    'height' => 4032,
                    'alt' => 'Liana guiding a young Fortepiano Academy student at the piano',
                    'sizes' => '(max-width: 760px) calc(100vw - 36px), 40vw',
                    'loading' => 'eager',
                    'fetchpriority' => 'high',
                ]); ?>
                <figcaption><span>Fortepiano Academy</span><span>Lesson study &middot; Wentworth Point</span></figcaption>
            </figure>
        </div>
    </section>

    <div class="fa-trust-strip editorial-inner" aria-label="Academy trust markers">
        <span>AMEB-aligned</span>
        <span>Practice diaries</span>
        <span>Progress reports</span>
        <span>Recital culture</span>
        <span>WWCC professional</span>
        <a href="<?= e(GOOGLE_REVIEWS_PAGE_URL) ?>" target="_blank" rel="noopener">5.0 Google rating</a>
    </div>

    <section class="fa-section fa-academy" id="academy" aria-labelledby="academy-title">
        <div class="editorial-inner">
            <p class="fa-section-label">01 / The Academy</p>
            <div class="fa-section-heading fa-section-heading--wide">
                <div>
                    <p class="fa-eyebrow">Piano study with direction</p>
                    <h2 id="academy-title">Most students do not lack talent. They lack a clear <em>path.</em></h2>
                </div>
                <div class="fa-section-intro">
                    <p class="fa-serif-lead">Lessons connect posture, rhythm, reading, technique, repertoire and practice into one coherent progression.</p>
                    <p>Families can see what the student is working toward, how practice should be organised and when the program needs to change. Each plan remains individual while teaching, reporting and performance standards stay consistent across the academy.</p>
                </div>
            </div>
            <div class="fa-principles">
                <article><span>01</span><h3>Term Plans</h3><p>Learning is organised around term goals rather than disconnected weekly activity.</p></article>
                <article><span>02</span><h3>Diaries &amp; Reports</h3><p>Practice directions and progress are visible to students and families.</p></article>
                <article><span>03</span><h3>Exam Pathways</h3><p>AMEB preparation is available when it suits the student's goals and readiness.</p></article>
                <article><span>04</span><h3>Performances</h3><p>Recitals build confidence, concentration and musical communication.</p></article>
            </div>
        </div>
    </section>

    <section class="fa-section fa-programs" id="programs" aria-labelledby="programs-title">
        <div class="editorial-inner">
            <p class="fa-section-label fa-section-label--light">02 / Foundation &amp; Development</p>
            <div class="fa-section-heading fa-section-heading--inverse">
                <div>
                    <p class="fa-eyebrow fa-eyebrow--accent">The academy program structure</p>
                    <h2 id="programs-title">Two programs.<br>Different levels of <em>support.</em></h2>
                </div>
                <p>Program placement follows the Initial Assessment. Lesson length is recommended according to age, level, goals and readiness.</p>
            </div>
            <div class="fa-program-grid" data-analytics-view="program_compare_view" data-analytics-page-type="home">
                <article class="fa-program">
                    <div class="fa-program__meta"><span>Program / I</span><span><?= e($programs['foundation']['frequency']) ?></span></div>
                    <h3>Foundation</h3>
                    <p class="fa-program__description"><?= e($programs['foundation']['best_for']) ?></p>
                    <p class="fa-program__benefit"><strong>Main benefit</strong><?= e($programs['foundation']['benefit']) ?></p>
                    <ul>
                        <li>Individual term plan</li>
                        <li>Weekly practice diary</li>
                        <li>Studio recital participation</li>
                        <li>Limited support outside lesson hours</li>
                    </ul>
                    <a href="/initial-assessment#book">Begin with assessment <span aria-hidden="true">&rarr;</span></a>
                </article>
                <article class="fa-program fa-program--featured">
                    <span class="fa-program__recommended">Recommended</span>
                    <div class="fa-program__meta"><span>Program / II</span><span><?= e($programs['development']['frequency']) ?></span></div>
                    <h3>Development</h3>
                    <p class="fa-program__description"><?= e($programs['development']['best_for']) ?></p>
                    <p class="fa-program__benefit"><strong>Main benefit</strong><?= e($programs['development']['benefit']) ?></p>
                    <ul>
                        <li>Everything in Foundation</li>
                        <li>Monthly progress reports</li>
                        <li>Mock exams and readiness checks</li>
                        <li>AMEB enrolment and exam fees covered</li>
                        <li>Outside-lesson support by arrangement</li>
                    </ul>
                    <a href="/initial-assessment#book">Begin with assessment <span aria-hidden="true">&rarr;</span></a>
                </article>
            </div>
            <div class="fa-assessment-note">
                <div><span>Initial Assessment</span><strong><?= e(money($pricing['assessment'])) ?></strong></div>
                <p>Start with a <?= e(money($pricing['assessment'])) ?> Initial Assessment. You do not need to choose a program first. A recommended pathway and lesson length are provided afterwards.</p>
                <a href="/programs">Compare programs <span aria-hidden="true">&nearr;</span></a>
            </div>
        </div>
    </section>

    <section class="fa-section fa-results" id="results" aria-labelledby="results-title">
        <div class="editorial-inner">
            <p class="fa-section-label">03 / Results</p>
            <div class="fa-section-heading">
                <div>
                    <p class="fa-eyebrow">Progress made visible</p>
                    <h2 id="results-title">Clarity, consistency and musical <em>growth.</em></h2>
                </div>
                <p>Results include examination progression, stronger practice, growing independence and confidence in performance.</p>
            </div>
            <div class="fa-results-layout">
                <figure class="fa-results-photo fa-iridescent-frame">
                    <?php render_responsive_picture([
                        'base' => '/images/responsive/recital-group',
                        'widths' => [480, 768, 1200],
                        'fallback_width' => 1200,
                        'width' => 1280,
                        'height' => 853,
                        'alt' => 'Fortepiano Academy recital students holding their certificates',
                        'sizes' => '(max-width: 760px) calc(100vw - 36px), 56vw',
                    ]); ?>
                    <figcaption>Fortepiano Academy recital &middot; certificates and performance</figcaption>
                </figure>
                <div class="fa-result-stories">
                    <article><span>Grade progression</span><h3>Angus</h3><p>A long-term pathway from early lessons through the completion of Grade 8.</p></article>
                    <article><span>Two grades &middot; one year</span><h3>Jennifer &amp; Jacob</h3><p>From beginner foundations to two completed grades by the end of 2025.</p></article>
                    <article><span>Exam + recital</span><h3>Jennie</h3><p>Preliminary exam success followed by confident participation in the 2025 recital.</p></article>
                </div>
            </div>
            <div class="fa-inline-link"><a href="/results">Read the full student stories <span aria-hidden="true">&rarr;</span></a></div>
        </div>
    </section>

    <section class="fa-section fa-faculty" id="faculty" aria-labelledby="faculty-title">
        <div class="editorial-inner">
            <p class="fa-section-label fa-section-label--light">04 / Piano Faculty</p>
            <div class="fa-section-heading fa-section-heading--inverse">
                <div>
                    <p class="fa-eyebrow fa-eyebrow--accent">Shared teaching standards</p>
                    <h2 id="faculty-title">Individual teachers.<br>One academy <em>standard.</em></h2>
                </div>
                <p>Fortepiano Academy is expanding its faculty deliberately. As the school grows, teachers are selected, inducted and supported within the academy's teaching and reporting standards.</p>
            </div>
            <div class="fa-faculty-layout">
                <article class="fa-faculty-profile">
                    <figure>
                        <?php render_responsive_picture([
                            'base' => '/images/responsive/faculty-recital',
                            'widths' => [480, 768],
                            'fallback_width' => 768,
                            'width' => 853,
                            'height' => 1280,
                            'alt' => 'Liana Pavlicheva with student Jennie at a Fortepiano Academy recital',
                            'sizes' => '(max-width: 760px) calc(100vw - 36px), 34vw',
                        ]); ?>
                    </figure>
                    <div><span>Founder &amp; Head Teacher</span><h3>Liana Pavlicheva</h3><p>Liana leads student placement, term planning and academy standards alongside her teaching work.</p><a href="/faculty">Meet the faculty <span aria-hidden="true">&rarr;</span></a></div>
                </article>
                <div class="fa-faculty-standards">
                    <article><span>01</span><div><h3>Selection</h3><p>Teaching experience, musicianship, judgement and communication with students and families.</p></div></article>
                    <article><span>02</span><div><h3>Supervised induction</h3><p>Observation of academy lessons followed by supported teaching before independent allocation.</p></div></article>
                    <article><span>03</span><div><h3>Ongoing oversight</h3><p>Term plans, progress records, examinations and student concerns remain within one academy system.</p></div></article>
                </div>
            </div>
        </div>
    </section>

    <section class="fa-section fa-locations" id="lesson-locations" aria-labelledby="locations-title">
        <div class="editorial-inner">
            <p class="fa-section-label">05 / Lesson Settings</p>
            <div class="fa-location-layout">
                <figure class="fa-location-photo">
                    <?php render_responsive_picture([
                        'base' => '/images/responsive/practice-diaries',
                        'widths' => [480, 768, 1200, 1600],
                        'fallback_width' => 1200,
                        'width' => 4032,
                        'height' => 3024,
                        'alt' => 'Fortepiano Academy students holding their practice diaries in the studio',
                        'sizes' => '(max-width: 760px) calc(100vw - 36px), 46vw',
                    ]); ?>
                    <figcaption>Practice diaries make weekly direction visible.</figcaption>
                </figure>
                <div>
                    <p class="fa-eyebrow">Sydney lessons, one academy structure</p>
                    <h2 id="locations-title">At the studio or on the student's own piano.</h2>
                    <div class="fa-location-pair">
                        <article><span>Studio / 2127</span><h3>Wentworth Point</h3><p>A focused studio environment with the piano and teaching setup ready for each session.</p><a href="/piano-lessons-wentworth-point">Studio details</a></article>
                        <article><span>Selected suburbs</span><h3>Lessons at home</h3><p>At-home lessons are subject to teacher and travel availability. Fees start from <?= e(money(HOME_LESSON_TRAVEL_FEE)) ?> per visit for the return journey from Wentworth Point.</p><a href="/contact">Request a travel quote</a></article>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="fa-section fa-testimonials" aria-labelledby="testimonials-title">
        <div class="editorial-inner">
            <p class="fa-section-label">06 / Family Perspectives</p>
            <h2 id="testimonials-title">What families notice after starting.</h2>
            <div class="fa-testimonial-grid">
                <?php foreach ($reviews as $review): ?>
                    <blockquote>
                        <p>&ldquo;<?= e($review['text']) ?>&rdquo;</p>
                        <footer class="fa-testimonial__meta">
                            <cite><?= e($review['name']) ?> &middot; Google review</cite>
                            <a href="<?= e($review['url']) ?>" target="_blank" rel="noopener">Read this review <span aria-hidden="true">&nearr;</span></a>
                        </footer>
                    </blockquote>
                <?php endforeach; ?>
            </div>
            <a class="fa-text-link" href="<?= e(GOOGLE_REVIEWS_PAGE_URL) ?>" target="_blank" rel="noopener">Read all Google reviews <span aria-hidden="true">&nearr;</span></a>
        </div>
    </section>

    <section class="fa-section fa-admissions" id="admissions" aria-labelledby="admissions-title">
        <div class="editorial-inner fa-admissions__grid">
            <p class="fa-section-label">07 / Admissions</p>
            <div class="fa-admissions__copy">
                <p class="fa-eyebrow">Begin with clarity</p>
                <h2 id="admissions-title">Initial Piano<br><em>Assessment.</em></h2>
                <p>The assessment is a 30-minute combined trial lesson and placement session. It identifies current level, readiness, learning needs, goals and the right starting program.</p>
            </div>
            <div class="fa-admissions-card fa-iridescent-frame">
                <div class="fa-admissions-price"><span>Initial Assessment</span><strong><?= e(money($pricing['assessment'])) ?></strong><small>30 minutes</small></div>
                <ul>
                    <li>Wentworth Point studio or at home</li>
                    <li>Program and lesson-length recommendation</li>
                    <li>Next-step outline within 24 hours</li>
                    <li><?= e(money($pricing['setup'])) ?> Program Setup only if continuing</li>
                    <li>At-home travel from <?= e(money(HOME_LESSON_TRAVEL_FEE)) ?> per visit</li>
                </ul>
                <a class="fa-button fa-button--light" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'home', 'cta_position' => 'admissions', 'cta_label' => 'Request an Assessment']) ?>>Request an Assessment <span aria-hidden="true">&rarr;</span></a>
            </div>
            <div class="fa-faq-list">
                <?php foreach ($homeFaqs as $faq): ?>
                    <details>
                        <summary><?= e($faq['q']) ?><span aria-hidden="true">+</span></summary>
                        <p><?= e($faq['a']) ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<?php render_footer(); ?>
