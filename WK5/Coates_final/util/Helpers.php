<?php
namespace Utils;

class Helpers {
    public static function h(string $value): string {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function post(string $key, string $default = ''): string {
        return isset($_POST[$key]) ? strval($_POST[$key]) : $default;
    }

    public static function get(string $key, string $default = ''): string {
        return isset($_GET[$key]) ? strval($_GET[$key]) : $default;
    }
}
