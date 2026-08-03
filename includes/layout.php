<?php
declare(strict_types=1);

require_once __DIR__ . '/site.php';

function render_head(array $page): void
{
    $path = $page['path'] ?? '/';
    $title = $page['title'] ?? SITE_NAME;
    $description = $page['description'] ?? '';
    $image = $page['image'] ?? '/images/piano-lesson-wentworth-point.jpg';
    $preloadImage = $page['preload_image'] ?? null;
    ?>
<!doctype html>
<html lang="en-AU">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/images/website%20icon.svg">
    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($description) ?>">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="<?= e(canonical($path)) ?>">
    <meta property="og:type" content="<?= e($page['og_type'] ?? 'website') ?>">
    <meta property="og:title" content="<?= e($title) ?>">
    <meta property="og:description" content="<?= e($description) ?>">
    <meta property="og:url" content="<?= e(canonical($path)) ?>">
    <meta property="og:image" content="<?= e(SITE_URL . $image) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <?php if (is_array($preloadImage)): ?>
        <?php
        $preloadWidths = $preloadImage['widths'] ?? [480, 768, 1200];
        $preloadBase = (string) ($preloadImage['base'] ?? '');
        $preloadSrcset = implode(', ', array_map(
            fn(int $width): string => $preloadBase . '-' . $width . '.avif ' . $width . 'w',
            $preloadWidths
        ));
        $preloadHref = $preloadBase . '-' . max($preloadWidths) . '.avif';
        ?>
        <link rel="preload" as="image" type="image/avif" href="<?= e($preloadHref) ?>" imagesrcset="<?= e($preloadSrcset) ?>" imagesizes="<?= e($preloadImage['sizes'] ?? '100vw') ?>" fetchpriority="high">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Darker+Grotesque:wght@300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/styles/main.css?v=5">
    <link rel="stylesheet" href="/styles/editorial.css?v=1">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9S4RJ9799Y"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-9S4RJ9799Y');
    </script>
<?php
    foreach ($page['schema'] ?? [] as $schema) {
        render_json_ld($schema);
    }
    ?>
</head>
<body class="<?= e($page['body_class'] ?? '') ?>">
<canvas id="top" class="living-staff" data-fa-living-staff aria-hidden="true"></canvas>
<?php
}

function render_responsive_picture(array $image): void
{
    $base = (string) $image['base'];
    $widths = $image['widths'] ?? [480, 768, 1200];
    $fallbackWidth = $image['fallback_width'] ?? max($widths);
    $alt = (string) ($image['alt'] ?? '');
    $class = (string) ($image['class'] ?? '');
    $pictureClass = (string) ($image['picture_class'] ?? '');
    $sizes = (string) ($image['sizes'] ?? '100vw');
    $loading = (string) ($image['loading'] ?? 'lazy');
    $fetchPriority = (string) ($image['fetchpriority'] ?? 'auto');
    $avifSrcset = implode(', ', array_map(fn(int $width): string => $base . '-' . $width . '.avif ' . $width . 'w', $widths));
    $webpSrcset = implode(', ', array_map(fn(int $width): string => $base . '-' . $width . '.webp ' . $width . 'w', $widths));
    ?>
<picture<?= $pictureClass !== '' ? ' class="' . e($pictureClass) . '"' : '' ?>>
    <source type="image/avif" srcset="<?= e($avifSrcset) ?>" sizes="<?= e($sizes) ?>">
    <source type="image/webp" srcset="<?= e($webpSrcset) ?>" sizes="<?= e($sizes) ?>">
    <img
        src="<?= e($base . '-' . $fallbackWidth . '.webp') ?>"
        alt="<?= e($alt) ?>"
        <?= $class !== '' ? 'class="' . e($class) . '"' : '' ?>
        width="<?= e($image['width']) ?>"
        height="<?= e($image['height']) ?>"
        loading="<?= e($loading) ?>"
        decoding="async"
        <?= $fetchPriority !== 'auto' ? 'fetchpriority="' . e($fetchPriority) . '"' : '' ?>
    >
</picture>
<?php
}

