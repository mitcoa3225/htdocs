<?php
namespace Controllers;

use Models\Database;

class DbStatusController {
    public static function getStatus(): array {
        $db = new Database();
        $conn = $db->getDbConn();
        $ok = ($conn !== false);
        return [
            'ok' => $ok,
            'error' => $db->getDbError(),
            'host' => $db->getDbHost(),
            'name' => $db->getDbName(),
            'user' => $db->getDbUser(),
            'pass' => $db->getDbPass(),
        ];
    }
}
