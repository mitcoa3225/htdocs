<?php
require_once(__DIR__ . '\..\model\database.php');

//set error reporting to errors only
error_reporting(E_ERROR);

//create an instance of the Database class
$db = new Database();
?>

<html>
<head>
 <title>Week3 GP2 - Mitchell Coates</title>
</head>
<body>
 <h1>Week3 GP2 - Mitchell Coates</h1>
 <h1>Database Connection Status</h1>
 <?php if (strlen($db->getDbError())) : ?>
 <h2><?php echo $db->getDbError(); ?></h2>
 <ul>
 <li><?php echo "Database Name: " . $db->getDbName(); ?></li>
 <li><?php echo "Database Host: " . $db->getDbHost(); ?></li>
 <li><?php echo "Database User: " . $db->getDbUser(); ?></li>
 <li>
                <?php echo "Database User Password: " . $db->getDbUserPw(); ?>
            </li>
 </ul>
 <?php else : ?>
 <h2><?php echo "Successfully connected to " . $db->getDbName(); ?></h2>
 <?php endif; ?>
 <h3><a href='..\index.php'>Home</a></h3>
</body>
</html>