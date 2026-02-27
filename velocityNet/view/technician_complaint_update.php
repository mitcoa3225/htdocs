<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("tech");

// Technician Complaint Update page.
// Updates technician notes, status, and resolution fields.

require_once(__DIR__ . "/../controller/complaint_controller.php");

Security::startSession();

$errorMessage = "";
$successMessage = "";

$complaintIdNumber = isset($_GET["complaint_id"]) ? (int)$_GET["complaint_id"] : 0;
$employeeIdNumber = isset($_SESSION["employee_id"]) ? (int)$_SESSION["employee_id"] : 0;

$technicianNotesText = "";
$statusText = "";
$resolutionDateText = "";
$resolutionNotesText = "";

$complaintRow = null;
if ($complaintIdNumber > 0) $complaintRow = ComplaintController::getComplaintById($complaintIdNumber);

//techs can only update complaints assigned to them
if ($complaintRow != null && (isset($_SESSION["role"]) ? (string)$_SESSION["role"] : "") === "tech") {
    if ((int)$complaintRow->getEmployeeId() !== $employeeIdNumber) {
        $complaintRow = null;
        $errorMessage = "This complaint is not assigned to the current technician.";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $technicianNotesText = trim((string)($_POST["technician_notes"] ?? ""));
    $statusText = trim((string)($_POST["status"] ?? ""));
    $resolutionDateText = trim((string)($_POST["resolution_date"] ?? ""));
    $resolutionNotesText = trim((string)($_POST["resolution_notes"] ?? ""));

    if ($complaintIdNumber <= 0) {
        $errorMessage = "Missing complaint id.";
    } else if ($statusText !== "open" && $statusText !== "closed") {
        $errorMessage = "Select a valid status.";
    } else {

        //when closing, resolution notes are required
        if ($statusText === "closed") {

            if ($resolutionNotesText === "") {
                $errorMessage = "Resolution notes are required when closing a complaint.";
            } else if ($resolutionDateText === "") {
                $errorMessage = "Resolution date is required when closing a complaint.";
            } else if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $resolutionDateText)) {
                $errorMessage = "Resolution date must be in YYYY-MM-DD format.";
            }
        }

        if ($errorMessage === "") {

            $ok = ComplaintController::updateComplaintTechnicianFields(
                $complaintIdNumber,
                $technicianNotesText,
                $statusText,
                $resolutionDateText,
                $resolutionNotesText
            );

            if ($ok) {
                $successMessage = "Complaint updated.";
                $complaintRow = ComplaintController::getComplaintById($complaintIdNumber);
            } else {
                $errorMessage = "Update failed.";
            }
        }
    }
}

require_once("header.php");
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="font-serif text-3xl md:text-4xl font-medium text-[#f5f3eb] mb-2">Update Ticket</h1>
        <p class="text-stone-400">Add notes and close the ticket when resolved</p>
    </div>

    <?php if ($errorMessage !== "") { ?>
        <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-200 text-sm rounded-lg px-4 py-3">
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php } ?>

    <?php if ($successMessage !== "") { ?>
        <div class="mb-6 bg-green-500/10 border border-green-500/30 text-green-200 text-sm rounded-lg px-4 py-3">
            <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php } ?>

    <?php if ($complaintRow == null) { ?>
        <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-xl p-8">
            <p class="text-stone-400">Ticket not found.</p>
            <div class="mt-6">
                <a href="technician_complaint_list.php" class="text-[#a8b89a] hover:text-[#f5f3eb] font-medium">Back to My Queue</a>
            </div>
        </div>
    <?php } else { ?>

        <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-xl overflow-hidden">

            <div class="p-6 border-b border-stone-800">
                <div class="text-stone-400 text-sm">Ticket</div>
                <div class="text-[#f5f3eb] text-2xl font-serif">#<?php echo $complaintRow->getComplaintId(); ?></div>
            </div>

            <div class="p-6 space-y-6">

                <div>
                    <div class="text-stone-400 text-sm mb-1">Customer</div>
                    <div class="text-stone-200"><?php echo htmlspecialchars($complaintRow->getCustomerName()); ?></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="text-stone-400 text-sm mb-1">Type</div>
                        <div class="text-stone-200"><?php echo htmlspecialchars($complaintRow->getComplaintTypeName()); ?></div>
                    </div>
                    <div>
                        <div class="text-stone-400 text-sm mb-1">Product/Service</div>
                        <div class="text-stone-200"><?php echo htmlspecialchars($complaintRow->getProductServiceName()); ?></div>
                    </div>
                </div>

                <div>
                    <div class="text-stone-400 text-sm mb-1">Customer Description</div>
                    <div class="text-stone-200 whitespace-pre-wrap"><?php echo htmlspecialchars($complaintRow->getDescription()); ?></div>
                </div>

<!-- Only show attachment section if an image exists -->
                <?php if ($complaintRow->getImagePath() !== "") { ?>
                    <div>
                        <div class="text-stone-400 text-sm mb-2">Uploaded Image</div>
                        <img src="../<?php echo htmlspecialchars($complaintRow->getImagePath()); ?>" alt="Complaint image" class="max-w-full rounded-lg border border-stone-700/50">
                    </div>
                <?php } ?>

                <!-- form to update complaint status and notes -->
                <form action="technician_complaint_update.php?complaint_id=<?php echo $complaintIdNumber; ?>" method="post" class="space-y-6">

                    <div>
                        <label class="block text-sm font-medium text-stone-300 mb-2">Technician Notes</label>
                        <textarea name="technician_notes" rows="6" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"><?php
                            $fillNotes = $technicianNotesText !== "" ? $technicianNotesText : (string)$complaintRow->getTechnicianNotes();
                            echo htmlspecialchars($fillNotes);
                        ?></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-stone-300 mb-2">Status</label>
                            <select name="status" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200">
                                <?php $currentStatus = $statusText !== "" ? $statusText : (string)$complaintRow->getStatus(); ?>
                                <option value="open" <?php if ($currentStatus === "open") echo "selected"; ?>>open</option>
                                <option value="closed" <?php if ($currentStatus === "closed") echo "selected"; ?>>closed</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-stone-300 mb-2">Resolution Date</label>
                            <input type="text" name="resolution_date" placeholder="YYYY-MM-DD" value="<?php
                                $fillDate = $resolutionDateText !== "" ? $resolutionDateText : (string)$complaintRow->getResolutionDate();
                                echo htmlspecialchars($fillDate);
                            ?>" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-stone-300 mb-2">Resolution Notes</label>
                            <textarea name="resolution_notes" rows="3" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"><?php
                                $fillResNotes = $resolutionNotesText !== "" ? $resolutionNotesText : (string)$complaintRow->getResolutionNotes();
                                echo htmlspecialchars($fillResNotes);
                            ?></textarea>
                        </div>
                    </div>

                    <button type="submit" class="bg-[#a8b89a] hover:bg-[#9ba662] text-[#0d0f0a] py-3 px-5 rounded-lg text-sm font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                        Save changes
                    </button>

                </form>

            </div>

            <div class="p-6 border-t border-stone-800">
                <a href="technician_complaint_list.php" class="text-[#a8b89a] hover:text-[#f5f3eb] font-medium">Back to My Queue</a>
            </div>

        </div>

    <?php } ?>
</div>

<?php require_once("footer.php"); ?>
