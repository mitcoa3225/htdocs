<?php
namespace Controllers;

use Utils\Config;
use Utils\TextFileUtilities;

class IncidentController {
    public static function listIncidents(): array {
        return TextFileUtilities::getFileList(Config::incidentsDir());
    }

    public static function readIncident(string $fileName): string {
        $safe = TextFileUtilities::cleanFileName($fileName);
        return TextFileUtilities::getFileContents(Config::incidentsDir() . $safe);
    }

    public static function saveIncident(string $fileName, string $content): void {
        $safe = TextFileUtilities::cleanFileName($fileName);
        TextFileUtilities::writeFile(Config::incidentsDir() . $safe, $content);
    }
}
