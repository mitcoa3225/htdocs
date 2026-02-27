<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("admin");



// Admin Add Employee page. Creates a new employee account and saves the password as a hash.
// Admin Employee Add page.
// Inserts a new employee.

require_once(__DIR__ . "/../controller/employee_controller.php");

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstNameText = $_POST["first_name"] ?? "";
    $lastNameText = $_POST["last_name"] ?? "";
    $emailText = $_POST["email"] ?? "";
    $roleText = $_POST["role"] ?? "";
    $passwordText = $_POST["employee_password"] ?? "";

    $ok = EmployeeController::addEmployee($emailText, $firstNameText, $lastNameText, $roleText, $passwordText);

    if ($ok) $successMessage = "Employee added.";
    else $errorMessage = "Insert failed.";
}

require_once("header.php");
?>

<h2>Add Employee</h2>

<?php if ($errorMessage != "") { ?><p><?php echo $errorMessage; ?></p><?php } ?>
<?php if ($successMessage != "") { ?><p><?php echo $successMessage; ?></p><?php } ?>

<!-- form to add a new employee -->
<!-- Form fields -->
<form method="post" action="admin_employee_add.php">
    <label>Email:</label><br>
    <input type="text" name="email"><br><br>

    <label>First Name:</label><br>
    <input type="text" name="first_name"><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name"><br><br>

    <label>Role:</label><br>
<!-- dropdown list built from database values -->
    <select name="role">
        <option value="">Select role</option>
        <option value="administrator">administrator</option>
        <option value="technician">technician</option>
    </select><br><br>

    <label>Password:</label><br>
    <input type="password" name="employee_password"><br><br>

    <input type="submit" value="Add Employee">
</form>

<p><a href="admin_employee_list.php">Back to Employee List</a></p>

<?php require_once("footer.php"); ?>