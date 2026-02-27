<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("admin");



// Admin Open Complaints page. Shows open tickets and allows viewing details or assigning a technician.
// Admin Open Complaints page.

require_once(__DIR__ . "/../controller/complaint_controller.php");

$complaintList = ComplaintController::getOpenComplaintsWithNames();

require_once("header.php");
?>

<h2>Admin Open Complaints</h2>

<!-- table to display records from the database -->
<!-- Complaints table -->
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Status</th>
        <th>Customer</th>
        <th>Technician</th>
        <th>Product/Service</th>
        <th>Complaint Type</th>
        <th>Created</th>
        <th>Actions</th>
    </tr>

<?php //loop through complaintList and build output ?>
<!-- Loop through complaints returned from controller -->
    <?php foreach ($complaintList as $complaintRow) { ?>
    <tr>
        <td><?php echo $complaintRow->getComplaintId(); ?></td>
        <td><?php echo $complaintRow->getStatus(); ?></td>

        <td><?php echo htmlspecialchars($complaintRow->getCustomerName()); ?></td>

        <td><?php echo htmlspecialchars($complaintRow->getEmployeeName()); ?></td>

        <td><?php echo $complaintRow->getProductServiceName(); ?></td>
        <td><?php echo $complaintRow->getComplaintTypeName(); ?></td>
        <td><?php echo $complaintRow->getCreatedAt(); ?></td>

        <td>
            <a class="action-link" href="admin_complaint_view.php?complaint_id=<?php echo $complaintRow->getComplaintId(); ?>">View</a>
            |
            <a class="action-link" href="admin_complaint_assign.php?complaint_id=<?php echo $complaintRow->getComplaintId(); ?>">Assign</a>
        </td>
    </tr>
<?php } ?>

</table>

<?php require_once("footer.php"); ?>