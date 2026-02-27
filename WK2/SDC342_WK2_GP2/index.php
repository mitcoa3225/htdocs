<?php
require_once('display_name.php');

//create an instance of the display name class
$dispName = new DisplayName("Mitchell", "Coates");

//get the full name based on the constructor parameters
$fullName = $dispName->getFullName();

//Update the first and last names
$dispName->setFirstName("John");
$dispName->setLastName("Smith");
?>

<html>
<head>
 <title>Week2 GP2 - Mitchell Coates</title>
</head>

<body>
 <h2>Values for Names are as follows:</h2> 
 <h3>
        Name entered via the constructor: <?php echo $fullName; ?>
 </h3>
 <h3>
        Name following updates: <?php echo $dispName->getFullName(); ?>
 </h3>
 <h3>
        Name using the property getters (formatted as Last, First): 
 <?php echo $dispName->getLastName() . ", " . $dispName->getFirstName(); ?>
 </h3>
</body>
</html>