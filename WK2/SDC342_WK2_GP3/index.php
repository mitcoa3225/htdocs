<?php
require_once('display_name.php');
require_once('greetings.php');

//replace with your name and names of your choosing
$myName = new DisplayName("Mitchell", "Coates");
$friendOne = new DisplayName("John", "Smith");
$friendTwo = new DisplayName("Aaron", "Finkle");
$friendThree = new DisplayName("Kin", "Chow");
?>

<html>
<head>
 <title>Week2 GP3 - Mitchell Coates</title>
</head>
<body>
 <h2>
 <?php echo Greetings::myName() . $myName->getFullName(); ?>
 </h2>
 <ul>
 <li>
 <?php echo Greetings::friend("first") . $friendOne->getFullName(); ?>
 </li>
 <li>
 <?php echo Greetings::friend("second") . $friendTwo->getFullName(); ?>
 </li>
 <li>
 <?php echo Greetings::friend("third") . $friendThree->getFullName(); ?>
 </li>
 </ul>
</body>
</html>