<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("tech");

// Technician Complaint List page.
// Shows complaints assigned to a technician.

require_once(__DIR__ . "/../controller/complaint_controller.php");

Security::startSession();

$employeeIdNumber = 0;
if (isset($_SESSION["employee_id"])) $employeeIdNumber = (int)$_SESSION["employee_id"];
$complaintList = ComplaintController::getComplaintsByEmployeeIdWithNames($employeeIdNumber);

require_once("header.php");
?>

<h2>Technician Complaint List</h2>

<?php if ($employeeIdNumber == 0) { ?>

    <!-- No employee_id means we don't know which technician to display -->
    <p>Missing employee id.</p>

<?php } else { ?>

    <?php if (count($complaintList) == 0) { ?>

        <!-- No complaints assigned -->
        <p>No complaints assigned.</p>

    <?php } else { ?>

<!-- table to display records from the database -->
        <table border="1" cellpadding="6">
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Customer</th>
                <th>Product/Service</th>
                <th>Complaint Type</th>
                <th>Created</th>
                <th>Action</th>
            </tr>

<?php //loop through complaintList and build output ?>
<!-- Loop through complaints returned from controller -->
            <?php foreach ($complaintList as $complaintRow) { ?>
                <tr>
                    <td><?php echo $complaintRow->getComplaintId(); ?></td>
                    <td><?php echo $complaintRow->getStatus(); ?></td>
                    <td><?php echo $complaintRow->getCustomerName(); ?></td>
                    <td><?php echo $complaintRow->getProductServiceName(); ?></td>
                    <td><?php echo $complaintRow->getComplaintTypeName(); ?></td>
                    <td><?php echo $complaintRow->getCreatedAt(); ?></td>

                    <!-- Link to update page and pass complaint_id + employee_id -->
                    <td>
                        <a href="technician_complaint_update.php?complaint_id=<?php echo $complaintRow->getComplaintId(); ?>&employee_id=<?php echo $employeeIdNumber; ?>">Update</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

    <?php } ?>

<?php } ?>

<?php require_once("footer.php"); ?>