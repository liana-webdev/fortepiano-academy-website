<?php
require_once __DIR__ . '/includes/layout.php';

$page = [
    'path' => '/results',
    'title' => 'Piano Student Results | Fortepiano Academy',
    'description' => 'Full student stories, recital moments, parent reviews and progress examples from Fortepiano Academy in Wentworth Point.',
    'image' => '/img/recital group photo with certificates.JPG',
    'schema' => [
        business_schema(),
        breadcrumb_schema([
            ['label' => 'Home', 'href' => '/'],
            ['label' => 'Results', 'href' => '/results'],
        ]),
    ],
];

$reviews = [
    ['name' => 'Evasari Hermawan', 'text' => 'We enrolled our 5-year-old two months ago and already see big improvement. Liana uses illustration and explains until he understands. Really recommended.'],
    ['name' => 'Ying Wang', 'text' => 'Patient, professional, and well-structured lessons. Both kids made impressive progress in two months.'],
    ['name' => 'Peter Lam', 'text' => 'Our two children showed accelerated growth in reading, posture, and touch after switching to Fortepiano Academy.'],
    ['name' => 'Jun Yang', 'text' => 'She taught me songs I actually want to play and the right techniques to play like a professional.'],
    ['name' => 'Danielle Eloss', 'text' => 'Professionalism, knowledge and teaching technique. Highly recommend to anyone seeking piano lessons.'],
    ['name' => 'Angus Ta', 'text' => 'Patient, thorough, and flexible. In two years my playing improved across scales and pieces.'],
    ['name' => 'Elizabeth Tuialii', 'text' => 'Wonderful teacher. Very patient and encouraging with my daughter.'],
    ['name' => 'Tanya Do', 'text' => 'Both daughters have learned with Miss Liana for 3+ years. Significant improvement and they love lessons.'],
    ['name' => 'Farzana Sharmeen', 'text' => 'Friendly and skilled tutor with an amazing ability to motivate young learners.'],
    ['name' => 'Milton Mukando', 'text' => 'Detailed, simplified program; very patient and flexible. Kids were very happy with each session.'],
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
                <figure class="blog-hero__media card card--glass">
                    <img src="/img/recital group photo with certificates.JPG" alt="Fortepiano Academy recital group with certificates" loading="eager">
                </figure>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container grid grid--3 grid--gap-l">
            <article class="card">
                <h2>Exam progression</h2>
                <p>Students working toward AMEB grades are supported with milestones, mock preparation and technical foundations.</p>
            </article>
            <article class="card">
                <h2>Recital performance</h2>
                <p>Performance culture helps students practise focus, confidence and musical communication in a real setting.</p>
            </article>
            <article class="card">
                <h2>Before and after progress</h2>
                <p>Parents often notice stronger attention, more purposeful practice and clearer understanding before harder pieces arrive.</p>
            </article>
        </div>
    </section>

    <section class="section">
        <div class="section__content container">
            <header class="section__header stack gap-xs center">
                <p class="article-meta">Full student stories</p>
                <h2>Student Success Stories</h2>
                <p class="tagline">Achievements shaped by clarity, consistency and structured growth.</p>
            </header>

            <div class="success-grid">
                <details class="card story-card story-card--brothers" open>
                    <summary class="story-card__summary">
                        <span class="story-card__title">The Three Pianist Brothers</span>
                        <span class="story-card__tag">A family journey through AMEB grades with focus and musical maturity.</span>
                    </summary>
                    <div class="story-card__body">
                        <div class="story-card__group">
                            <img class="story-card__image" src="/img/Angus.png" alt="Angus" loading="lazy">
                            <h3>Angus</h3>
                            <p>Angus, the eldest, represents what steady dedication looks like over time. From his early lessons to completing Grade 8, his journey is defined by consistency: not rushed, not forced, but carefully built through years of disciplined work.</p>
                            <p>Throughout his time at the academy, Angus developed a strong technical foundation, from scales to advanced repertoire, refining his playing with each lesson. His progress was shaped not only by repetition, but by understanding: learning to break down challenges, work through them patiently, and truly grasp what he was playing.</p>
                            <p>With a sharp ear and attention to detail, mistakes were never left to settle into habit. They were noticed, addressed, and refined immediately, allowing his playing to remain clean, controlled, and intentional. Over time, this developed into a deeper awareness of expression, emotion, and meaning behind the music.</p>
                        </div>
                        <div class="story-card__group">
                            <img class="story-card__image" src="/img/Jonas.png" alt="Jonas" loading="lazy">
                            <h3>Jonas</h3>
                            <p>Jonas began from Grade 2 and steadily revealed a strong sense of purpose. With each step forward, he patiently gained clarity and confidence through regular practice, leading to excellent performances in his Grade 4 and Grade 5 exams.</p>
                            <p>His journey reflects a powerful transition from humble beginnings into a pianist who performs with assurance and understanding.</p>
                        </div>
                        <div class="story-card__group">
                            <img class="story-card__image" src="/img/Jarick.png" alt="Jarick" loading="lazy">
                            <h3>Jarick</h3>
                            <p>Jarick, the youngest, entered with a spark that could not be ignored. Skipping the typical beginner stages, he moved swiftly through the early levels, acing both his Preliminary and Grade 1 exams.</p>
                            <p>His progress carries a sense of natural curiosity and fearlessness, as if he stepped into music already eager to explore it fully.</p>
                        </div>
                        <div class="story-card__group">
                            <h3>Together</h3>
                            <p>Together, the three brothers form something more than individual stories. As a family, they inspire and challenge one another, growing side by side through the AMEB grades while still holding onto the joy of learning and playing.</p>
                        </div>
                    </div>
                </details>

                <details class="card story-card" open>
                    <summary class="story-card__summary">
                        <span class="story-card__title">Jennifer and Jacob - excellence and timing</span>
                        <span class="story-card__tag">A structured pathway from beginner lessons to exam readiness.</span>
                    </summary>
                    <div class="story-card__body">
                        <div class="story-card__image-row">
                            <img class="story-card__image" src="/img/Jennifer and Jacob.png" alt="Jennifer and Jacob" loading="lazy">
                        </div>
                        <p>Jennifer and Jacob came into lessons at a beginner level, but from the very beginning there was something different: a serious focus that appeared almost immediately.</p>
                        <p>Active lessons began in mid-2024, steadily transitioning them from their previous program into a more structured approach. Once that foundation was set, the direction became clear: mid-2025 exams.</p>
                        <p>What makes their journey stand out is not just the result, but the timing. Even before completing their first exams, they were already preparing for Grade 1, moving forward without hesitation. They successfully passed all components and transitioned comfortably into the next level, already carrying a strong foundation with them.</p>
                        <p>By the end of 2025, they had completed two full grades within a single year and were already preparing for Grade 2, stepping into 2026 with the same head start and the same discipline.</p>
                        <p>This is exactly what a structured approach is meant to do: not rushed learning, not last-minute preparation, but early direction, consistent work, and clear progression. The Wang family stands as a strong example of this mindset.</p>
                        <p>Their commitment to attendance, homework, and long-term goals reflects the kind of partnership that allows real progress to happen.</p>
                        <p class="story-card__quote">"...my kids receive the attention and encouragement they need. The progress they have made in just two months has been impressive, and their enthusiasm for piano has only grown." - Ying</p>
                    </div>
                </details>

                <details class="card story-card" open>
                    <summary class="story-card__summary">
                        <span class="story-card__title">Jennie - joy and passionate playing</span>
                        <span class="story-card__tag">A fast-growing student with stage confidence and musical curiosity.</span>
                    </summary>
                    <div class="story-card__body">
                        <img class="story-card__image" src="/img/Jennie.png" alt="Jennie" loading="lazy">
                        <p class="story-card__quote">"We have seen her not only achieve new heights but also get inspired by this experience." - Jennie's father</p>
                        <p>Jennie joined Fortepiano Academy in mid-2025, transitioning from previous lessons with a clear need to rebuild and refine her fundamentals.</p>
                        <p>In a short time, she developed stronger technique and a much clearer understanding of piano, transforming the way she approaches her playing.</p>
                        <p>By the end of 2025, she proudly aced her Preliminary exam and brought her energy to the stage at the Fortepiano Academy 2025 recital, where she also took on the role of MC. This reflected both her confidence and her presence.</p>
                        <p>Jennie carries a rare balance: enthusiastic and supportive, yet also focused and intelligent in her studies. Her playing has both heart and direction, which makes her growth especially exciting to watch.</p>
                    </div>
                </details>

                <details class="card story-card" open>
                    <summary class="story-card__summary">
                        <span class="story-card__title">Amin - graceful academic excellence</span>
                        <span class="story-card__tag">A young learner building strong fundamentals with courage and structure.</span>
                    </summary>
                    <div class="story-card__body">
                        <img class="story-card__image" src="/img/Amin.png" alt="Amin" loading="lazy">
                        <p>At just 7 years old, with no prior experience, Amin joined the academy in mid-2025. Her beginning was humble, but she approached every challenge with bravery and a genuine desire to improve, moving through her early struggles with patience and determination.</p>
                        <p>One of the key forces behind her progress has been connection. Sometimes what a student needs most is not just structure or rewards, but a teacher who is understanding, engaging, and present.</p>
                        <p class="story-card__quote">"Very professional, good with children and makes lessons enjoyable. My daughter looks forward to every class." - Nara</p>
                        <p>Progressing steadily through her P Plate Piano Book 1, Amin went beyond expectations, preparing five fully mastered pieces, more than required, and performing them with joy at the FA Recital 2025, where she was also the youngest performer.</p>
                        <p>Together with her mother, a clear and ambitious path was set: Grade 2 by the end of 2026 and up to Grade 4 by the end of 2027.</p>
                        <p>This ambition does not come from pressure. It comes from Amin's curiosity and courage. Even from such early beginnings, she shows fast, thoughtful development, guided by structure and supported through consistent teaching.</p>
                    </div>
                </details>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container">
            <header class="section__header stack gap-xs center">
                <p class="article-meta">Parent reviews</p>
                <h2>What parents notice after starting</h2>
                <p class="tagline">Review highlights from Fortepiano Academy families.</p>
            </header>
            <div class="grid grid--3 grid--gap-l">
                <?php foreach ($reviews as $review): ?>
                    <article class="card review-card">
                        <header class="review-card__head">
                            <h3 class="review-card__name"><?= e($review['name']) ?></h3>
                            <div class="stars" aria-label="5 out of 5 stars"><span>5 stars</span></div>
                        </header>
                        <p class="review-card__text"><?= e($review['text']) ?></p>
                        <a class="btn btn--ghost btn--google" href="<?= e(GOOGLE_REVIEW_URL) ?>" target="_blank" rel="noopener">Read Google Reviews</a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section__content container">
            <header class="section__header stack gap-xs center">
                <h2>Recital and performance moments</h2>
                <p class="tagline">Performance is part of making progress visible.</p>
            </header>
            <div class="ribbon">
                <div class="ribbon__track">
                    <figure class="ribbon__item card card--flat"><img src="/img/recital teacher and jennie.JPG" alt="Recital with student Jennie" loading="lazy"></figure>
                    <figure class="ribbon__item card card--flat"><img src="/img/recital teacher and amin.JPG" alt="Recital with student Amin" loading="lazy"></figure>
                    <figure class="ribbon__item card card--flat"><img src="/img/kids holding cert.JPG" alt="Students holding certificates" loading="lazy"></figure>
                    <figure class="ribbon__item card card--flat"><img src="/img/recital group photo with parents.JPG" alt="Fortepiano Academy recital group with parents" loading="lazy"></figure>
                </div>
            </div>
        </div>
    </section>

    <?php render_cta_band('Start building visible progress', 'The first step is an assessment that places your child into the right structure.', 'Book Initial Assessment', '/initial-assessment#book', 'View Programs', '/programs', 'results'); ?>
</main>
<?php render_footer(); ?>
