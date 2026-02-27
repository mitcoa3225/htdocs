<?php 
require_once(__DIR__ . '\..\controller\person.php');
require_once(__DIR__ . '\..\controller\role.php');

//temporary code to test the display - create an
//array with 2 person objects to display - this will be 
//replaced in the next GP when it gets the information
//from the database via the controller classes
//role to assign to the person objects
$role = new Role(0, 'Role 0');
$people = array(
 new Person('Mitchell', 'Coates', '2021-01-25', $role), 
 new Person('John', 'Smith', '2000-01-01', $role));
?>

<html>
<head>
 <title>Week3 GP2 - Mitchell Coates</title>
 <link rel="stylesheet" type="text/css" href="styles.css"/>
</head>
<body>
 <h1>Week3 GP2 - Mitchell Coates</h1>
 <h1>People List</h1>
 <table>
 <tr>
 <th>First Name</th>
 <th>Last Name</th>
 <th>Start Date</th>
 <th>Assigned Role</th>
 </tr>
 <?php foreach ($people as $person) : ?>
 <tr>
 <td><?php echo $person->getFirstName(); ?></td>
 <td><?php echo $person->getLastName(); ?></td>
 <td><?php echo $person->getStartDate(); ?></td>
 <td><?php echo $person->getRole()->getRoleName(); ?></td>
 </tr>
 <?php endforeach; ?>
 </table>
 <h3><a href="../index.php">Home</a></h3>
</body>
</html>