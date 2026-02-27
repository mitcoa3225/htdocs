<?php
// Basic class for image upload and manipulation.
// Supports jpg/jpeg and png.
class ImageUtilities {

    // Get a list of base image files in a directory.
    public static function GetBaseImagesList($dir) {
        $images = array();

        foreach (scandir($dir) as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if (is_file($dir . $file) && ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')) {
                $images[] = $file;
            }
        }

        return $images;
    }

    // Create resized image sub-directories (100, 250, 500).
    private static function CreateDirectories($dir) {
        if (!file_exists($dir . '/100')) {
            mkdir($dir . '/100');
        }
        if (!file_exists($dir . '/250')) {
            mkdir($dir . '/250');
        }
        if (!file_exists($dir . '/500')) {
            mkdir($dir . '/500');
        }

        return true;
    }

    // Resize while maintaining aspect ratio so the largest dimension becomes $max.
    private static function ResizeImage($orig, $type, $max) {
        $origImage = null;

        if ($type === IMAGETYPE_PNG) {
            $origImage = imagecreatefrompng($orig);
        } else if ($type === IMAGETYPE_JPEG) {
            $origImage = imagecreatefromjpeg($orig);
        } else {
            return null;
        }

        if ($origImage == null) {
            return null;
        }

        $origWidth = imagesx($origImage);
        $origHeight = imagesy($origImage);

        // If already within bounds, keep original size.
        $largest = max($origWidth, $origHeight);
        if ($largest <= $max) {
            $newWidth = $origWidth;
            $newHeight = $origHeight;
        } else {
            $ratio = $largest / $max;
            $newWidth = round($origWidth / $ratio);
            $newHeight = round($origHeight / $ratio);
        }

        $newImg = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG.
        if ($type === IMAGETYPE_PNG) {
            imagealphablending($newImg, false);
            imagesavealpha($newImg, true);
            $transparent = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
            imagefilledrectangle($newImg, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($newImg, $origImage, 0, 0, 0, 0,
            $newWidth, $newHeight, $origWidth, $origHeight);

        imagedestroy($origImage);
        return $newImg;
    }

    // Process an uploaded base image into 3 resized copies (100, 250, 500).
    public static function ProcessImage($file) {
        $fInfo = pathinfo($file);
        self::CreateDirectories($fInfo['dirname']);

        $info = getimagesize($file);
        if ($info === false) {
            return false;
        }

        $imgType = $info[2];

        // Basic GD check
        if (!function_exists('imagecreatetruecolor')) {
            return false;
        }

        $sizes = array(100, 250, 500);

        foreach ($sizes as $max) {
            $newImg = self::ResizeImage($file, $imgType, $max);
            if ($newImg == null) {
                continue;
            }

            $outFile = $fInfo['dirname'] . '/' . $max . '/' . $fInfo['basename'];

            switch ($imgType) {
                case IMAGETYPE_PNG:
                    imagepng($newImg, $outFile);
                    break;
                case IMAGETYPE_JPEG:
                    imagejpeg($newImg, $outFile);
                    break;
                default:
                    imagedestroy($newImg);
                    exit;
            }

            imagedestroy($newImg);
        }

        return true;
    }

    // Delete the base and associated resized images.
    public static function DeleteImageFiles($dir, $base) {
        if (file_exists($dir . $base)) {
            unlink($dir . $base);
        }
        if (file_exists($dir . '100/' . $base)) {
            unlink($dir . '100/' . $base);
        }
        if (file_exists($dir . '250/' . $base)) {
            unlink($dir . '250/' . $base);
        }
        if (file_exists($dir . '500/' . $base)) {
            unlink($dir . '500/' . $base);
        }

        return true;
    }

    // Very basic filename cleanup to prevent directory traversal.
    public static function CleanFileName($name) {
        return preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $name);
    }
}
