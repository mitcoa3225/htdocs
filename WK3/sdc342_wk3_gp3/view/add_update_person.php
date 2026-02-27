<?php
 require_once(__DIR__ . '\..\controller\person.php');
 require_once(__DIR__ . '\..\controller\person_controller.php');
 require_once(__DIR__ . '\..\controller\role.php');
 require_once(__DIR__ . '\..\controller\role_controller.php');

 $roles = RoleController::getAllRoles();

 //default person for add - empty strings and first role
 //in list
 $person = new Person('', '', date('Y-m-d'), $roles[0]);
 $person->setPersonNo(-1);
 $pageTitle = "Add a New Person";

 //Retrieve the personNo from the query string and 
 //and use it to create a person object for that pNo
 if (isset($_GET['pNo'])) {
 $person = 
 PersonController::getPersonByNo($_GET['pNo']);
 $pageTitle = "Update an Existing Person";
    }

 if (isset($_POST['save'])) {
 //save button - perform add or update
 //roleOptions are 1, 2, 3...the $roles array is base
 //0 index, so subtract 1 from the selected option to
 //get the correct index
 $person = new Person($_POST['fName'], $_POST['lName'],
 $_POST['start'], $roles[$_POST['roleOption']-1]);
 $person->setPersonNo($_POST['pNo']);

 if ($person->getPersonNo() === '-1') {
 //add
 PersonController::addPerson($person);
        } else {
 //update
 PersonController::updatePerson($person);
        }

 //return to people list
 header('Location: ./display_people.php');
    }

 if (isset($_POST['cancel'])) {
 //cancel button - just go back to list
 header('Location: ./display_people.php');
    }
?>

<html>
<head>
 <title>Week3 GP3 - Mitchell Coates</title>
</head>
<body>
 <h1>Week3 GP3 - Mitchell Coates</h1>
 <h2><?php echo $pageTitle; ?></h2>
 <form method='POST'>
 <h3>First Name: <input type="text" name="fName"
 value="<?php echo $person->getFirstName(); ?>">
 </h3>
 <h3>Last Name: <input type="text" name="lName"
 value="<?php echo $person->getLastName(); ?>">
 </h3>
 <h3>Start Date: <input type="date" name="start"
 value="<?php echo $person->getStartDate(); ?>">
 </h3>
 <h3>Role: <select name="roleOption">
 <?php foreach($roles as $role) : ?>
 <option value="<?php echo $role->getRoleNo(); ?>" 
 <?php if ($role->getRoleNo() === 
 $person->getRole()->getRoleNo()) { 
 echo 'selected'; }?>>
 <?php echo $role->getRoleName(); ?></option>
 <?php endforeach ?>
 </select>
 </h3>
 <input type="hidden" 
 value="<?php echo $person->getPersonNo(); ?>" name="pNo">
 <input type="submit" value="Save" name="save">
 <input type="submit" value="Cancel" name="cancel">
 </form>
</body>
</html>