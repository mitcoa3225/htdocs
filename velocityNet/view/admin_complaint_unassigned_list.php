<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("admin");



// Admin Unassigned Complaints page. Shows tickets without a technician so they can be assigned.
// Admin Unassigned Complaints page.

require_once(__DIR__ . "/../controller/complaint_controller.php");

$complaintList = ComplaintController::getUnassignedOpenComplaintsWithNames();

require_once("header.php");
?>

<h2>Admin Unassigned Open Complaints</h2>

<?php if (count($complaintList) == 0) { ?>

    <p>No unassigned open complaints.</p>

<?php } else { ?>

<!-- table to display records from the database -->
<!-- Complaints table -->
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Status</th>
        <th>Customer</th>
        <th>Product/Service</th>
        <th>Complaint Type</th>
        <th>Created</th>
        <th>Assign</th>
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
            <td><a href="admin_complaint_assign.php?complaint_id=<?php echo $complaintRow->getComplaintId(); ?>">Assign</a></td>
        </tr>
    <?php } ?>
</table>

<?php } ?>

<?php require_once("footer.php"); ?>