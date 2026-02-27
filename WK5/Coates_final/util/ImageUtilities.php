<?php
namespace Utils;

class ImageUtilities {
    public static function getBaseImagesList(string $dir): array {
        $images = [];
        if (!is_dir($dir)) return $images;
        foreach (scandir($dir) as $file) {
            if ($file === '.' || $file === '..') continue;
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (is_file($dir . $file) && in_array($ext, ['png','jpg','jpeg'])) {
                $images[] = $file;
            }
        }
        sort($images);
        return $images;
    }

    private static function ensure200Dir(string $dir200): void {
        if (!file_exists($dir200)) {
            mkdir($dir200, 0777, true);
        }
    }

    private static function resizeToMax(string $origPath, int $type, int $max): mixed {
        $origImage = null;
        if ($type === IMAGETYPE_PNG) {
            $origImage = imagecreatefrompng($origPath);
        } elseif ($type === IMAGETYPE_JPEG) {
            $origImage = imagecreatefromjpeg($origPath);
        } else {
            return null;
        }
        if ($origImage === null) return null;

        $ow = imagesx($origImage);
        $oh = imagesy($origImage);
        $largest = max($ow, $oh);
        if ($largest <= $max) {
            $nw = $ow; $nh = $oh;
        } else {
            $ratio = $largest / $max;
            $nw = (int)round($ow / $ratio);
            $nh = (int)round($oh / $ratio);
        }

        $newImg = imagecreatetruecolor($nw, $nh);
        if ($type === IMAGETYPE_PNG) {
            imagealphablending($newImg, false);
            imagesavealpha($newImg, true);
            $transparent = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
            imagefilledrectangle($newImg, 0, 0, $nw, $nh, $transparent);
        }

        imagecopyresampled($newImg, $origImage, 0, 0, 0, 0, $nw, $nh, $ow, $oh);
        imagedestroy($origImage);
        return $newImg;
    }

    public static function processImageTo200(string $basePath, string $outDir200, string $baseName): bool {
        self::ensure200Dir($outDir200);
        $info = getimagesize($basePath);
        if ($info === false) return false;
        $type = $info[2];
        if (!function_exists('imagecreatetruecolor')) return false;

        $newImg = self::resizeToMax($basePath, $type, 200);
        if ($newImg === null) return false;

        $outPath = $outDir200 . $baseName;
        if ($type === IMAGETYPE_PNG) {
            imagepng($newImg, $outPath);
        } elseif ($type === IMAGETYPE_JPEG) {
            imagejpeg($newImg, $outPath);
        }
        imagedestroy($newImg);
        return true;
    }

    public static function deleteImageFiles(string $baseDir, string $dir200, string $baseName): void {
        $p1 = $baseDir . $baseName;
        $p2 = $dir200 . $baseName;
        if (file_exists($p1)) unlink($p1);
        if (file_exists($p2)) unlink($p2);
    }

    public static function cleanFileName(string $name): string {
        return preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $name);
    }
}
