<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("admin");

// Admin Complaint Assign page.
// Lets admin assign a technician to a complaint.

require_once(__DIR__ . "/../controller/complaint_controller.php");
require_once(__DIR__ . "/../controller/lists_controller.php");

$errorMessage = "";
$successMessage = "";

// current selected complaint (from link or after submit)
$complaintIdNumber = 0;
if (isset($_GET["complaint_id"])) {
    $complaintIdNumber = (int)$_GET["complaint_id"];
}

// dropdown lists
$complaintList = ComplaintController::getUnassignedOpenComplaintsWithNames();
if (!is_array($complaintList)) {
    $complaintList = array();
}

$technicianList = ListsController::getAllTechnicians();
if (!is_array($technicianList)) {
    $technicianList = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // on submit, use the posted complaint id
    $complaintIdNumber = (int)($_POST["complaint_id"] ?? 0);
    $employeeIdNumber = (int)($_POST["employee_id"] ?? 0);

    if ($complaintIdNumber <= 0 || $employeeIdNumber <= 0) {
        $errorMessage = "Pick a complaint and a technician.";
    } else {
        $ok = ComplaintController::assignComplaintToTechnician($complaintIdNumber, $employeeIdNumber);

        if ($ok) {
            $successMessage = "Technician assigned.";

            // refresh list after assigning
            $complaintList = ComplaintController::getUnassignedOpenComplaintsWithNames();
            if (!is_array($complaintList)) {
                $complaintList = array();
            }
        } else {
            $errorMessage = "Assign failed.";
        }
    }
}

require_once(__DIR__ . "/header.php");
?>

<h2>Admin Assign Complaint</h2>

<?php if ($errorMessage != "") { ?><p><?php echo $errorMessage; ?></p><?php } ?>
<?php if ($successMessage != "") { ?><p><?php echo $successMessage; ?></p><?php } ?>

<?php if (count($complaintList) == 0) { ?>

    <p>No unassigned open complaints.</p>

<?php } else { ?>

<!-- form to assign a complaint to a technician -->
<form action="admin_complaint_assign.php" method="post">

    <label>Unassigned Open Complaint</label><br>
    <!-- dropdown list built from database values -->
    <select name="complaint_id">
        <option value="0">Select</option>

<!-- Loop through complaints returned from controller -->
        <?php foreach ($complaintList as $complaintRow) { ?>
            <?php
            // Pre-select complaint if complaint_id is passed in URL or after submit.
            $isSelectedText = "";
            if ($complaintIdNumber != 0 && $complaintRow->getComplaintId() == $complaintIdNumber) {
                $isSelectedText = "selected";
            }
            ?>

            <option value="<?php echo $complaintRow->getComplaintId(); ?>" <?php echo $isSelectedText; ?>>
                <?php echo $complaintRow->getComplaintId(); ?> - <?php echo $complaintRow->getCustomerName(); ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Technician</label><br>
    <!-- dropdown list built from database values -->
    <select name="employee_id">
        <option value="0">Select</option>

<!-- Loop through employees returned from controller -->
        <?php foreach ($technicianList as $technicianRow) { ?>
            <option value="<?php echo $technicianRow->getEmployeeId(); ?>">
                <?php echo $technicianRow->getLastName(); ?>, <?php echo $technicianRow->getFirstName(); ?> (<?php echo $technicianRow->getEmail(); ?>)
            </option>
        <?php } ?>
    </select>

    <br><br>

    <input type="submit" value="Assign Complaint">

        </form>
        <?php } ?>
    <?php require_once(__DIR__ . "/footer.php"); ?>
