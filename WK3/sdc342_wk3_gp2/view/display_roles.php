<?php 
require_once(__DIR__ . '\..\controller\role.php');

//temporary code to test the display - create an
//array with 2 roles to display - this will be 
//replaced in the next GP when it gets the information
//from the database via the controller classes
$roles = array(new Role(0, 'Role 0'), new Role(1, 'Role 1'));
?>

<html>
<head>
 <title>Week3 GP2 - Mitchell Coates</title>
 <link rel="stylesheet" type="text/css" href="styles.css"/>
</head>
<body>
 <h1>Week3 GP2 - Mitchell Coates</h1>
 <h1>Available Roles</h1>
 <table>
 <tr>
 <th>Role No</th>
 <th>Role Name</th>
 </tr>
 <?php foreach ($roles as $role) : ?>
 <tr>
 <td><?php echo $role->getRoleNo(); ?></td>
 <td><?php echo $role->getRoleName(); ?></td>
 </tr>
 <?php endforeach; ?>
 </table>
 <h3><a href="../index.php">Home</a></h3>
</body>
</html>