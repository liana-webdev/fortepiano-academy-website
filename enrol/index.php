<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/tracking.php';

$config = enrol_config();
$flash = enrol_take_form_flash();
$errors = is_array($flash['errors'] ?? null) ? $flash['errors'] : [];
$values = is_array($flash['values'] ?? null) ? $flash['values'] : [];
$privacyUrl = (string) ($config['site']['privacy_policy_url'] ?? '/privacy-policy.html');
$canonicalUrl = (string) ($config['site']['canonical_url'] ?? 'https://fortepianoacademy.au/enrol');
$ogImageUrl = (string) ($config['site']['og_image_url'] ?? 'https://fortepianoacademy.au/enrol/assets/img/og-image.jpg');

function field_value(array $values, string $key): string
{
    return e((string) ($values[$key] ?? ''));
}

function field_error(array $errors, string $key): string
{
    return isset($errors[$key]) ? ' aria-invalid="true" aria-describedby="' . e($key) . '-error"' : '';
}
?>
<!doctype html>
<html lang="en-AU">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Piano Lessons in Wentworth Point | Fortepiano Academy</title>
  <meta name="description" content="Structured one-to-one piano lessons for children, teenagers and adults in Wentworth Point and relevant Sydney areas. Book a $40 Initial Assessment.">
  <link rel="canonical" href="<?= e($canonicalUrl) ?>">
  <meta property="og:type" content="website">
  <meta property="og:title" content="Spring 2026 Piano Enrolments | Fortepiano Academy">
  <meta property="og:description" content="One-to-one piano education with clear direction, strong foundations and individual term plans.">
  <meta property="og:url" content="<?= e($canonicalUrl) ?>">
  <meta property="og:image" content="<?= e($ogImageUrl) ?>">
  <meta property="og:image:alt" content="Fortepiano Academy Spring 2026 Piano Enrolments">
  <meta name="theme-color" content="#F7F3EE">
  <link rel="icon" href="assets/img/logo-colour.svg" type="image/svg+xml">
  <link rel="preload" href="assets/fonts/editorial-serif.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="assets/img/hero-lesson.webp" as="image" type="image/webp" fetchpriority="high">
  <link rel="stylesheet" href="assets/css/styles.css">
  <?php enrol_tracking_head($config); ?>
  <script type="application/ld+json">
  <?= json_encode([
      '@context' => 'https://schema.org',
      '@type' => ['EducationalOrganization', 'LocalBusiness'],
      'name' => 'Fortepiano Academy',
      'url' => $canonicalUrl,
      'email' => 'contact@fortepianoacademy.au',
      'address' => [
          '@type' => 'PostalAddress',
          'addressLocality' => 'Wentworth Point',
          'addressRegion' => 'NSW',
          'addressCountry' => 'AU',
      ],
  ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
  </script>
</head>
<body>
<?php enrol_tracking_body($config); ?>
<a class="skip-link" href="#main">Skip to main content</a>

<header class="site-header" data-site-header>
  <div class="shell nav-wrap">
    <a class="brand-logo-link" href="#top" aria-label="Fortepiano Academy home">
      <img class="brand-logo brand-logo-header" src="assets/img/logo-colour.svg" width="163" height="145" alt="Fortepiano Academy">
    </a>
    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" data-nav-toggle>
      <span>Menu</span><i aria-hidden="true"></i>
    </button>
    <nav id="primary-nav" class="primary-nav" aria-label="Primary navigation" data-nav>
      <a href="#how-it-works">How it works</a>
      <a href="#programs">Programs</a>
      <a href="#faq">FAQ</a>
      <a class="button button-small" href="#enquiry" data-track="assessment-cta">Book an Initial Assessment</a>
    </nav>
  </div>
</header>

<main id="main">
  <section class="hero" id="top">
    <div class="holo-light" aria-hidden="true"></div>
    <div class="shell hero-grid">
      <div class="hero-copy">
        <p class="eyebrow"><span></span> Structured piano education · Wentworth Point &amp; Sydney</p>
        <p class="campaign-label">Spring 2026 piano enrolments</p>
        <h1>Spring 2026<br>Piano Enrolments</h1>
        <p class="hero-lede">One-to-one piano lessons for children, teenagers and adults seeking clear direction, strong musical foundations and a pathway that develops over time.</p>
        <div class="hero-actions">
          <a class="button" href="#enquiry" data-track="assessment-cta">Book an Initial Assessment <span>— $40</span></a>
          <a class="text-link" href="#programs">Explore the learning pathways <span aria-hidden="true">↘</span></a>
        </div>
        <dl class="hero-facts" aria-label="Lesson overview">
          <div><dt>Format</dt><dd>One-to-one</dd></div>
          <div><dt>Lesson options</dt><dd>30 · 45 · 60 minutes</dd></div>
          <div><dt>First step</dt><dd>Initial Assessment</dd></div>
        </dl>
      </div>
      <figure class="hero-media">
        <img src="assets/img/hero-lesson.webp" width="1200" height="900" alt="A student at the piano during a one-to-one lesson" fetchpriority="high">
        <figcaption><span>One-to-one piano education</span><span>Wentworth Point · Sydney</span></figcaption>
      </figure>
    </div>
    <div class="staff-lines" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
  </section>

  <section class="section assessment" id="how-it-works">
    <div class="shell assessment-grid">
      <div class="section-intro light">
        <p class="eyebrow"><span></span> Initial Assessment · $40</p>
        <h2>A clear<br>first step</h2>
      </div>
      <div class="assessment-content">
        <p class="large-copy">The Initial Assessment is a real teaching and placement session—not a sales call. It creates a considered starting point for the student and their next stage of learning.</p>
        <ol class="assessment-list">
          <li><span>01</span><p>Current level or beginner readiness</p></li>
          <li><span>02</span><p>Learning goals</p></li>
          <li><span>03</span><p>Suitable lesson length</p></li>
          <li><span>04</span><p>Recommended pathway</p></li>
          <li><span>05</span><p>Practical next steps</p></li>
        </ol>
        <div class="flow-line" aria-label="Enrolment flow">
          <span>Initial Assessment</span><i aria-hidden="true">→</i><span>Pathway recommendation</span><i aria-hidden="true">→</i><span>Enrolment &amp; individual term plan</span>
        </div>
      </div>
    </div>
  </section>

  <section class="section pathways" id="programs">
    <div class="shell">
      <div class="section-heading split-heading">
        <div>
          <p class="eyebrow"><span></span> Learning pathways</p>
          <h2>A pathway behind<br>every lesson</h2>
        </div>
        <p>Structured tuition begins with the student in front of us, then develops through clear priorities, individual term plans and learning milestones.</p>
      </div>
      <div class="pathway-grid">
        <article class="pathway-card foundation">
          <div class="card-top"><span>01</span><span>One lesson per week</span></div>
          <h3>Foundation</h3>
          <p>Steady weekly tuition for students building strong habits and musical foundations.</p>
          <ul>
            <li>Individual term plan</li>
            <li>Clear learning milestones</li>
            <li>30, 45 or 60-minute lessons</li>
          </ul>
        </article>
        <article class="pathway-card development">
          <div class="card-top"><span>02</span><span>Two lessons per week</span></div>
          <h3>Development</h3>
          <p>Two lessons per week for students needing stronger momentum, closer guidance and greater accountability.</p>
          <ul>
            <li>Individual term plan</li>
            <li>Closer learning rhythm</li>
            <li>30, 45 or 60-minute lessons</li>
          </ul>
        </article>
      </div>
      <p class="placement-note"><span>Placement note</span> Placement is recommended after the Initial Assessment according to age, level, goals and readiness.</p>
    </div>
  </section>

  <section class="section skills-section">
    <div class="shell">
      <div class="section-heading">
        <p class="eyebrow"><span></span> What students develop</p>
        <h2>Progress is built<br>in layers.</h2>
      </div>
      <div class="skills-grid">
        <article><span>01</span><h3>Technique</h3><p>Physical coordination and control at the instrument.</p></article>
        <article><span>02</span><h3>Reading</h3><p>Confident navigation of written music over time.</p></article>
        <article><span>03</span><h3>Rhythm</h3><p>A reliable sense of pulse, timing and structure.</p></article>
        <article><span>04</span><h3>Musical expression</h3><p>Thoughtful use of tone, phrasing and musical character.</p></article>
        <article><span>05</span><h3>Repertoire</h3><p>Music selected to support progress, interest and goals.</p></article>
        <article><span>06</span><h3>Practice habits</h3><p>Clear, repeatable ways to work between lessons.</p></article>
      </div>
    </div>
  </section>

  <section class="section ameb-section">
    <div class="shell ameb-grid">
      <div class="ameb-monogram" aria-hidden="true"><span>A</span><span>M</span><span>E</span><span>B</span></div>
      <div>
        <p class="eyebrow"><span></span> Optional exam pathways</p>
        <h2>AMEB and<br>long-term progress</h2>
        <p class="large-copy">AMEB exam preparation pathways are available where they suit the student’s goals and readiness. Exams are not compulsory; they are one possible structure within a broader musical education.</p>
        <a class="text-link" href="#enquiry">Discuss your learning goals <span aria-hidden="true">↘</span></a>
      </div>
    </div>
  </section>

  <section class="section location-section">
    <div class="shell location-grid">
      <figure>
        <img src="assets/img/studio-detail.webp" width="1200" height="900" alt="One-to-one piano teaching in a studio setting" loading="lazy">
        <figcaption><span>Wentworth Point studio</span><span>Structured one-to-one lessons</span></figcaption>
      </figure>
      <div class="location-copy">
        <p class="eyebrow"><span></span> Studio &amp; home lessons</p>
        <h2>Learn from<br>Wentworth Point<br>or at home</h2>
        <p>Lessons are available at the Wentworth Point studio, with selected home-lesson options in relevant Sydney areas, subject to location and travel fees.</p>
        <div class="location-options">
          <div><span>01</span><strong>Wentworth Point studio</strong></div>
          <div><span>02</span><strong>Relevant Sydney areas</strong></div>
        </div>
      </div>
    </div>
  </section>

  <section class="section faq-section" id="faq">
    <div class="shell faq-grid">
      <div class="section-intro">
        <p class="eyebrow"><span></span> Frequently asked</p>
        <h2>Before you<br>begin</h2>
        <p>Still have a question? Email <a href="mailto:contact@fortepianoacademy.au" data-track="email">contact@fortepianoacademy.au</a>.</p>
      </div>
      <div class="accordion">
        <details><summary>What happens in an Initial Assessment?<span aria-hidden="true"></span></summary><p>It is a teaching and placement session used to understand the student’s current level or beginner readiness, learning goals, suitable lesson length, recommended pathway and practical next steps.</p></details>
        <details><summary>Is the assessment suitable for complete beginners?<span aria-hidden="true"></span></summary><p>Yes. For a complete beginner, the session helps establish readiness, goals and an appropriate starting point.</p></details>
        <details><summary>What age can students begin?<span aria-hidden="true"></span></summary><p>Readiness varies. The Initial Assessment helps determine whether individual lessons are appropriate for the student’s age and readiness.</p></details>
        <details><summary>Do students need to take AMEB exams?<span aria-hidden="true"></span></summary><p>No. AMEB preparation is available where it suits a student’s goals and readiness, but exams are not compulsory.</p></details>
        <details><summary>Do you offer home lessons?<span aria-hidden="true"></span></summary><p>Selected home-lesson options are available in relevant Sydney areas, subject to location and travel fees.</p></details>
        <details><summary>How are lesson times arranged?<span aria-hidden="true"></span></summary><p>Lesson times are arranged according to current availability. You can share any preferred days and times in the enquiry form.</p></details>
        <details><summary>Do I need to choose Foundation or Development before enquiring?<span aria-hidden="true"></span></summary><p>No. The suitable pathway is recommended after the Initial Assessment according to age, level, goals and readiness.</p></details>
      </div>
    </div>
  </section>

  <section class="section enquiry-section" id="enquiry">
    <div class="shell enquiry-grid">
      <div class="enquiry-intro">
        <p class="eyebrow"><span></span> Initial Assessment · $40</p>
        <h2>Book an<br>Initial Assessment</h2>
        <p>Send an enquiry and Fortepiano Academy will be in touch regarding current assessment times.</p>
        <div class="enquiry-step"><span>Next</span><p>Assessment → pathway recommendation → individual term plan</p></div>
      </div>
      <div class="form-panel">
        <?php if ($errors): ?>
          <div class="form-alert" id="form" role="alert" tabindex="-1" data-form-alert>
            <strong>Please check the highlighted details.</strong>
            <ul>
              <?php foreach ($errors as $key => $message): ?><li><a href="#<?= e($key) ?>"><?= e($message) ?></a></li><?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
        <form action="submit.php" method="post" data-enquiry-form novalidate>
          <input type="hidden" name="csrf_token" value="<?= e(enrol_csrf_token()) ?>">
          <?php foreach (['utm_source','utm_medium','utm_campaign','utm_content','utm_term','gclid','gbraid','wbraid','fbclid','landing_url','referrer_url'] as $trackingField): ?>
            <input type="hidden" name="<?= e($trackingField) ?>" value="<?= field_value($values, $trackingField) ?>" data-attribution="<?= e($trackingField) ?>">
          <?php endforeach; ?>
          <div class="honeypot" aria-hidden="true">
            <label for="website">Leave this field empty</label><input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
          </div>

          <div class="form-grid">
            <div class="field full">
              <label for="name">Parent/adult student name <span>*</span></label>
              <input id="name" name="name" type="text" maxlength="100" autocomplete="name" required value="<?= field_value($values, 'name') ?>"<?= field_error($errors, 'name') ?>>
              <?php if (isset($errors['name'])): ?><p class="field-error" id="name-error"><?= e($errors['name']) ?></p><?php endif; ?>
            </div>
            <div class="field">
              <label for="email">Email address <span>*</span></label>
              <input id="email" name="email" type="email" maxlength="180" autocomplete="email" required value="<?= field_value($values, 'email') ?>"<?= field_error($errors, 'email') ?>>
              <?php if (isset($errors['email'])): ?><p class="field-error" id="email-error"><?= e($errors['email']) ?></p><?php endif; ?>
            </div>
            <div class="field">
              <label for="mobile">Mobile number <span>*</span></label>
              <input id="mobile" name="mobile" type="tel" maxlength="30" autocomplete="tel" required value="<?= field_value($values, 'mobile') ?>"<?= field_error($errors, 'mobile') ?>>
              <?php if (isset($errors['mobile'])): ?><p class="field-error" id="mobile-error"><?= e($errors['mobile']) ?></p><?php endif; ?>
            </div>
            <div class="field">
              <label for="student_age">Student age or “Adult” <span>*</span></label>
              <input id="student_age" name="student_age" type="text" maxlength="30" required value="<?= field_value($values, 'student_age') ?>"<?= field_error($errors, 'student_age') ?>>
              <?php if (isset($errors['student_age'])): ?><p class="field-error" id="student_age-error"><?= e($errors['student_age']) ?></p><?php endif; ?>
            </div>
            <div class="field">
              <label for="lesson_location">Preferred lesson location <span>*</span></label>
              <select id="lesson_location" name="lesson_location" required<?= field_error($errors, 'lesson_location') ?>>
                <option value="">Choose an option</option>
                <?php foreach (['Wentworth Point studio','Home lesson','Open to either'] as $location): ?><option value="<?= e($location) ?>"<?= (($values['lesson_location'] ?? '') === $location) ? ' selected' : '' ?>><?= e($location) ?></option><?php endforeach; ?>
              </select>
              <?php if (isset($errors['lesson_location'])): ?><p class="field-error" id="lesson_location-error"><?= e($errors['lesson_location']) ?></p><?php endif; ?>
            </div>
            <div class="field full">
              <label for="experience">Current piano experience <em>Optional</em></label>
              <textarea id="experience" name="experience" maxlength="800" rows="3"><?= field_value($values, 'experience') ?></textarea>
            </div>
            <div class="field full">
              <label for="goals">Learning goals / AMEB interest <em>Optional</em></label>
              <textarea id="goals" name="goals" maxlength="1200" rows="3"><?= field_value($values, 'goals') ?></textarea>
            </div>
            <div class="field full">
              <label for="availability">Preferred days and times <em>Optional</em></label>
              <textarea id="availability" name="availability" maxlength="500" rows="2"><?= field_value($values, 'availability') ?></textarea>
            </div>
          </div>
          <label class="consent" for="privacy_consent">
            <input id="privacy_consent" name="privacy_consent" type="checkbox" value="1" required<?= (($values['privacy_consent'] ?? '') === '1') ? ' checked' : '' ?><?= field_error($errors, 'privacy_consent') ?>>
            <span>I agree that Fortepiano Academy may use these details to respond to my enquiry, as described in the <a href="<?= e($privacyUrl) ?>">Privacy Policy</a>. <b>*</b></span>
          </label>
          <?php if (isset($errors['privacy_consent'])): ?><p class="field-error consent-error" id="privacy_consent-error"><?= e($errors['privacy_consent']) ?></p><?php endif; ?>
          <div class="form-submit">
            <button class="button" type="submit" data-submit-button>Send Initial Assessment enquiry <span aria-hidden="true">↗</span></button>
            <p>No payment is taken on this form.</p>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<footer class="site-footer">
  <div class="shell footer-top">
    <a class="brand-logo-link brand-logo-link-footer" href="#top" aria-label="Fortepiano Academy home"><img class="brand-logo brand-logo-footer" src="assets/img/logo-white.svg" width="200" height="178" alt="Fortepiano Academy"></a>
    <p>Structured one-to-one piano education<br>for children, teenagers and adults.</p>
    <div><span>Location</span><p>Wentworth Point, Sydney</p></div>
    <div><span>Enquiries</span><a href="mailto:contact@fortepianoacademy.au" data-track="email">contact@fortepianoacademy.au</a></div>
  </div>
  <div class="shell footer-bottom">
    <p>© <?= date('Y') ?> Fortepiano Academy</p>
    <a href="<?= e($privacyUrl) ?>">Privacy Policy</a>
    <a href="#top">Back to top ↑</a>
  </div>
</footer>
<script src="assets/js/site.js" defer></script>
</body>
</html>
