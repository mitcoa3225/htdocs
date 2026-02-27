<?php
namespace Controllers;

use Models\Database;
use Models\UserDB;

class AuthController {
    public static function handleLogin(string $userId, string $password): array {
        $db = new Database();
        $level = UserDB::validateLogin($db, $userId, $password);
        if ($level === false) {
            return ['success' => false, 'message' => 'Login credentials were incorrect.'];
        }

        $userObj = UserDB::getUserByUserId($db, $userId);
        $_SESSION['logged_in'] = true;
        $_SESSION['user_no'] = $userObj ? $userObj->getUserNo() : 0;
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_level'] = intval($level);
        $_SESSION['user_name'] = $userObj ? ($userObj->getFirstName() . ' ' . $userObj->getLastName()) : '';

        return ['success' => true, 'level' => intval($level)];
    }
}
