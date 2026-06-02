<?php
require_once __DIR__ . '/includes/layout.php';
$page = [
    'path' => '/results',
    'title' => 'Piano Student Results | Fortepiano Academy',
    'description' => 'Student stories, recital moments, parent quotes and progress examples from Fortepiano Academy in Wentworth Point.',
    'image' => '/img/recital group photo with certificates.JPG',
    'schema' => [business_schema(), breadcrumb_schema([['label' => 'Home', 'href' => '/'], ['label' => 'Results', 'href' => '/results']])],
];
render_head($page);
render_header('/results');
?>
<main>
    <section class="section blog-hero">
        <div class="section__content container">
            <?php render_breadcrumb([['label' => 'Home', 'href' => '/'], ['label' => 'Results', 'href' => '/results']]); ?>
            <div class="grid grid--2 grid--gap-xl align-center">
                <div class="stack gap-m">
                    <p class="article-meta">Student proof</p>
                    <h1>Results shaped by clarity, consistency and structured growth</h1>
                    <p class="lead">At Fortepiano Academy, results mean more than trophies. They show focus, confidence, musical understanding, recital readiness and steady progress.</p>
                    <div class="actions">
                        <a class="btn btn--primary" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'results', 'cta_position' => 'hero', 'cta_label' => 'Book Initial Assessment']) ?>>Book Initial Assessment</a>
                        <a class="btn btn--ghost" href="/programs">View Programs</a>
                    </div>
                </div>
                <figure class="blog-hero__media card card--glass"><img src="/img/recital group photo with certificates.JPG" alt="Fortepiano Academy recital group with certificates" loading="eager"></figure>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section__content container grid grid--3 grid--gap-l">
            <article class="card"><h2>Exam progression</h2><p>Students working toward AMEB grades are supported with milestones, mock preparation and technical foundations.</p></article>
            <article class="card"><h2>Recital performance</h2><p>Performance culture helps students practise focus, confidence and musical communication in a real setting.</p></article>
            <article class="card"><h2>Before and after progress</h2><p>Parents often notice stronger attention, more purposeful practice and clearer understanding before harder pieces arrive.</p></article>
        </div>
    </section>
    <section class="section">
        <div class="section__content container">
            <header class="section__header center"><h2>Student stories and parent quotes</h2></header>
            <div class="grid grid--2 grid--gap-l">
                <article class="card story-card"><h3>The Ta Brothers</h3><p>Long-term structured learning helped three brothers grow through technique, confidence, performance and understanding.</p></article>
                <article class="card story-card"><h3>Jennifer and Jacob</h3><p>Consistent teaching supported excellence, timing and stronger musical discipline.</p></article>
                <article class="card review-card"><h3>Professionalism and structure</h3><p class="muted">Parent reviews consistently mention patience, progress, professionalism and a supportive learning environment.</p></article>
                <article class="card review-card"><h3>Performance confidence</h3><p class="muted">Recital moments show students learning to present music with focus, joy and control.</p></article>
            </div>
        </div>
    </section>
    <section class="section"><div class="section__content container"><div class="ribbon"><div class="ribbon__track"><figure class="ribbon__item card card--flat"><img src="/img/recital teacher and jennie.JPG" alt="Recital with student Jennie" loading="lazy"></figure><figure class="ribbon__item card card--flat"><img src="/img/recital teacher and amin.JPG" alt="Recital with student Amin" loading="lazy"></figure><figure class="ribbon__item card card--flat"><img src="/img/kids holding cert.JPG" alt="Students holding certificates" loading="lazy"></figure></div></div></div></section>
    <?php render_cta_band('Start building visible progress', 'The first step is an assessment that places your child into the right structure.', 'Book Initial Assessment', '/initial-assessment#book', 'View Programs', '/programs', 'results'); ?>
</main>
<?php render_footer(); ?>
