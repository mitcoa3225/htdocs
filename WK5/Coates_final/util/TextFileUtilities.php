<?php
namespace Utils;

class TextFileUtilities {
    public static function getFileList(string $dir): array {
        $files = [];
        if (!is_dir($dir)) return $files;
        foreach (scandir($dir) as $file) {
            if ($file === '.' || $file === '..') continue;
            if (is_file($dir . $file)) $files[] = $file;
        }
        sort($files);
        return $files;
    }

    public static function getFileContents(string $filePath): string {
        if (!file_exists($filePath)) return '';
        return strval(file_get_contents($filePath));
    }

    public static function writeFile(string $filePath, string $content): void {
        $f = fopen($filePath, 'w');
        if ($f === false) return;
        fwrite($f, $content);
        fclose($f);
    }

    public static function cleanFileName(string $name): string {
        return preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $name);
    }
}
