<?php
require_once __DIR__ . '/includes/layout.php';
$page = [
    'path' => '/blog',
    'title' => 'Piano Lessons Blog | Fortepiano Academy Wentworth Point',
    'description' => 'Piano learning advice from Fortepiano Academy in Wentworth Point, including parent guidance and structured lesson resources.',
    'image' => '/images/beginner-piano-lesson.jpg',
    'schema' => [
        business_schema(),
        [
            '@context' => 'https://schema.org',
            '@type' => 'Blog',
            'name' => 'Fortepiano Academy Blog',
            'url' => canonical('/blog'),
            'publisher' => ['@id' => SITE_URL . '/#business'],
        ],
        breadcrumb_schema([['label' => 'Home', 'href' => '/'], ['label' => 'Blog', 'href' => '/blog']]),
    ],
];
render_head($page);
render_header('/blog');
?>
<main>
    <section class="section blog-hero">
        <div class="section__content container">
            <?php render_breadcrumb([['label' => 'Home', 'href' => '/'], ['label' => 'Blog', 'href' => '/blog']]); ?>
            <div class="grid grid--2 grid--gap-xl align-center">
                <div class="stack gap-m">
                    <p class="article-meta">Resources</p>
                    <h1>Piano lesson advice for families</h1>
                    <p class="lead">Practical guidance for parents choosing structured piano lessons, assessment timing and long-term pathways.</p>
                    <div class="actions">
                        <a class="btn btn--primary" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'blog', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment']) ?>>Book Initial Assessment</a>
                        <a class="btn btn--ghost" href="/">Explore Fortepiano Academy</a>
                    </div>
                </div>
                <figure class="blog-hero__media card card--glass"><img src="/images/beginner-piano-lesson.jpg" alt="Young piano student practising during a structured lesson" loading="eager"></figure>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section__content container blog-layout">
            <div class="blog-posts">
                <article class="post-card card card--soft">
                    <p class="article-meta">Beginner piano lessons | Updated 1 May 2026</p>
                    <h2><a href="/blog/best-age-to-start-piano-lessons-kids.html">What Is the Best Age to Start Piano Lessons for Your Child?</a></h2>
                    <p>There is no single perfect birthday for beginning piano. For many children, formal lessons work best when musical interest, attention, coordination and a calm practice routine begin to come together.</p>
                    <a class="text-link" href="/blog/best-age-to-start-piano-lessons-kids.html">Read about the best age to start piano lessons for your child</a>
                </article>
            </div>
            <aside class="blog-sidebar">
                <div class="card card--glass stack gap-s">
                    <h2>Parent guide</h2>
                    <p>A downloadable parent guide is planned for a later release. For now, start with assessment or explore the program structure.</p>
                    <a class="btn btn--primary" href="/initial-assessment#book">Book Initial Assessment</a>
                    <a class="btn btn--ghost" href="/programs">View Programs</a>
                </div>
            </aside>
        </div>
    </section>
</main>
<?php render_footer(); ?>
