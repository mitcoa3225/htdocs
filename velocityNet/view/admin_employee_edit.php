<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("admin");



// Admin Edit Employee page. Updates employee profile fields without changing the password.
// Admin Employee Edit page.
// Updates one employee record.

require_once(__DIR__ . "/../controller/employee_controller.php");

$errorMessage = "";
$successMessage = "";

$employeeIdNumber = 0;
if (isset($_GET["employee_id"])) $employeeIdNumber = (int)$_GET["employee_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstNameText = $_POST["first_name"] ?? "";
    $lastNameText = $_POST["last_name"] ?? "";
    $emailText = $_POST["email"] ?? "";
    $roleText = $_POST["role"] ?? "";

    if ($employeeIdNumber <= 0) {
        $errorMessage = "Missing employee id.";
    } else {

        $ok = EmployeeController::updateEmployee($employeeIdNumber, $emailText, $firstNameText, $lastNameText, $roleText);

        if ($ok) $successMessage = "Employee updated.";
        else $errorMessage = "Update failed.";
    }
}

$employeeRow = null;
if ($employeeIdNumber > 0) $employeeRow = EmployeeController::getEmployeeById($employeeIdNumber);

require_once("header.php");
?>

<h2>Edit Employee</h2>

<?php if ($errorMessage != "") { ?><p><?php echo $errorMessage; ?></p><?php } ?>
<?php if ($successMessage != "") { ?><p><?php echo $successMessage; ?></p><?php } ?>

<?php if ($employeeRow != null) { ?>
<!-- form to update an employee -->
<!-- Form fields -->
<form method="post" action="admin_employee_edit.php?employee_id=<?php echo $employeeRow->getEmployeeId(); ?>">
    <label>Email:</label><br>
    <input type="text" name="email" value="<?php echo $employeeRow->getEmail(); ?>"><br><br>

    <label>First Name:</label><br>
    <input type="text" name="first_name" value="<?php echo $employeeRow->getFirstName(); ?>"><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" value="<?php echo $employeeRow->getLastName(); ?>"><br><br>

    <label>Role:</label><br>
<!-- dropdown list built from database values -->
    <select name="role">
        <option value="admin" <?php if ($employeeRow->getRole() == "admin") echo "selected"; ?>>admin</option>
        <option value="technician" <?php if ($employeeRow->getRole() == "technician") echo "selected"; ?>>technician</option>
    </select><br><br>

    <input type="submit" value="Update Employee">
</form>
<?php } ?>

<p><a href="admin_employee_list.php">Back to Employee List</a></p>

<?php require_once("footer.php"); ?>