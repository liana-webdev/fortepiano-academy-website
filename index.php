<?php
require_once __DIR__ . '/includes/layout.php';
global $pricing;

$page = [
    'path' => '/',
    'title' => 'Structured Piano Lessons at the Studio or Your Home | Fortepiano Academy',
    'description' => 'Structured one-to-one piano lessons at the Wentworth Point studio or in your home across selected surrounding suburbs.',
    'image' => '/img/DSC04361.jpg',
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
$faqs = [
    ['q' => 'What age can my child start?', 'a' => 'Most students begin from around age four, or when they are ready to focus, follow directions and coordinate comfortably.'],
    ['q' => 'Do students prepare for AMEB exams?', 'a' => 'Yes. AMEB-aligned preparation is available where it suits the student goals and readiness.'],
    ['q' => 'How do we begin?', 'a' => 'Start with the Initial Assessment so the right program and lesson length can be recommended.'],
    ['q' => 'Where are lessons taught?', 'a' => 'Choose lessons at the Wentworth Point studio or at your home in a listed surrounding suburb, subject to availability.'],
    ['q' => 'How much do at-home lessons cost?', 'a' => 'At-home lessons include a travel fee starting from $15 per visit, including the Initial Assessment. The exact fee is based on the return journey from Wentworth Point and is confirmed before booking.'],
];
render_head($page);
render_header('/');
?>
<main>
    <section class="section hero">
        <div class="section__content container">
            <div class="grid grid--2 grid--gap-xl align-center">
                <div class="stack gap-m">
                    <p class="article-meta">Studio and at-home piano lessons</p>
                    <h1 class="hero__title">Structured piano lessons at the studio or in the comfort of your home</h1>
                    <p class="lead">Fortepiano Academy offers one-to-one piano lessons at the Wentworth Point studio and at students' homes across selected surrounding suburbs.</p>
                    <div class="actions">
                        <a class="btn btn--primary" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'home', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment']) ?>>Book Initial Assessment</a>
                        <a class="btn btn--ghost" href="/programs">View Programs</a>
                    </div>
                    <div class="badges">
                        <span class="badge">AMEB-aligned</span>
                        <span class="badge">Practice diaries</span>
                        <span class="badge">Progress reports</span>
                        <span class="badge">At-home lessons available</span>
                        <span class="badge">WWCC professional</span>
                        <a class="badge badge--link" href="<?= e(GOOGLE_REVIEW_URL) ?>" target="_blank" rel="noopener">5.0 Google rating</a>
                    </div>
                </div>
                <figure class="hero__media card card--glass">
                    <img src="/img/DSC04361.jpg" alt="Teacher and student at the piano" loading="eager" decoding="async">
                </figure>
            </div>
        </div>
    </section>

    <section class="section section--compact">
        <div class="section__content container">
            <div class="proof-strip">
                <span>Structured programs</span>
                <span>Russian training influence</span>
                <span>AMEB pathway</span>
                <span>Recital culture</span>
                <span>Studio or at-home lessons</span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container">
            <header class="section__header stack gap-xs center">
                <p class="article-meta">Choose your lesson location</p>
                <h2>The same structured teaching, at the studio or your home</h2>
                <p class="muted">Home visits are available across listed surrounding suburbs, subject to schedule and travel availability.</p>
            </header>
            <div class="grid grid--2 grid--gap-l">
                <article class="card card--glass">
                    <h3>Wentworth Point studio</h3>
                    <p>Attend lessons in a focused studio environment with the piano and teaching setup ready for each session.</p>
                </article>
                <article class="card card--glass">
                    <h3>Lessons at your home</h3>
                    <p>Liana travels to your home and teaches on your piano. Travel fees start from <?= e(money(HOME_LESSON_TRAVEL_FEE)) ?> per visit and are quoted for the return journey from Wentworth Point.</p>
                    <p class="muted">A suitable piano, the student's own books, a quiet lesson space and timely access to the home are required.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container">
            <div class="grid grid--2 grid--gap-xl align-center">
                <div class="stack gap-s">
                    <p class="article-meta">The problem</p>
                    <h2>Most students do not lack talent. They lack structure.</h2>
                    <p>Students progress when lessons connect posture, rhythm, reading, technique, repertoire and practice into one clear pathway. Families are not left guessing what happens next.</p>
                </div>
                <div class="grid grid--2 grid--gap-l">
                    <article class="card card--glass"><h3>Term Plans</h3><p class="muted">Learning is organised around term goals, not random lesson-to-lesson activity.</p></article>
                    <article class="card card--glass"><h3>Diaries & Reports</h3><p class="muted">Practice and feedback are made visible for parents and students.</p></article>
                    <article class="card card--glass"><h3>Exam Pathways</h3><p class="muted">AMEB preparation is available where the student is ready and suited.</p></article>
                    <article class="card card--glass"><h3>Performances</h3><p class="muted">Recital opportunities support confidence, focus and musical growth.</p></article>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container">
            <header class="section__header stack gap-xs center">
                <p class="article-meta">Programs</p>
                <h2>Programs designed for real progress</h2>
                <p class="muted">Students begin with an Initial Assessment and are placed into the pathway that best suits their goals, lesson length and readiness.</p>
            </header>
            <div class="grid grid--2 grid--gap-l">
                <article class="card card--glass program-card">
                    <h3>Foundation</h3>
                    <p>A steady entry pathway for families seeking consistent weekly learning.</p>
                    <p class="muted">From <?= e(money($pricing['foundation'][0]['price'])) ?>/month.</p>
                    <a class="btn btn--ghost" href="/programs">View Foundation</a>
                </article>
                <article class="card card--glass program-card program-card--recommended">
                    <span class="program-reco">Recommended</span>
                    <h3>Development</h3>
                    <p>The core structured pathway for stronger progress, accountability and AMEB readiness.</p>
                    <p class="muted">From <?= e(money($pricing['development'][0]['price'])) ?>/month.</p>
                    <a class="btn btn--primary" href="/programs">View Development</a>
                </article>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container">
            <div class="grid grid--2 grid--gap-xl align-center">
                <div class="stack gap-s">
                    <p class="article-meta">Pricing snapshot</p>
                    <h2>A clear first step before program placement</h2>
                    <p>Initial Assessment is <?= e(money($pricing['assessment'])) ?>. Program Setup is <?= e(money($pricing['setup'])) ?> only if continuing. At-home visits include a travel fee starting from <?= e(money(HOME_LESSON_TRAVEL_FEE)) ?> per visit.</p>
                    <div class="actions">
                        <a class="btn btn--primary" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'home', 'cta_position' => 'pricing_snapshot', 'cta_label' => 'Book Initial Assessment']) ?>>Book Initial Assessment</a>
                        <a class="btn btn--ghost" href="/pricing"<?= tracking_attrs('view_pricing', ['page_type' => 'home']) ?>>See Pricing</a>
                    </div>
                </div>
                <figure class="card card--glass">
                    <img src="/img/students sitting at studio holding diaries old.JPG" alt="Students holding practice diaries at Fortepiano Academy" loading="lazy">
                </figure>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container">
            <header class="section__header stack gap-xs center">
                <p class="article-meta">Proof</p>
                <h2>Results parents can recognise</h2>
                <p class="muted">Families usually notice better focus, more purposeful practice and stronger musical understanding before they notice harder pieces.</p>
            </header>
            <div class="grid grid--3 grid--gap-l">
                <article class="card review-card"><h3>Exam progression</h3><p class="muted">Structured preparation supports students working toward graded AMEB progress.</p></article>
                <article class="card review-card"><h3>Student stories</h3><p class="muted">Long-term progress is shown through confidence, consistency and performance readiness.</p></article>
                <article class="card review-card"><h3>Parent trust</h3><p class="muted">Visible reviews and recital moments give families a clearer picture of the academy.</p></article>
            </div>
            <div class="actions center pad-top-m">
                <a class="btn btn--primary" href="/results">View Results</a>
                <a class="btn btn--ghost" href="/teacher">Meet Liana</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container">
            <div class="grid grid--2 grid--gap-xl align-center">
                <figure class="card card--glass">
                    <img src="/img/Liana little at one of her performances.jpeg" alt="Liana during an early piano performance" loading="lazy">
                </figure>
                <div class="stack gap-s">
                    <p class="article-meta">Principal teacher</p>
                    <h2>Structured teaching with warmth and high standards</h2>
                    <p>Liana brings Russian music-school training, AMEB experience and years of Fortepiano Academy teaching into a serious, safe and steady learning environment.</p>
                    <a class="btn btn--ghost" href="/teacher">Meet Liana</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container">
            <header class="section__header stack gap-xs center">
                <p class="article-meta">FAQ</p>
                <h2>Common questions</h2>
            </header>
            <?php render_faqs($faqs); ?>
        </div>
    </section>

    <?php render_cta_band('Start with a clear assessment', 'Book an Initial Assessment and receive a recommended pathway for your child.', 'Book Initial Assessment', '/initial-assessment#book', 'View Programs', '/programs', 'home'); ?>
</main>
<?php render_footer(); ?>
