<?php
declare(strict_types=1);

final class Auth
{
    public function __construct(private mysqli $db) {}

    public function verify(string $username, string $password): bool
    {
        $stmt = $this->db->prepare('SELECT id, password FROM adminlogin WHERE username = ? LIMIT 1');
        $stmt->bind_param('s', $username); $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        if (!$user) return false;

        $stored = (string)$user['password'];
        $valid = password_verify($password, $stored);
        if (!$valid && hash_equals($stored, $password)) {
            // One-time migration of the original plain-text password to a secure hash.
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $update = $this->db->prepare('UPDATE adminlogin SET password = ? WHERE id = ?');
            if ($update) { $update->bind_param('si', $hash, $user['id']); $update->execute(); }
            $valid = true;
        }
        return $valid;
    }

    public function login(string $username, string $password): bool
    {
        if (!$this->verify($username, $password)) return false;
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        return true;
    }

    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], (bool)$params['secure'], (bool)$params['httponly']);
        }
        session_destroy();
    }

    public function check(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE && !empty($_SESSION['admin_logged_in']);
    }
}
