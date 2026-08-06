<?php
declare(strict_types=1);

function enrol_text_length(string $value): int
{
    return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
}

function enrol_clean_text(mixed $value, int $maxLength): string
{
    $text = trim((string) $value);
    $text = preg_replace('/\s+/u', ' ', $text) ?? $text;
    return enrol_text_length($text) <= $maxLength ? $text : '';
}

function enrol_post_values(): array
{
    $fields = [
        'name' => 100,
        'email' => 180,
        'mobile' => 30,
        'student_age' => 30,
        'lesson_location' => 40,
        'experience' => 800,
        'goals' => 1200,
        'availability' => 500,
        'utm_source' => 200,
        'utm_medium' => 200,
        'utm_campaign' => 200,
        'utm_content' => 200,
        'utm_term' => 200,
        'gclid' => 300,
        'gbraid' => 300,
        'wbraid' => 300,
        'fbclid' => 300,
        'landing_url' => 1000,
        'referrer_url' => 1000,
    ];

    $values = [];
    foreach ($fields as $field => $maxLength) {
        $values[$field] = enrol_clean_text($_POST[$field] ?? '', $maxLength);
    }
    $values['privacy_consent'] = isset($_POST['privacy_consent']) ? '1' : '';
    return $values;
}

function enrol_validate(array $values): array
{
    $errors = [];

    if ($values['name'] === '' || enrol_text_length($values['name']) < 2 || preg_match('/[\r\n]/', $values['name'])) {
        $errors['name'] = 'Enter the parent or adult student name.';
    }
    if ($values['email'] === '' || preg_match('/[\r\n]/', $values['email']) || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    $mobile = preg_replace('/[\s\-().]/', '', $values['mobile']) ?? '';
    if (str_starts_with($mobile, '+61')) {
        $mobile = '0' . substr($mobile, 3);
    } elseif (str_starts_with($mobile, '61') && strlen($mobile) === 11) {
        $mobile = '0' . substr($mobile, 2);
    }
    if (!preg_match('/^04\d{8}$/', $mobile)) {
        $errors['mobile'] = 'Enter a valid Australian mobile number, including +61 or 04.';
    }

    if ($values['student_age'] === '') {
        $errors['student_age'] = 'Enter the student age or “Adult”.';
    }

    $locations = ['Wentworth Point studio', 'Home lesson', 'Open to either'];
    if (!in_array($values['lesson_location'], $locations, true)) {
        $errors['lesson_location'] = 'Choose a preferred lesson location.';
    }
    if ($values['privacy_consent'] !== '1') {
        $errors['privacy_consent'] = 'Confirm that you agree to the privacy notice.';
    }

    foreach (['landing_url', 'referrer_url'] as $urlField) {
        if ($values[$urlField] !== '' && !filter_var($values[$urlField], FILTER_VALIDATE_URL)) {
            $values[$urlField] = '';
        }
    }

    return $errors;
}

function enrol_rate_limit(): bool
{
    $directory = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'fortepiano-enrol-rate';
    if (!is_dir($directory) && !@mkdir($directory, 0700, true) && !is_dir($directory)) {
        error_log('Fortepiano enrolment rate-limit directory could not be created.');
        return false;
    }

    $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
    $file = $directory . DIRECTORY_SEPARATOR . hash('sha256', $ip) . '.json';
    $handle = @fopen($file, 'c+');
    if ($handle === false || !flock($handle, LOCK_EX)) {
        if (is_resource($handle)) {
            fclose($handle);
        }
        return false;
    }

    $contents = stream_get_contents($handle);
    $attempts = json_decode($contents ?: '[]', true);
    $attempts = is_array($attempts) ? $attempts : [];
    $cutoff = time() - 900;
    $attempts = array_values(array_filter($attempts, static fn ($time): bool => is_int($time) && $time >= $cutoff));
    $allowed = count($attempts) < 5;
    if ($allowed) {
        $attempts[] = time();
    }

    ftruncate($handle, 0);
    rewind($handle);
    fwrite($handle, json_encode($attempts, JSON_THROW_ON_ERROR));
    fflush($handle);
    flock($handle, LOCK_UN);
    fclose($handle);
    return $allowed;
}
