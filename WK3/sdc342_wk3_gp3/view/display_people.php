<?php 
require_once(__DIR__ . '\..\controller\person.php');
require_once(__DIR__ . '\..\controller\person_controller.php');
require_once(__DIR__ . '\..\controller\role.php');
require_once(__DIR__ . '\..\controller\role_controller.php');

if (isset($_POST['update'])) {
 //update button pressed for a user
 if (isset($_POST['pNoUpd'])) {
 header('Location: ./add_update_person.php?pNo=' . $_POST['pNoUpd']);
    }

 unset($_POST['update']);
 unset($_POST['pNoUpd']);
}

if (isset($_POST['delete'])) {
 //delte button pressed for a user
 if (isset($_POST['pNoDel'])) {
 PersonController::deletePerson($_POST['pNoDel']);
    }

 unset($_POST['delete']);
 unset($_POST['pNoDel']);
}
?>

<html>
<head>
 <title>Week3 GP3 - Mitchell Coates</title>
 <link rel="stylesheet" type="text/css" href="styles.css"/>
</head>

<body>
 <h1>Week3 GP3 - Mitchell Coates</h1>
 <h1>All People List</h1>
 <h2><a href="./add_update_person.php">Add Person</a></h2>
 <table>
 <tr>
 <th>First Name</th>
 <th>Last Name</th>
 <th>Start Date</th>
 <th>Assigned Role</th>
 <th>&nbsp;</th>
 <th>&nbsp;</th>
 </tr>
 <?php foreach (PersonController::getAllPeople() as $person) : ?>
 <tr>
 <td><?php echo $person->getFirstName(); ?></td>
 <td><?php echo $person->getLastName(); ?></td>
 <td><?php echo $person->getStartDate(); ?></td>
 <td><?php echo $person->getRole()->getRoleName(); ?></td>
 <td><form method="POST">
 <input type="hidden" name="pNoUpd"
 value="<?php echo $person->getPersonNo(); ?>"/>
 <input type="submit" value="Update" name="update" />
 </form></td>
 <td><form method="POST">
 <input type="hidden" name="pNoDel"
 value="<?php echo $person->getPersonNo(); ?>"/>
 <input type="submit" value="Delete" name="delete" />
 </form></td>
 </tr>
 <?php endforeach; ?>
 </table>
 <h1>People by Role Lists</h1>
 <?php foreach (RoleController::getAllRoles() as $role) : ?>
 <h2>Role: <?php echo $role->getRoleName(); ?></h2>
 <table>
 <tr>
 <th>First Name</th>
 <th>Last Name</th>
 <th>Start Date</th>
 <th>Assigned Role</th>
 </tr>
 <?php foreach 
            (PersonController::getPeopleByRole(
 $role->getRoleNo()) as $person) : ?>
 <tr>
 <td><?php echo $person->getFirstName(); ?></td>
 <td><?php echo $person->getLastName(); ?></td>
 <td><?php echo $person->getStartDate(); ?></td>
 <td><?php echo $person->getRole()->getRoleName(); ?></td>
 </tr>
 <?php endforeach; ?>
 </table>
 <?php endforeach; ?>
 <h3><a href="../index.php">Home</a></h3>
</body>
</html>