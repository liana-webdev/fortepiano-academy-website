<?php
require_once __DIR__ . '/includes/layout.php';
global $pricing;

$page = [
    'path' => '/',
    'title' => 'Piano Lessons in Wentworth Point | Fortepiano Academy',
    'description' => 'Structured piano education in Wentworth Point aligned with AMEB standards, guiding students from early foundations toward confident long-term musical development.',
    'image' => '/img/DSC04361.jpg',
    'body_class' => 'home-page',
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
    ['q' => 'What happens in the Initial Assessment?', 'a' => 'The assessment is a real teaching session that checks level, readiness, learning style, focus, goals and the most suitable starting pathway.'],
    ['q' => 'Do you teach complete beginners?', 'a' => 'Yes. Beginners are welcome when they are ready for one-to-one focus, gentle instruction and regular practice support.'],
    ['q' => 'Do you prepare students for AMEB exams?', 'a' => 'Yes. AMEB-aligned preparation is available where it suits the student goals, level and readiness.'],
    ['q' => 'What is the difference between Foundation and Development?', 'a' => 'Foundation is a steady weekly pathway. Development is the recommended pathway for stronger structure, regular guidance, AMEB preparation and long-term momentum.'],
    ['q' => 'Where are lessons held?', 'a' => 'Lessons are held at the Fortepiano Academy studio in Wentworth Point, serving nearby families from Rhodes, Sydney Olympic Park and surrounding suburbs.'],
];

