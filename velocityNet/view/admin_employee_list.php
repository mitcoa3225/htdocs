<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("admin");

// Admin Employee List page.
// Shows all employees.

require_once(__DIR__ . "/../controller/employee_controller.php");

// Handle delete requests.
$deleteMsg = "";

Security::startSession();
$currentEmployeeId = isset($_SESSION["employee_id"]) ? (int)$_SESSION["employee_id"] : 0;

if (isset($_POST["delete_employee_id"])) {

    $deleteId = (int)$_POST["delete_employee_id"];

    if ($deleteId > 0) {

        if ($deleteId === $currentEmployeeId) {
            $deleteMsg = "Unable to delete the current login.";
        } else {
            $deleted = EmployeeController::deleteEmployee($deleteId);
            $deleteMsg = $deleted ? "Employee deleted." : "Unable to delete employee.";
        }
    }
}

$employeeList = EmployeeController::getAllEmployees();

require_once("header.php");
?>

<?php if ($deleteMsg !== "") { ?>
    <p><?php echo $deleteMsg; ?></p>
<?php } ?>

<h2>Admin Employee List</h2>

<p><a href="admin_employee_add.php">Add Employee</a></p>

<!-- table to display records from the database -->
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>

<?php //loop through employeeList and build output ?>
<!-- Loop through employees returned from controller -->
    <?php foreach ($employeeList as $employeeRow) { ?>
        <tr>
            <td><?php echo $employeeRow->getEmployeeId(); ?></td>
            <td><?php echo $employeeRow->getLastName() . ", " . $employeeRow->getFirstName(); ?></td>
            <td><?php echo $employeeRow->getEmail(); ?></td>
            <td><?php echo $employeeRow->getRole(); ?></td>
            <td>
                <a class="action-link" href="admin_employee_edit.php?employee_id=<?php echo $employeeRow->getEmployeeId(); ?>">Edit</a>

                <?php if ((int)$employeeRow->getEmployeeId() !== $currentEmployeeId) { ?>
<!-- Confirm before running delete action -->
                    <form method="post" action="" style="display:inline;" onsubmit="return confirm('Delete this employee?');">
                        <input type="hidden" name="delete_employee_id" value="<?php echo (int)$employeeRow->getEmployeeId(); ?>">
                        <button type="submit">Delete</button>
                    </form>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>

</table>

<?php require_once("footer.php"); ?>