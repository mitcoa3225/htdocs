<?php
session_start();

require_once(__DIR__ . '/controller/Autoload.php');

use Utils\Security;
use Utils\Helpers;
use Utils\Validation;
use Controllers\AuthController;
use Controllers\UserController;
use Controllers\ImageController;
use Controllers\IncidentController;
use Controllers\DbStatusController;

Security::checkHTTPS();

actionRouter();

function actionRouter(): void {
    $action = Helpers::get('action', '');

    // logout is POST only, but allow either
    if ($action === 'logout') {
        Security::logout();
    }

    // If not logged in, only allow login.
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = Helpers::post('userId');
            $password = Helpers::post('password');
            $result = AuthController::handleLogin($userId, $password);
            if ($result['success']) {
                if (intval($result['level']) === 1) {
                    header('Location: index.php?action=admin_home');
                    exit();
                }
                if (intval($result['level']) === 2) {
                    header('Location: index.php?action=tech_home');
                    exit();
                }
                $_SESSION['flash_msg'] = 'Login failed - invalid user level.';
                header('Location: index.php');
                exit();
            }
            $values = ['userId' => $userId];
            $message = $result['message'];
            require(__DIR__ . '/view/login.php');
            return;
        }

        $values = ['userId' => ''];
        $message = '';
        require(__DIR__ . '/view/login.php');
        return;
    }

    // Logged in routes
    switch ($action) {
        case 'admin_home':
            Security::requireLevel(1);
            require(__DIR__ . '/view/admin_home.php');
            break;

        case 'tech_home':
            Security::requireLevel(2);
            require(__DIR__ . '/view/tech_home.php');
            break;

        // --- Admin: Users ---
        case 'users_list':
            Security::requireLevel(1);
            $users = UserController::listUsers();
            require(__DIR__ . '/view/users_list.php');
            break;

        case 'user_add':
            Security::requireLevel(1);
            $isEdit = false;
            $values = defaultUserValues();
            $errors = [];
            require(__DIR__ . '/view/user_form.php');
            break;

        case 'user_add_save':
            Security::requireLevel(1);
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php?action=users_list'); exit(); }
            $values = collectUserPost();
            $errors = validateUserPost($values);
            if (hasErrors($errors)) {
                $isEdit = false;
                require(__DIR__ . '/view/user_form.php');
                break;
            }
            $ok = UserController::addUser($values);
            $_SESSION['flash_msg'] = $ok ? 'User added successfully.' : 'Failed to add user (DB error).';
            header('Location: index.php?action=users_list');
            exit();

        case 'user_edit':
            Security::requireLevel(1);
            $userNo = intval(Helpers::get('userNo', '0'));
            $u = UserController::getUser($userNo);
            if (!$u) {
                $_SESSION['flash_msg'] = 'User not found.';
                header('Location: index.php?action=users_list');
                exit();
            }
            $isEdit = true;
            $values = [
                'UserId' => $u->getUserId(),
                'Password' => $u->getPassword(),
                'FirstName' => $u->getFirstName(),
                'LastName' => $u->getLastName(),
                'HireDate' => $u->getHireDate(),
                'EMail' => $u->getEmail(),
                'Extension' => strval($u->getExtension()),
                'UserLevelNo' => strval($u->getUserLevelNo()),
            ];
            $errors = [];
            require(__DIR__ . '/view/user_form.php');
            break;

        case 'user_edit_save':
            Security::requireLevel(1);
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php?action=users_list'); exit(); }
            $userNo = intval(Helpers::post('userNo', '0'));
            $values = collectUserPost();
            $errors = validateUserPost($values);
            if (hasErrors($errors)) {
                $isEdit = true;
                require(__DIR__ . '/view/user_form.php');
                break;
            }
            $ok = UserController::updateUser($userNo, $values);
            $_SESSION['flash_msg'] = $ok ? 'User updated successfully.' : 'Failed to update user (DB error).';
            header('Location: index.php?action=users_list');
            exit();

        case 'user_delete':
            Security::requireLevel(1);
            $userNo = intval(Helpers::get('userNo', '0'));
            $ok = UserController::deleteUser($userNo);
            $_SESSION['flash_msg'] = $ok ? 'User deleted successfully.' : 'Failed to delete user (DB error).';
            header('Location: index.php?action=users_list');
            exit();

        // --- Admin: Images ---
        case 'images_list':
            Security::requireLevel(1);
            $images = ImageController::listImages();
            $message = '';
            require(__DIR__ . '/view/images_list.php');
            break;

        case 'image_upload':
            Security::requireLevel(1);
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php?action=images_list'); exit(); }
            $result = ImageController::processUpload($_FILES['imageFile'] ?? []);
            $images = ImageController::listImages();
            $message = $result['message'];
            require(__DIR__ . '/view/images_list.php');
            break;

        case 'image_view':
            Security::requireLevel(1);
            $file = strval(Helpers::get('file', ''));
            $file = Utils\ImageUtilities::cleanFileName($file);
            require(__DIR__ . '/view/image_view.php');
            break;

        case 'image_delete':
            Security::requireLevel(1);
            $file = strval(Helpers::get('file', ''));
            ImageController::deleteImage($file);
            $_SESSION['flash_msg'] = 'Image deleted.';
            header('Location: index.php?action=images_list');
            exit();

        // --- Tech: Incidents ---
        case 'incidents_list':
            Security::requireLevel(2);
            $files = IncidentController::listIncidents();
            $message = '';
            $error = '';
            $values = ['fileName' => '', 'content' => ''];
            require(__DIR__ . '/view/incidents_list.php');
            break;

        case 'incident_add':
            Security::requireLevel(2);
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php?action=incidents_list'); exit(); }
            $fileName = Helpers::post('fileName');
            $content = Helpers::post('content');
            $values = ['fileName' => $fileName, 'content' => $content];
            $err = Validation::validateFileName($fileName);
            if ($err !== '') {
                $files = IncidentController::listIncidents();
                $message = '';
                $error = $err;
                require(__DIR__ . '/view/incidents_list.php');
                break;
            }
            IncidentController::saveIncident($fileName, $content);
            $_SESSION['flash_msg'] = 'Incident saved.';
            header('Location: index.php?action=incidents_list');
            exit();

        case 'incident_view':
            Security::requireLevel(2);
            $file = strval(Helpers::get('file', ''));
            $content = IncidentController::readIncident($file);
            require(__DIR__ . '/view/incident_view.php');
            break;

        case 'incident_edit':
            Security::requireLevel(2);
            $file = strval(Helpers::get('file', ''));
            $content = IncidentController::readIncident($file);
            require(__DIR__ . '/view/incident_edit.php');
            break;

        case 'incident_edit_save':
            Security::requireLevel(2);
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php?action=incidents_list'); exit(); }
            $file = Helpers::post('file');
            $content = Helpers::post('content');
            IncidentController::saveIncident($file, $content);
            $_SESSION['flash_msg'] = 'Incident updated.';
            header('Location: index.php?action=incidents_list');
            exit();

        // --- Tech: DB Status ---
        case 'db_status':
            Security::requireLevel(2);
            $status = DbStatusController::getStatus();
            require(__DIR__ . '/view/db_status.php');
            break;

        default:
            // unknown action -> send to correct home
            if (intval($_SESSION['user_level']) === 1) {
                header('Location: index.php?action=admin_home');
                exit();
            }
            header('Location: index.php?action=tech_home');
            exit();
    }
}

