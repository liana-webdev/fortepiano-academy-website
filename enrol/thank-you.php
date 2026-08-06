<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/tracking.php';

$config = enrol_config();
$success = $_SESSION['lead_success'] ?? null;
$confirmation = (string) ($_GET['confirmation'] ?? '');
$confirmed = is_array($success)
    && $confirmation !== ''
    && hash_equals((string) ($success['confirmation'] ?? ''), $confirmation)
    && (int) ($success['expires'] ?? 0) >= time();
$trackLead = $confirmed && (bool) ($success['track'] ?? false);
unset($_SESSION['lead_success']);

if (!$confirmed) {
    http_response_code(404);
}
?>
<!doctype html>
<html lang="en-AU">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title><?= $confirmed ? 'Enquiry received' : 'Confirmation unavailable' ?> | Fortepiano Academy</title>
  <meta name="description" content="Fortepiano Academy Initial Assessment enquiry confirmation.">
  <meta name="theme-color" content="#0E0D11">
  <link rel="preload" href="assets/fonts/editorial-serif.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="stylesheet" href="assets/css/styles.css">
  <?php enrol_tracking_head($config); ?>
</head>
<body class="confirmation-page">
<?php enrol_tracking_body($config); ?>
<main class="confirmation-main">
  <div class="confirmation-light" aria-hidden="true"></div>
  <a class="wordmark wordmark-confirmation" href="index.php">
    <span class="wordmark-mark" aria-hidden="true">F</span><span>Fortepiano<br>Academy</span>
  </a>
  <section class="confirmation-card">
    <?php if ($confirmed): ?>
      <p class="eyebrow"><span></span> Enquiry confirmed</p>
      <p class="confirmation-index">01</p>
      <h1>Thank you — your enquiry has been received.</h1>
      <p>Fortepiano Academy will be in touch regarding current Initial Assessment times.</p>
      <a class="button" href="index.php">Return to enrolments</a>
    <?php else: ?>
      <p class="eyebrow"><span></span> Confirmation unavailable</p>
      <h1>This confirmation link is no longer active.</h1>
      <p>No conversion has been recorded. If you have not submitted an enquiry, return to the enrolment page to begin.</p>
      <a class="button" href="index.php#enquiry">Go to the enquiry form</a>
    <?php endif; ?>
  </section>
  <div class="staff-lines confirmation-staff" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
</main>
<?php if ($trackLead): enrol_success_tracking($config); endif; ?>
</body>
</html>
