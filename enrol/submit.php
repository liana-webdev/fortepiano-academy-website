<?php
declare(strict_types=1);

require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/form.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'Method not allowed.';
    exit;
}

$values = enrol_post_values();

if (!enrol_valid_csrf((string) ($_POST['csrf_token'] ?? ''))) {
    enrol_flash_form(['form' => 'Your form session expired. Please review the form and try again.'], $values);
    enrol_redirect('index.php?form=expired#enquiry');
}

if (trim((string) ($_POST['website'] ?? '')) !== '') {
    enrol_flash_form(['form' => 'The enquiry could not be accepted. Please try again.'], []);
    enrol_redirect('index.php?form=blocked#enquiry');
}

if (!enrol_rate_limit()) {
    enrol_flash_form(['form' => 'Too many recent attempts were received. Please wait 15 minutes and try again.'], $values);
    enrol_redirect('index.php?form=rate-limited#enquiry');
}

$errors = enrol_validate($values);
if ($errors) {
    enrol_flash_form($errors, $values);
    enrol_redirect('index.php?form=invalid#enquiry');
}

$config = enrol_config();
$smtp = $config['smtp'] ?? [];
$requiredConfig = ['host', 'port', 'encryption', 'username', 'password', 'from_email', 'from_name', 'recipient_email'];
$missingConfig = array_filter($requiredConfig, static fn (string $key): bool => trim((string) ($smtp[$key] ?? '')) === '');
$isLocalTest = enrol_is_local_request() && (bool) ($config['testing']['allow_local_test_delivery'] ?? false);

if (!$isLocalTest && $missingConfig) {
    error_log('Fortepiano enrolment SMTP configuration is incomplete.');
    enrol_flash_form(['form' => 'Email delivery is not configured yet. Please email contact@fortepianoacademy.au directly.'], $values);
    enrol_redirect('index.php?form=delivery-error#enquiry');
}

function email_row(string $label, string $value): string
{
    return '<tr><th style="padding:8px 12px;text-align:left;vertical-align:top;border-bottom:1px solid #e8e4dd">' . e($label) . '</th><td style="padding:8px 12px;border-bottom:1px solid #e8e4dd">' . nl2br(e($value !== '' ? $value : '—')) . '</td></tr>';
}

$labels = [
    'name' => 'Parent/adult student name',
    'email' => 'Email',
    'mobile' => 'Mobile',
    'student_age' => 'Student age',
    'lesson_location' => 'Preferred location',
    'experience' => 'Current experience',
    'goals' => 'Learning goals / AMEB interest',
    'availability' => 'Preferred days and times',
];
$attributionLabels = [
    'utm_source' => 'utm_source', 'utm_medium' => 'utm_medium', 'utm_campaign' => 'utm_campaign',
    'utm_content' => 'utm_content', 'utm_term' => 'utm_term', 'gclid' => 'gclid',
    'gbraid' => 'gbraid', 'wbraid' => 'wbraid', 'fbclid' => 'fbclid',
    'landing_url' => 'Landing page URL', 'referrer_url' => 'Referrer URL',
];

$htmlRows = '';
$plainRows = [];
foreach ($labels as $key => $label) {
    $htmlRows .= email_row($label, $values[$key]);
    $plainRows[] = $label . ': ' . ($values[$key] !== '' ? $values[$key] : '—');
}
$htmlAttribution = '';
$plainAttribution = [];
foreach ($attributionLabels as $key => $label) {
    $htmlAttribution .= email_row($label, $values[$key]);
    $plainAttribution[] = $label . ': ' . ($values[$key] !== '' ? $values[$key] : '—');
}

$htmlBody = '<h1 style="font-family:Georgia,serif">New Initial Assessment enquiry</h1><table style="border-collapse:collapse;width:100%;font-family:Arial,sans-serif">' . $htmlRows . '</table><h2 style="font-family:Georgia,serif;margin-top:28px">Attribution</h2><table style="border-collapse:collapse;width:100%;font-family:Arial,sans-serif">' . $htmlAttribution . '</table><p style="font:12px Arial,sans-serif;color:#77716f">Privacy consent was confirmed on submission. No payment was taken.</p>';
$plainBody = "NEW INITIAL ASSESSMENT ENQUIRY\n\n" . implode("\n", $plainRows) . "\n\nATTRIBUTION\n" . implode("\n", $plainAttribution) . "\n\nPrivacy consent: confirmed\n";

try {
    if (!$isLocalTest) {
        $autoload = __DIR__ . '/vendor/autoload.php';
        if (!is_file($autoload)) {
            throw new RuntimeException('Composer dependencies are not installed.');
        }
        require $autoload;

        $fromEmail = strtolower((string) $smtp['from_email']);
        $fromDomain = substr(strrchr($fromEmail, '@') ?: '', 1);
        if ($fromDomain !== CANONICAL_DOMAIN) {
            throw new RuntimeException('The configured From address must use the fortepianoacademy.au domain.');
        }

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = (string) $smtp['host'];
        $mail->Port = (int) $smtp['port'];
        $mail->SMTPAuth = true;
        $mail->Username = (string) $smtp['username'];
        $mail->Password = (string) $smtp['password'];
        $mail->Timeout = 20;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPSecure = strtolower((string) $smtp['encryption']) === 'ssl'
            ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS
            : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->setFrom($fromEmail, (string) $smtp['from_name']);
        $mail->addAddress((string) $smtp['recipient_email']);
        $mail->addReplyTo($values['email'], $values['name']);
        $mail->Subject = 'Initial Assessment enquiry — ' . $values['name'];
        $mail->isHTML(true);
        $mail->Body = $htmlBody;
        $mail->AltBody = $plainBody;
        $mail->send();
    }

    session_regenerate_id(true);
    $confirmation = bin2hex(random_bytes(24));
    $_SESSION['lead_success'] = [
        'confirmation' => $confirmation,
        'expires' => time() + 300,
        'track' => !$isLocalTest,
    ];
    unset($_SESSION['csrf_token'], $_SESSION['csrf_issued_at']);
    enrol_redirect('thank-you.php?confirmation=' . rawurlencode($confirmation));
} catch (Throwable $exception) {
    error_log('Fortepiano enrolment SMTP failure: ' . $exception->getMessage());
    enrol_flash_form([
        'form' => 'We could not send your enquiry. Nothing has been submitted. Please try again or email contact@fortepianoacademy.au directly.',
    ], $values);
    enrol_redirect('index.php?form=delivery-error#enquiry');
}
