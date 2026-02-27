<?php
// Very basic autoload used by index.php and views.

require_once(__DIR__ . '/../util/Config.php');
require_once(__DIR__ . '/../util/Security.php');
require_once(__DIR__ . '/../util/Helpers.php');
require_once(__DIR__ . '/../util/Validation.php');
require_once(__DIR__ . '/../util/TextFileUtilities.php');
require_once(__DIR__ . '/../util/ImageUtilities.php');

require_once(__DIR__ . '/../model/Database.php');
require_once(__DIR__ . '/../model/User.php');
require_once(__DIR__ . '/../model/UserDB.php');

require_once(__DIR__ . '/AuthController.php');
require_once(__DIR__ . '/UserController.php');
require_once(__DIR__ . '/IncidentController.php');
require_once(__DIR__ . '/ImageController.php');
require_once(__DIR__ . '/DbStatusController.php');
