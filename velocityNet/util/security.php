<?php
// Security helper.
// Handles HTTPS enforcement, session-based authentication, and simple role authorization.

class Security {

    // Start session only once.
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Block the site unless HTTPS is being used.
    public static function checkHTTPS() {

        $isHttps = false;

        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "" && $_SERVER["HTTPS"] !== "off") {
            $isHttps = true;
        }

        // Support reverse proxies / load balancers.
        if (!$isHttps && isset($_SERVER["HTTP_X_FORWARDED_PROTO"])) {
            if (strtolower((string)$_SERVER["HTTP_X_FORWARDED_PROTO"]) === "https") $isHttps = true;
        }

        if ($isHttps) return;

        header("Content-Type: text/plain; charset=utf-8");
        echo "HTTPS is required to view this site.";
        exit;
    }

    // Check that the current login is authorized for a given authority key.
    // Expected values: "admin", "tech", "customer"
    public static function checkAuthority($authorityKey) {

        self::startSession();

        $key = (string)$authorityKey;

        // Not logged in.
        if (!isset($_SESSION[$key]) || $_SESSION[$key] !== true) {

            // If not logged in at all, send to login.
            $isLoggedIn = (isset($_SESSION["admin"]) && $_SESSION["admin"] === true)
                       || (isset($_SESSION["tech"]) && $_SESSION["tech"] === true)
                       || (isset($_SESSION["customer"]) && $_SESSION["customer"] === true);

            if (!$isLoggedIn) {
                $_SESSION["auth_msg"] = "Login required.";
                $loginUrl = self::inViewFolder() ? "login.php" : "view/login.php";
                header("Location: " . $loginUrl);
                exit;
            }

            // Logged in but wrong role.
            $_SESSION["auth_msg"] = "Current login unauthorized for this page.";
            $deniedUrl = self::inViewFolder() ? "access_denied.php" : "view/access_denied.php";
            header("Location: " . $deniedUrl);
            exit;
        }
    }

    // Log out and redirect to home.
    public static function logout() {

        self::startSession();

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), "", time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        $homeUrl = self::inViewFolder() ? "../index.php" : "index.php";
        header("Location: " . $homeUrl);
        exit;
    }

    private static function inViewFolder() {
        if (!isset($_SERVER["PHP_SELF"])) return false;
        return (strpos((string)$_SERVER["PHP_SELF"], "/view/") !== false);
    }
}