function render_header(string $active = ''): void
{
    global $navItems;
    ?>
<div class="site-service-line">
    <div class="container service-line__row">
        <span>Sydney piano school</span>
        <div class="service-line__links">
            <a href="/pricing">Pricing</a>
            <a href="/piano-lessons-wentworth-point">Wentworth Point studio</a>
            <span>At-home lessons available</span>
        </div>
    </div>
</div>
<header class="site-header">
    <div class="container header__row">
        <a class="brand__mark" href="/" aria-label="Fortepiano Academy home">
            <span class="brand__logo">
                <img src="/img/Logo.svg" class="logo logo--dark" alt="" width="200" height="178">
                <img src="/img/Logo 4.svg" class="logo logo--light" alt="" width="200" height="178">
            </span>
            <span class="brand__identity">
                <strong>Fortepiano Academy</strong>
                <small>Piano School &middot; Sydney</small>
            </span>
        </a>
        <nav class="nav" aria-label="Primary">
            <button class="nav__toggle" aria-expanded="false" aria-controls="navMenu" aria-label="Toggle navigation">
                <span class="sr-only">Menu</span>
                <span class="nav__toggle-box" aria-hidden="true">
                    <span class="nav__toggle-line"></span>
                    <span class="nav__toggle-line"></span>
                    <span class="nav__toggle-line"></span>
                </span>
            </button>
            <ul id="navMenu" class="nav__list">
                <?php foreach ($navItems as $item): ?>
                    <?php $activePath = $item['active'] ?? $item['href']; ?>
                    <li><a href="<?= e($item['href']) ?>"<?= $active === $activePath ? ' aria-current="page"' : '' ?>><?= e($item['label']) ?></a></li>
                <?php endforeach; ?>
                <li class="nav__language">
                    <label class="language-select" for="languageSelect">
                        <span class="language-select__label">Language</span>
                        <select id="languageSelect" class="language-select__control" aria-label="Choose language">
                            <option value="auto">Auto</option>
                            <option value="en">English</option>
                            <option value="vi">Tieng Viet</option>
                            <option value="zh">Chinese</option>
                        </select>
                    </label>
                </li>
                <li class="nav__theme">
                    <button id="themeToggle" class="theme-toggle" type="button" aria-label="Toggle theme" aria-pressed="false">
                        <span class="theme-toggle__icon" aria-hidden="true"></span>
                    </button>
                </li>
            </ul>
        </nav>
        <a class="header__admissions" href="/initial-assessment#book"<?= tracking_attrs('book_assessment_click', ['page_type' => 'header', 'cta_position' => 'header', 'cta_label' => 'Book Assessment']) ?>>
            <span>Book Assessment</span><span aria-hidden="true">&rarr;</span>
        </a>
    </div>
</header>
<?php
}

function render_footer(): void
{
    ?>
<footer class="site-footer">
    <div class="container editorial-footer">
        <div class="footer__brand">
            <img src="/img/Logo.svg" alt="" width="200" height="178">
            <div>
                <strong>Fortepiano<br>Academy</strong>
                <span>Piano School &middot; Sydney</span>
            </div>
        </div>
        <div class="footer__contact">
            <span>Admissions &amp; enquiries</span>
            <a href="mailto:<?= e(SITE_EMAIL) ?>"<?= tracking_attrs('email_click', ['page_type' => 'footer', 'cta_position' => 'footer']) ?>><?= e(SITE_EMAIL) ?></a>
            <a href="tel:<?= e(SITE_PHONE_LINK) ?>"<?= tracking_attrs('phone_click', ['page_type' => 'footer', 'cta_position' => 'footer']) ?>><?= e(SITE_PHONE) ?></a>
            <address><?= e(SITE_ADDRESS) ?></address>
        </div>
        <nav class="footer__nav" aria-label="Footer">
            <a href="/programs">Programs</a>
            <a href="/pricing">Pricing</a>
            <a href="/faculty">Faculty</a>
            <a href="/results">Results</a>
            <a href="/blog">Journal</a>
            <a href="/contact">Contact</a>
        </nav>
        <div class="footer__standards">
            <span>ABN <?= e(SITE_ABN) ?></span>
            <span>WWCC &middot; Public Liability &middot; Creative Kids Provider</span>
        </div>
        <div class="footer__bottom">
            <span>&copy; 2026 <?= e(SITE_NAME) ?></span>
            <a href="/privacy-policy.html">Privacy Policy</a>
            <a href="#top">Back to top &uarr;</a>
        </div>
    </div>
</footer>
<script src="/scripts/script.js?v=6"></script>
</body>
</html>
<?php
}

