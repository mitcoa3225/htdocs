<?php
namespace Utils;

class Config {
    // Update these values if your SQL file specifies different credentials.
    private static string $dbHost = 'localhost';
    private static string $dbName = 'sdc342_wk5final';
    private static string $dbUser = 'root';
    private static string $dbPass = '';

    public static function dbHost(): string { return self::$dbHost; }
    public static function dbName(): string { return self::$dbName; }
    public static function dbUser(): string { return self::$dbUser; }
    public static function dbPass(): string { return self::$dbPass; }

    public static function imagesDir(): string { return __DIR__ . '/../images/'; }
    public static function images200Dir(): string { return __DIR__ . '/../images/200/'; }
    public static function incidentsDir(): string { return __DIR__ . '/../incidents/'; }
}
