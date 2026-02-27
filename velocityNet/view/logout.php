<?php
// Logout page.
// Clears the current session and returns the user to the homepage.

require_once(__DIR__ . "/../util/security.php");

//check if current file is inside view folder
//adjusts relative paths so links dont break

//true if current page path contains /view/
$inViewFolder = (strpos($_SERVER["PHP_SELF"], "/view/") !== false);
//set corrrect link to home depending on folder location
$homeHref = $inViewFolder ? "../index.php" : "index.php";
//prefix used when linking to view folder
$viewPrefix = $inViewFolder ? "" : "view/";

Security::checkHTTPS();

Security::logout();
?>