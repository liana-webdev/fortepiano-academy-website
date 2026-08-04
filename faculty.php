<?php
require_once __DIR__ . '/includes/layout.php';

$page = [
    'path' => '/faculty',
    'title' => 'Piano Faculty | Fortepiano Academy',
    'description' => 'Meet the Fortepiano Academy piano faculty and learn how teacher selection, induction, planning and oversight support one academy standard.',
    'image' => '/img/recital%20teacher%20and%20jennie.JPG',
    'og_type' => 'profile',
    'schema' => [
        business_schema(),
        [
            '@context' => 'https://schema.org',
            '@type' => 'ProfilePage',
            'mainEntity' => [
                '@type' => 'Person',
                'name' => 'Liana Pavlicheva',
                'jobTitle' => 'Founder and Head Teacher',
                'worksFor' => ['@id' => SITE_URL . '/#business'],
            ],
        ],
        breadcrumb_schema([['label' => 'Home', 'href' => '/'], ['label' => 'Faculty', 'href' => '/faculty']]),
    ],
];

render_head($page);
render_header('/faculty');
?>
<main>
    <section class="section blog-hero">
        <div class="section__content container">
            <?php render_breadcrumb([['label' => 'Home', 'href' => '/'], ['label' => 'Faculty', 'href' => '/faculty']]); ?>
            <div class="grid grid--2 grid--gap-xl align-center">
                <div class="stack gap-m">
                    <p class="article-meta">Piano Faculty</p>
                    <h1>Individual teachers. One academy standard.</h1>
                    <p class="lead">Fortepiano Academy is becoming a formal piano school with a deliberately developed faculty, shared planning and consistent reporting standards.</p>
                    <p>Only approved, named teachers are published here. As the faculty grows, teachers are selected, inducted and supported before independent student allocation.</p>
                    <div class="actions">
                        <a class="btn btn--primary" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'faculty', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment']) ?>>Book Initial Assessment</a>
                        <a class="btn btn--ghost" href="/programs">View Programs</a>
                    </div>
                </div>
                <figure class="blog-hero__media card card--glass">
                    <?php render_responsive_picture([
                        'base' => '/images/responsive/faculty-recital',
                        'widths' => [480, 768],
                        'fallback_width' => 768,
                        'width' => 853,
                        'height' => 1280,
                        'alt' => 'Liana Pavlicheva with student Jennie at a Fortepiano Academy recital',
                        'sizes' => '(max-width: 760px) calc(100vw - 36px), 42vw',
                        'loading' => 'eager',
                        'fetchpriority' => 'high',
                    ]); ?>
                </figure>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container">
            <header class="section__header stack gap-xs">
                <p class="article-meta">Current faculty</p>
                <h2>Liana Pavlicheva</h2>
                <p class="lead">Founder &amp; Head Teacher</p>
            </header>
            <div class="grid grid--3 grid--gap-l">
                <article class="card"><h3>Training and background</h3><p>Liana completed a full Russian music-school pathway in Moscow, including piano, performance, solfeggio, music literature and choir.</p></article>
                <article class="card"><h3>Teaching approach</h3><p>Lessons are structured, warm and serious about progress, whether taught at the Wentworth Point studio or on the student's piano at home.</p></article>
                <article class="card"><h3>Academy leadership</h3><p>Liana leads assessment, student placement, term planning and the development of shared teaching and reporting standards.</p></article>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container">
            <header class="section__header stack gap-xs">
                <p class="article-meta">Faculty standards</p>
                <h2>How the academy is building its teaching team</h2>
            </header>
            <div class="grid grid--3 grid--gap-l">
                <article class="card"><h3>01 / Selection</h3><p>Teaching experience, musicianship, judgement and communication with students and families.</p></article>
                <article class="card"><h3>02 / Supervised induction</h3><p>Observation of academy lessons followed by supported teaching before independent allocation.</p></article>
                <article class="card"><h3>03 / Ongoing oversight</h3><p>Term plans, progress records, examinations and student concerns remain within one academy system.</p></article>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container grid grid--2 grid--gap-xl align-center">
            <div class="stack gap-s">
                <p class="article-meta">Early piano foundation</p>
                <h2>A formative music-school education</h2>
                <p>Liana grew up inside a serious music-learning environment. Her own training in performance, discipline and musical culture now informs the way she guides students and develops the academy's standards.</p>
            </div>
            <figure class="teacher-memory card card--glass">
                <img src="/img/Liana little at one of her performances.jpeg" alt="Liana as a young pianist during an early performance" width="1280" height="1059" loading="lazy" decoding="async">
                <figcaption>Liana during her own early piano training.</figcaption>
            </figure>
        </div>
    </section>

    <section class="section faculty-proof-section">
        <div class="section__content container grid grid--2 faculty-proof-grid align-center">
            <figure class="card card--glass faculty-proof__media"><img src="/images/ameb-piano-certificates.jpg" alt="Piano certificates held by Fortepiano Academy students" width="3855" height="3024" loading="lazy" decoding="async"></figure>
            <div class="stack gap-s">
                <p class="article-meta">Professional learning environment</p>
                <h2>Structured, stable and child-safe</h2>
                <p>Families can expect clear communication, individual planning and standards that remain consistent as the academy's faculty grows.</p>
                <ul class="tick-list">
                    <li>WWCC and child-safe professionalism</li>
                    <li>Russian music-school foundation</li>
                    <li>Experience with AMEB-aligned progress</li>
                    <li>Clear parent communication</li>
                    <li>Student outcomes, recitals and long-term stories</li>
                </ul>
            </div>
        </div>
    </section>

    <?php render_cta_band('Begin with the academy assessment', 'The Initial Assessment gives the student a real teaching session and gives the academy the information needed to recommend a pathway.', 'Book Initial Assessment', '/initial-assessment#book', 'View Results', '/results', 'faculty'); ?>
</main>
<?php render_footer(); ?>