function render_breadcrumb(array $items): void
{
    ?>
<nav class="breadcrumb" aria-label="Breadcrumb">
    <?php foreach ($items as $index => $item): ?>
        <?php if ($index > 0): ?><span aria-hidden="true">/</span><?php endif; ?>
        <?php if (!empty($item['href']) && $index < count($items) - 1): ?>
            <a href="<?= e($item['href']) ?>"><?= e($item['label']) ?></a>
        <?php else: ?>
            <span><?= e($item['label']) ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>
<?php
}

function render_cta_band(string $heading, string $copy, string $primaryLabel = 'Book Initial Assessment', string $primaryHref = '/initial-assessment#book', ?string $secondaryLabel = null, ?string $secondaryHref = null, string $pageType = 'general'): void
{
    ?>
<section class="section section--compact">
    <div class="section__content container">
        <div class="cta-band card card--glass">
            <div class="stack gap-xs">
                <h2><?= e($heading) ?></h2>
                <p><?= e($copy) ?></p>
            </div>
            <div class="actions">
                <a class="btn btn--primary" href="<?= e($primaryHref) ?>"<?= tracking_attrs('book_assessment_click', ['page_type' => $pageType, 'cta_position' => 'cta_band', 'cta_label' => $primaryLabel]) ?>><?= e($primaryLabel) ?></a>
                <?php if ($secondaryLabel && $secondaryHref): ?>
                    <a class="btn btn--ghost" href="<?= e($secondaryHref) ?>"><?= e($secondaryLabel) ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php
}

function render_faqs(array $faqs): void
{
    ?>
<div class="stack gap-s">
    <?php foreach ($faqs as $faq): ?>
        <details class="card card--glass">
            <summary><strong><?= e($faq['q']) ?></strong></summary>
            <div class="pad-top-m">
                <p class="muted"><?= e($faq['a']) ?></p>
            </div>
        </details>
    <?php endforeach; ?>
</div>
<?php
}

function render_contact_form(string $pageType, string $submitLabel = 'Send Enquiry', string $suburb = ''): void
{
    ?>
<form id="book" class="card form" action="/send_mail.php" method="POST" data-form-type="<?= e($pageType) ?>">
    <input type="hidden" name="page_type" value="<?= e($pageType) ?>">
    <input type="hidden" name="suburb" value="<?= e($suburb) ?>">
    <label class="field">
        <span>Name</span>
        <input type="text" name="name" required autocomplete="name">
    </label>
    <label class="field">
        <span>Phone / Email</span>
        <input type="text" name="contact" required autocomplete="email">
    </label>
    <label class="field">
        <span>Enquiry Type</span>
        <select name="enquiry_type" required>
            <option value="">Choose one</option>
            <option>Initial assessment</option>
            <option>Program enquiry</option>
            <option>Pricing question</option>
            <option>General contact</option>
        </select>
    </label>
    <label class="field">
        <span>Preferred Lesson Location</span>
        <select name="lesson_location" required>
            <option value="">Choose one</option>
            <option>Wentworth Point studio</option>
            <option>At my home</option>
            <option>Not sure yet</option>
        </select>
    </label>
    <label class="field">
        <span>Home Suburb / Nearest Cross Street</span>
        <input type="text" name="home_location" placeholder="For an at-home lesson travel quote">
    </label>
    <label class="field">
        <span>Piano Available at Home</span>
        <select name="home_piano">
            <option value="">Choose one</option>
            <option>Acoustic piano</option>
            <option>Digital piano</option>
            <option>Not yet - I need advice</option>
            <option>Not applicable - studio lessons</option>
        </select>
    </label>
    <label class="field">
        <span>Student Age / Level</span>
        <input type="text" name="age" autocomplete="off">
    </label>
    <label class="field">
        <span>Goals</span>
        <input type="text" name="goals" placeholder="AMEB, beginner, confidence, technique...">
    </label>
    <label class="field">
        <span>Availability</span>
        <input type="text" name="availability" placeholder="Preferred days or times">
    </label>
    <label class="field">
        <span>Message</span>
        <textarea name="message" rows="4" required></textarea>
    </label>
    <p class="muted form-note">By submitting this form, you agree to the <a href="/privacy-policy.html">Privacy Policy</a>.</p>
    <button class="btn btn--primary" type="submit"><?= e($submitLabel) ?></button>
</form>
<?php
}
?>
