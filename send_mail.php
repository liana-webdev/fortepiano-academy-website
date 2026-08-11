<?php
declare(strict_types=1);

// Fortepiano Academy — contact form handler

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    echo 'Method not allowed.';
    exit;
}

$name = trim((string) ($_POST['name'] ?? ''));
$contact = trim((string) ($_POST['contact'] ?? ''));
$age = trim((string) ($_POST['age'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));
$pageType = trim((string) ($_POST['page_type'] ?? ''));
$enquiryType = trim((string) ($_POST['enquiry_type'] ?? ''));
$suburb = trim((string) ($_POST['suburb'] ?? ''));
$goals = trim((string) ($_POST['goals'] ?? ''));
$availability = trim((string) ($_POST['availability'] ?? ''));
$lessonLocation = trim((string) ($_POST['lesson_location'] ?? ''));
$homeLocation = trim((string) ($_POST['home_location'] ?? ''));
$homePiano = trim((string) ($_POST['home_piano'] ?? ''));

if ($name === '' || $contact === '' || $enquiryType === '' || $lessonLocation === '' || $message === '') {
    http_response_code(400);
    echo 'Please fill in all required fields.';
    exit;
}

$safeName = trim((string) preg_replace('/[\r\n]+/', ' ', $name));
$replyEmail = filter_var($contact, FILTER_VALIDATE_EMAIL) ? $contact : '';
$source = in_array($pageType, ['assessment', 'contact'], true) ? $pageType : 'contact';
$to = 'contact@fortepianoacademy.au';
$subject = "New Fortepiano Academy enquiry from $safeName";
$body = "
Name: $name
Contact: $contact
Page Type: $pageType
Enquiry Type: $enquiryType
Suburb Context: $suburb
Student Age/Level: $age
Goals: $goals
Availability: $availability
Preferred Lesson Location: $lessonLocation
Home Suburb / Cross Street: $homeLocation
Piano Available at Home: $homePiano

Message:
$message
";

$headers = [
    'From: Fortepiano Academy <contact@fortepianoacademy.au>',
    'Content-Type: text/plain; charset=UTF-8',
];
if ($replyEmail !== '') {
    $headers[] = "Reply-To: $safeName <$replyEmail>";
}

if (!mail($to, $subject, $body, implode("\r\n", $headers))) {
    http_response_code(500);
    echo 'Oops — something went wrong. Please try again later.';
    exit;
}

session_start();
session_regenerate_id(true);
$_SESSION['main_site_lead_success'] = [
    'source' => $source,
    'expires' => time() + 300,
];

header('Location: /thank-you?source=' . rawurlencode($source), true, 303);
exit;
