<?php
namespace Controllers;

use Models\Database;
use Models\UserDB;

class UserController {
    public static function listUsers(): array {
        $db = new Database();
        return UserDB::getAllUsers($db);
    }

    public static function getUser(int $userNo) {
        $db = new Database();
        return UserDB::getUserByNo($db, $userNo);
    }

    public static function addUser(array $data): bool {
        $db = new Database();
        return UserDB::addUser($db, $data);
    }

    public static function updateUser(int $userNo, array $data): bool {
        $db = new Database();
        return UserDB::updateUser($db, $userNo, $data);
    }

    public static function deleteUser(int $userNo): bool {
        $db = new Database();
        return UserDB::deleteUser($db, $userNo);
    }
}
