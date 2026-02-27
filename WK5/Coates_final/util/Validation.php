<?php
namespace Utils;

class Validation {
    public static function validateUserId(string $userId): string {
        $userId = trim($userId);
        if ($userId === '') return 'User ID is required.';
        if (strlen($userId) > 12) return 'User ID must be 12 characters or less.';
        if (!preg_match('/^[A-Za-z0-9]+$/', $userId)) return 'User ID must be letters and numbers only.';
        return '';
    }

    public static function validatePassword(string $pw): string {
        $pw = trim($pw);
        if ($pw === '') return 'Password is required.';
        if (strlen($pw) > 20) return 'Password must be 20 characters or less.';
        return '';
    }

    public static function validateName(string $name, string $label): string {
        $name = trim($name);
        if ($name === '') return $label . ' is required.';
        if (strlen($name) > 50) return $label . ' must be 50 characters or less.';
        if (!preg_match("/^[A-Za-z0-9 .,'-]+$/", $name)) return $label . ' contains invalid characters.';
        return '';
    }

    public static function validateDate(string $date, string $label): string {
        $date = trim($date);
        if ($date === '') return $label . ' is required.';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) return $label . ' must be in YYYY-MM-DD format.';
        [$y,$m,$d] = array_map('intval', explode('-', $date));
        if (!checkdate($m,$d,$y)) return $label . ' is not a valid date.';
        return '';
    }

    public static function validateEmail(string $email): string {
        $email = trim($email);
        if ($email === '') return 'Email is required.';
        if (strlen($email) > 50) return 'Email must be 50 characters or less.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return 'Email must be a valid email address.';
        return '';
    }

    public static function validateExtension(string $ext): string {
        $ext = trim($ext);
        if ($ext === '') return 'Extension is required.';
        if (!preg_match('/^\d{1,5}$/', $ext)) return 'Extension must be a 1 to 5 digit number.';
        $val = intval($ext);
        if ($val < 0 || $val > 99999) return 'Extension must be between 0 and 99999.';
        return '';
    }

    public static function validateUserLevel(string $level): string {
        $level = trim($level);
        if ($level === '') return 'User Level is required.';
        if (!preg_match('/^[12]$/', $level)) return 'User Level must be 1 (Admin) or 2 (Technician).';
        return '';
    }

    public static function validateFileName(string $name): string {
        $name = trim($name);
        if ($name === '') return 'File name is required.';
        if (!preg_match('/^[A-Za-z0-9_\-\.]+$/', $name)) return 'File name may only contain letters, numbers, underscore, dash, and dot.';
        return '';
    }
}
