<?php
namespace Utils;

class Security {
    public static function checkHTTPS(): void {
        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
            $host = $_SERVER['HTTP_HOST'] ?? '';
            $uri = $_SERVER['REQUEST_URI'] ?? '/';
            header('Location: https://' . $host . $uri);
            exit();
        }
    }

    public static function requireLogin(): void {
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            $_SESSION['flash_msg'] = 'Please login to access the application.';
            header('Location: index.php');
            exit();
        }
    }

    public static function requireLevel(int $levelNo): void {
        self::requireLogin();
        if (!isset($_SESSION['user_level']) || intval($_SESSION['user_level']) !== intval($levelNo)) {
            $_SESSION['flash_msg'] = 'Current login unauthorized for that page.';
            header('Location: index.php');
            exit();
        }
    }

    public static function logout(): void {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['flash_msg'] = 'Successfully logged out.';
        header('Location: index.php');
        exit();
    }
}
