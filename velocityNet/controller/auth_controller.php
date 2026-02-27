<?php
// Auth controller.
// Handles login session values and basic role checks.
// Keeps access rules in one place so pages stay consistent.

class AuthController {

    // Start session only once.
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Is anyone logged in.
    public static function isLoggedIn() {
        if (!isset($_SESSION["role"])) return false;
        $role = (string)$_SESSION["role"];
        if ($role === "customer") return isset($_SESSION["customer_id"]);
        if ($role === "tech" || $role === "admin") return isset($_SESSION["employee_id"]);
        return false;
    }

    // Return current role or empty string.
    public static function getRole() {
        if (!isset($_SESSION["role"])) return "";
        return (string)$_SESSION["role"];
    }

    // Return display name for header.
    public static function getDisplayName() {
        if (!isset($_SESSION["display_name"])) return "";
        return (string)$_SESSION["display_name"];
    }

    // Clear session and bounce to home.
    public static function logoutAndRedirect($redirectUrl) {
        self::startSession();

        $_SESSION = array();

        // Clear session cookie if it exists.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), "", time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        header("Location: " . $redirectUrl);
        exit;
    }

    // Basic role rules based on file name.
    // Admin pages: admin_*.php
    // Tech pages: technician_*.php
    // Customer pages: customer_*.php
    public static function enforcePageAccess($pageFileName, $homeHref, $viewPrefix) {

        self::startSession();

        // Public pages anyone can see.
        $publicPages = array(
            "index.php",
            "login.php",
            "register.php",
            "sitemap.php",
            "logout.php",
            "access_denied.php"
        );

        if (in_array($pageFileName, $publicPages)) return;

        // If it's a protected page and user isn't logged in, send to login.
        if (!self::isLoggedIn()) {
            header("Location: " . $viewPrefix . "login.php");
            exit;
        }

        $role = self::getRole();

        // Extra page rules for pages that do not follow a prefix name.
        if ($pageFileName === "complaint_create.php") {
            if ($role !== "customer") {
                header("Location: " . $viewPrefix . "access_denied.php");
                exit;
            }
        }

        if ($pageFileName === "complaint_list.php") {
            if ($role !== "admin" && $role !== "tech") {
                header("Location: " . $viewPrefix . "access_denied.php");
                exit;
            }
        }

        // Admin pages.
        if (strpos($pageFileName, "admin_") === 0) {
            if ($role !== "admin") {
                header("Location: " . $viewPrefix . "access_denied.php");
                exit;
            }
        }

        // Technician pages.
        if (strpos($pageFileName, "technician_") === 0) {
            if ($role !== "tech" && $role !== "admin") {
                header("Location: " . $viewPrefix . "access_denied.php");
                exit;
            }
        }

        // Customer pages.
        if (strpos($pageFileName, "customer_") === 0) {
            if ($role !== "customer") {
                header("Location: " . $viewPrefix . "access_denied.php");
                exit;
            }
        }
    }
}
?>