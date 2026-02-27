<?php
// Basic class for text file manipulation.
// Works with files stored in the application's /text_files directory.
class TextFileUtilities {

    // Return an array of file names in a directory.
    public static function GetFileList($dir) {
        $files = array();

        foreach (scandir($dir) as $file) {
            if (is_file($dir . $file)) {
                $files[] = $file;
            }
        }

        return $files;
    }

    // Read and return the full contents of a file.
    public static function GetFileContents($file) {
        if (!file_exists($file)) {
            return '';
        }
        return file_get_contents($file);
    }

    // Create or overwrite a file with content.
    public static function WriteFile($file, $content) {
        $wFile = fopen($file, 'w');
        fwrite($wFile, $content);
        fclose($wFile);
    }

    // Very basic filename cleanup to prevent directory traversal.
    // Keeps letters, numbers, underscore, dash, dot.
    public static function CleanFileName($name) {
        return preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $name);
    }
}
