<?php
require_once('display_name.php');

$dispName = new DisplayName();
$dispName->setName("Mitchell", "Coates");
?>

<html>
<head>
 <title>Week2 GP1 - Mitchell Coates</title>
</head>

<body>
 <h2>
        Hello! <?php echo $dispName->getName(); ?>! Welcome to Object-Oriented PHP!
    </h2>
</body>
</html>