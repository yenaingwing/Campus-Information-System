<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

function csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf(?string $token): bool
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    return is_string($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function flash(string $type, string $message): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function consume_flash(): array
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

function image_upload(string $field = 'image'): ?string
{
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('The image upload failed. Please try again.');
    }

    if ((int)$_FILES[$field]['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('The image must be 5 MB or smaller.');
    }

    $tmp = $_FILES[$field]['tmp_name'];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($tmp);
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    if (!isset($allowed[$mime])) {
        throw new RuntimeException('Only JPG, PNG, GIF, and WebP images are allowed.');
    }

    $uploadDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'upimage';
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
        throw new RuntimeException('The upload directory could not be created.');
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    $destination = $uploadDir . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($tmp, $destination)) {
        throw new RuntimeException('The image could not be saved.');
    }

    return 'upimage/' . $filename;
}

function delete_uploaded_image(?string $path): void
{
    if (!$path || !str_starts_with($path, 'upimage/')) {
        return;
    }
    $fullPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path);
    if (is_file($fullPath)) {
        @unlink($fullPath);
    }
}
