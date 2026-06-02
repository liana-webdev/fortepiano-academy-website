<?php
require_once __DIR__ . '/includes/layout.php';
$page = [
    'path' => '/teacher',
    'title' => 'Principal Piano Teacher | Liana | Fortepiano Academy',
    'description' => 'Meet Liana, founder and principal piano teacher of Fortepiano Academy in Wentworth Point. Russian-trained teaching with AMEB-aligned structure.',
    'image' => '/img/Liana little at one of her performances.jpeg',
    'og_type' => 'profile',
    'schema' => [
        business_schema(),
        [
            '@context' => 'https://schema.org',
            '@type' => 'ProfilePage',
            'mainEntity' => [
                '@type' => 'Person',
                'name' => 'Liana',
                'jobTitle' => 'Founder and Principal Piano Teacher',
                'worksFor' => ['@id' => SITE_URL . '/#business'],
            ],
        ],
        breadcrumb_schema([['label' => 'Home', 'href' => '/'], ['label' => 'Teacher', 'href' => '/teacher']]),
    ],
];
render_head($page);
render_header('/teacher');
?>
<main>
    <section class="section blog-hero">
        <div class="section__content container">
            <?php render_breadcrumb([['label' => 'Home', 'href' => '/'], ['label' => 'Teacher', 'href' => '/teacher']]); ?>
            <div class="grid grid--2 grid--gap-xl align-center">
                <div class="stack gap-m">
                    <p class="article-meta">Principal Teacher</p>
                    <h1>Meet Liana</h1>
                    <p class="lead">Russian-trained piano teacher in Wentworth Point.</p>
                    <p>Liana is the founder and principal teacher of Fortepiano Academy. Her teaching combines disciplined musical foundations, AMEB-aligned structure, individual attention and a calm professional environment.</p>
                    <div class="actions">
                        <a class="btn btn--primary" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'teacher', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment with Liana']) ?>>Book Initial Assessment with Liana</a>
                        <a class="btn btn--ghost" href="/programs">View Programs</a>
                    </div>
                </div>
                <figure class="blog-hero__media card card--glass">
                    <img src="/img/Liana little at one of her performances.jpeg" alt="Liana during an early piano performance" loading="eager">
                </figure>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--3 grid--gap-l">
            <article class="card"><h2>Training and background</h2><p>Liana completed a full Russian music-school pathway in Moscow, including piano, performance, solfeggio, music literature and choir.</p></article>
            <article class="card"><h2>Teaching philosophy</h2><p>Lessons are structured, warm and serious about progress. Students build technique, listening, reading, rhythm and confidence through consistent work.</p></article>
            <article class="card"><h2>AMEB preparation</h2><p>Exam preparation is available where it supports the student goals, readiness and long-term musical development.</p></article>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--2 grid--gap-xl align-center">
            <figure class="card card--glass"><img src="/images/ameb-piano-certificates.jpg" alt="AMEB piano certificates" loading="lazy"></figure>
            <div class="stack gap-s">
                <h2>Capable, stable, structured and safe</h2>
                <p>Families choose Fortepiano Academy when they want a teacher who can guide children carefully, communicate clearly, and maintain high standards without making lessons cold.</p>
                <ul class="tick-list">
                    <li>WWCC and child-safe professionalism</li>
                    <li>Russian music-school foundation</li>
                    <li>Experience with AMEB-aligned progress</li>
                    <li>Languages and parent communication support</li>
                    <li>Student outcomes, recitals and long-term stories</li>
                </ul>
            </div>
        </div>
    </section>
    <?php render_cta_band('Meet Liana through the first assessment', 'The Initial Assessment gives your child a real teaching session and gives Liana the information needed to recommend a pathway.', 'Book Initial Assessment with Liana', '/initial-assessment#book', 'View Results', '/results', 'teacher'); ?>
</main>
<?php render_footer(); ?>