function defaultUserValues(): array {
    return [
        'UserId' => '',
        'Password' => '',
        'FirstName' => '',
        'LastName' => '',
        'HireDate' => '',
        'EMail' => '',
        'Extension' => '',
        'UserLevelNo' => '',
    ];
}

function collectUserPost(): array {
    return [
        'UserId' => Helpers::post('UserId'),
        'Password' => Helpers::post('Password'),
        'FirstName' => Helpers::post('FirstName'),
        'LastName' => Helpers::post('LastName'),
        'HireDate' => Helpers::post('HireDate'),
        'EMail' => Helpers::post('EMail'),
        'Extension' => Helpers::post('Extension'),
        'UserLevelNo' => Helpers::post('UserLevelNo'),
    ];
}

function validateUserPost(array $v): array {
    $errors = [];
    $errors['UserId'] = Validation::validateUserId($v['UserId']);
    $errors['Password'] = Validation::validatePassword($v['Password']);
    $errors['FirstName'] = Validation::validateName($v['FirstName'], 'First Name');
    $errors['LastName'] = Validation::validateName($v['LastName'], 'Last Name');
    $errors['HireDate'] = Validation::validateDate($v['HireDate'], 'Hire Date');
    $errors['EMail'] = Validation::validateEmail($v['EMail']);
    $errors['Extension'] = Validation::validateExtension($v['Extension']);
    $errors['UserLevelNo'] = Validation::validateUserLevel($v['UserLevelNo']);
    return $errors;
}

function hasErrors(array $errors): bool {
    foreach ($errors as $k => $v) {
        if (trim(strval($v)) !== '') return true;
    }
    return false;
}