render_head($page);
render_header('/');
?>
<main class="home-shell">
    <section class="home-hero section">
        <div class="home-hero__veil" aria-hidden="true"></div>
        <div class="section__content container">
            <div class="home-hero__grid">
                <div class="home-hero__copy stack gap-m">
                    <p class="home-label">Structured Piano Education</p>
                    <h1 class="hero__title">A complete pathway for graded piano progress.</h1>
                    <p class="lead">Fortepiano Academy offers structured piano education aligned with AMEB standards, guiding students from early foundations toward confident, long-term musical development.</p>
                    <div class="actions">
                        <a class="btn btn--primary" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'home', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment']) ?>>Book Initial Assessment</a>
                        <a class="btn btn--ghost" href="/programs">Explore Programs</a>
                    </div>
                </div>
                <div class="pathway-visual" aria-label="Visual pathway from first lesson to graded progress">
                    <div class="pathway-visual__staff" aria-hidden="true"></div>
                    <div class="pathway-visual__line" aria-hidden="true"></div>
                    <div class="pathway-visual__steps">
                        <span>Assessment</span>
                        <span>Technique</span>
                        <span>Repertoire</span>
                        <span>AMEB</span>
                    </div>
                    <figure class="pathway-visual__photo">
                        <img src="/img/DSC04361.jpg" alt="Teacher and student at the piano" loading="eager" decoding="async">
                    </figure>
                </div>
            </div>
        </div>
    </section>

    <section class="home-trust section section--compact">
        <div class="section__content container">
            <div class="trust-strip trust-strip--home">
                <span>AMEB-aligned pathway</span>
                <span>Structured programs</span>
                <span>WWCC approved</span>
                <a href="<?= e(GOOGLE_REVIEW_URL) ?>" target="_blank" rel="noopener">5.0 Google rating</a>
                <span>Wentworth Point studio</span>
            </div>
        </div>
    </section>

    <section class="home-problem section">
        <div class="section__content container">
            <div class="home-split">
                <div class="stack gap-s">
                    <p class="home-label">The problem</p>
                    <h2>Most students do not lack talent. They lack structure.</h2>
                    <p>Without clear direction, piano lessons can become inconsistent. Pieces change, practice becomes vague, and progress is difficult for parents to see. Fortepiano Academy is built to give students a clear pathway, steady expectations, and meaningful development over time.</p>
                </div>
                <div class="alignment-visual" aria-hidden="true">
                    <span></span><span></span><span></span><span></span><span></span><span></span>
                </div>
            </div>
        </div>
    </section>

    <section class="home-method section">
        <div class="section__content container">
            <header class="section__header home-section-header">
                <p class="home-label">Method preview</p>
                <h2>A structured method behind every lesson.</h2>
                <p>Lessons are guided by a blend of Russian-inspired technical discipline and AMEB-aligned progression. Students develop reading, rhythm, posture, technique, repertoire, musicianship, and performance confidence through a planned learning system.</p>
            </header>
            <div class="method-system-grid">
                <article class="system-card"><span>01</span><h3>Technique & posture</h3></article>
                <article class="system-card"><span>02</span><h3>Reading & rhythm</h3></article>
                <article class="system-card"><span>03</span><h3>Repertoire development</h3></article>
                <article class="system-card"><span>04</span><h3>Aural & sight reading</h3></article>
                <article class="system-card"><span>05</span><h3>Term planning</h3></article>
                <article class="system-card"><span>06</span><h3>Progress reporting</h3></article>
            </div>
            <div class="actions center pad-top-m">
                <a class="btn btn--primary" href="/programs">Learn About the Method</a>
            </div>
        </div>
    </section>

    <section class="home-programs section">
        <div class="section__content container">
            <header class="section__header home-section-header">
                <p class="home-label">Program preview</p>
                <h2>Two programs. One clear direction.</h2>
            </header>
            <div class="program-pathways">
                <article class="program-pathway">
                    <p class="home-label">Foundation Program</p>
                    <h3>Steady weekly structure</h3>
                    <p>A steady weekly pathway for students with strong home support and consistent independent practice.</p>
                </article>
                <article class="program-pathway program-pathway--core">
                    <span class="program-reco">Recommended</span>
                    <p class="home-label">Development Program</p>
                    <h3>Layered support for momentum</h3>
                    <p>The recommended pathway for students who need stronger structure, regular guidance, AMEB preparation, and long-term momentum.</p>
                </article>
            </div>
            <div class="actions center pad-top-m">
                <a class="btn btn--primary" href="/programs">Compare Programs</a>
                <a class="btn btn--ghost" href="/pricing"<?= tracking_attrs('view_pricing', ['page_type' => 'home']) ?>>View Pricing</a>
            </div>
        </div>
    </section>

    <section class="home-pricing section">
        <div class="section__content container">
            <div class="home-split">
                <div class="stack gap-s">
                    <p class="home-label">Pricing snapshot</p>
                    <h2>Clear starting costs.</h2>
                    <p>Students begin with an Initial Assessment before program placement. This allows lesson length, goals, and the most suitable structure to be recommended properly.</p>
                    <a class="btn btn--primary" href="/pricing"<?= tracking_attrs('view_pricing', ['page_type' => 'home']) ?>>View Full Pricing</a>
                </div>
                <div class="price-snapshot">
                    <div><span>Initial Assessment</span><strong><?= e(money($pricing['assessment'])) ?></strong></div>
                    <div><span>Program Setup</span><strong><?= e(money($pricing['setup'])) ?></strong></div>
                    <div><span>Foundation from</span><strong><?= e(money($pricing['foundation'][0]['price'])) ?>/month</strong></div>
                    <div><span>Development from</span><strong><?= e(money($pricing['development'][0]['price'])) ?>/month</strong></div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-results section">
        <div class="section__content container">
            <header class="section__header home-section-header">
                <p class="home-label">Results preview</p>
                <h2>Progress made visible.</h2>
                <p>Fortepiano Academy tracks growth through structured lessons, exam preparation, recital opportunities, and parent communication, turning progress into something students and families can actually see.</p>
            </header>
            <div class="proof-card-grid">
                <article class="proof-card"><h3>AMEB exam progression</h3><p>Milestones, preparation and readiness are handled through structure.</p></article>
                <article class="proof-card"><h3>Student stories</h3><p>Longer-term growth shows in confidence, focus and musical understanding.</p></article>
                <article class="proof-card"><h3>Recital performance</h3><p>Performance opportunities support discipline, presence and artistry.</p></article>
                <article class="proof-card"><h3>Parent feedback</h3><p>Families can see practice, communication and progress more clearly.</p></article>
            </div>
            <div class="actions center pad-top-m">
                <a class="btn btn--primary" href="/results">View Student Results</a>
            </div>
        </div>
    </section>

    <section class="home-teacher section">
        <div class="section__content container">
            <div class="teacher-preview">
                <figure>
                    <img src="/img/Liana little at one of her performances.jpeg" alt="Liana during an early piano performance" loading="lazy">
                </figure>
                <div class="stack gap-s">
                    <p class="home-label">Teacher preview</p>
                    <h2>Guided by a teacher who values structure and artistry.</h2>
                    <p>Led by Liana, Fortepiano Academy combines disciplined training, thoughtful communication, and a clear educational pathway for students who are ready to build real musical foundations.</p>
                    <a class="btn btn--primary" href="/teacher">Meet Your Teacher</a>
                </div>
            </div>
        </div>
    </section>

    <section class="home-faq section">
        <div class="section__content container">
            <header class="section__header home-section-header">
                <p class="home-label">FAQ preview</p>
                <h2>Questions before the first lesson.</h2>
            </header>
            <?php render_faqs($faqs); ?>
            <div class="actions center pad-top-m">
                <a class="btn btn--ghost" href="/contact">Read More / Contact</a>
            </div>
        </div>
    </section>

    <?php render_cta_band('Start with the right structure.', 'The Initial Assessment helps determine the student level, learning style, goals, and recommended program pathway.', 'Book Initial Assessment', '/initial-assessment#book', 'Ask a Question', '/contact', 'home'); ?>
</main>
<?php render_footer(); ?>
