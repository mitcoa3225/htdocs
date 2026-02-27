<?php
session_start();

require_once(__DIR__.'\..\util\security.php');

//confirm user is authorized for the page
Security::checkAuthority('admin');

//user clicked the logout button
if (isset($_POST['logout'])) {
 Security::logout();
}
?>
<html>
<head>
 <title>Week4 GP3 - Mitchell Coates</title>
</head>
<body>
 <h1>Week4 GP3 - Mitchell Coates</h1>
 <h2>Congratulations!</h2>
 <h2>You're logged in as an Administrator</h2>
 <form method='POST'>
 <input type="submit" value="Logout" name="logout">
 </form>
</body>
</html>