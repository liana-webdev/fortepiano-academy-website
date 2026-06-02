<?php
// Fortepiano Academy — contact form handler

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Basic sanitation
    $name    = trim($_POST["name"] ?? '');
    $contact = trim($_POST["contact"] ?? '');
    $age          = trim($_POST["age"] ?? '');
    $message      = trim($_POST["message"] ?? '');
    $pageType     = trim($_POST["page_type"] ?? '');
    $enquiryType  = trim($_POST["enquiry_type"] ?? '');
    $suburb       = trim($_POST["suburb"] ?? '');
    $goals        = trim($_POST["goals"] ?? '');
    $availability = trim($_POST["availability"] ?? '');

    if ($name === '' || $contact === '' || $message === '') {
        http_response_code(400);
        echo "Please fill in all required fields.";
        exit;
    }

    // Compose email
    $to      = "contact@fortepianoacademy.au";
    $subject = "New Fortepiano Academy enquiry from $name";
    $body = "
    Name: $name
    Contact: $contact
    Page Type: $pageType
    Enquiry Type: $enquiryType
    Suburb Context: $suburb
    Student Age/Level: $age
    Goals: $goals
    Availability: $availability

    Message:
    $message
    ";

    $headers = [
        "From: Fortepiano Academy <contact@fortepianoacademy.au>",
        "Reply-To: $name <$contact>",
        "Content-Type: text/plain; charset=UTF-8"
    ];

    // Send
    if (mail($to, $subject, $body, implode("\r\n", $headers))) {
        echo "Success! Thank you for reaching out — we’ll contact you shortly.";
    } else {
        http_response_code(500);
        echo "Oops — something went wrong. Please try again later.";
    }
} else {
    http_response_code(405);
    echo "Method not allowed.";
}
?>
