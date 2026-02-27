<?php
namespace Controllers;

use Utils\Config;
use Utils\ImageUtilities;

class ImageController {
    public static function listImages(): array {
        return ImageUtilities::getBaseImagesList(Config::imagesDir());
    }

    public static function processUpload(array $file): array {
        if (!isset($file['tmp_name']) || $file['tmp_name'] === '') {
            return ['success' => false, 'message' => 'No file uploaded.'];
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'message' => 'Upload failed.'];
        }

        $baseName = ImageUtilities::cleanFileName(basename($file['name']));
        if ($baseName === '') {
            return ['success' => false, 'message' => 'Invalid file name.'];
        }

        $ext = strtolower(pathinfo($baseName, PATHINFO_EXTENSION));
        if (!in_array($ext, ['png', 'jpg', 'jpeg'])) {
            return ['success' => false, 'message' => 'Only PNG and JPG images are allowed.'];
        }

        $basePath = Config::imagesDir() . $baseName;

        if (!move_uploaded_file($file['tmp_name'], $basePath)) {
            return ['success' => false, 'message' => 'Could not save uploaded file.'];
        }

        $ok = ImageUtilities::processImageTo200($basePath, Config::images200Dir(), $baseName);
        if (!$ok) {
            // if resize fails, keep base but warn
            return ['success' => true, 'message' => 'Uploaded image saved, but resize failed (check GD support).', 'file' => $baseName];
        }

        return ['success' => true, 'message' => 'Uploaded and resized image successfully.', 'file' => $baseName];
    }

    public static function deleteImage(string $fileName): void {
        $safe = ImageUtilities::cleanFileName($fileName);
        ImageUtilities::deleteImageFiles(Config::imagesDir(), Config::images200Dir(), $safe);
    }
}
