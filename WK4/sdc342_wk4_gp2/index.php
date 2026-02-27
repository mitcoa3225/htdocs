<?php
require_once(__DIR__.'\controller\user.php');
require_once(__DIR__.'\controller\user_controller.php');
require_once(__DIR__.'\util\security.php');

Security::checkHTTPS();

$login_msg = '';

if (isset($_POST['email']) & isset($_POST['pw'])) {
 //login and password fields were set
 if (UserController::validUser($_POST['email'],
 $_POST['pw'])) 
    {
 $login_msg = 'User Authenticated Successfully!';
    } else {
 $login_msg = 'Failed Authentication - try again.';
    }
}
?>
<html>
<head>
 <title>Week4 GP2 - Mitchell Coates</title>
</head>
<body>
 <h1>Week4 GP2 - Mitchell Coates</h1>
 <h2>Login</h2>
 <form method='POST'>
 <h3>Login ID (e-mail): <input type="text" 
 name="email"></h3>
 <h3>Password: <input type="password" name="pw"></h3>
 <input type="submit" value="Login" name="login">
 </form>
 <h2><?php echo $login_msg; ?></h2>
</body>
</html>