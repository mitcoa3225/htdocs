<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("admin");

// Admin Complaint View page.
// Shows one complaint with full details and admin actions.

require_once(__DIR__ . "/../controller/complaint_controller.php");

$deleteMsg = "";

$complaintIdNumber = 0;
if (isset($_GET["complaint_id"])) $complaintIdNumber = (int)$_GET["complaint_id"];

// Handle delete requests.
if (isset($_POST["delete_complaint_id"])) {

    $deleteId = (int)$_POST["delete_complaint_id"];

    if ($deleteId > 0) {
        $deleted = ComplaintController::deleteComplaint($deleteId);
        $deleteMsg = $deleted ? "Complaint deleted." : "Unable to delete complaint.";

        if ($deleted) {
            header("Location: complaint_list.php");
            exit;
        }
    }
}

$complaintRow = null;
if ($complaintIdNumber > 0) $complaintRow = ComplaintController::getComplaintById($complaintIdNumber);

require_once("header.php");
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="font-serif text-3xl md:text-4xl font-medium text-[#f5f3eb] mb-2">Ticket Details</h1>
        <p class="text-stone-400">Review the complaint information, status, and technician notes</p>
    </div>

    <?php if ($deleteMsg !== "") { ?>
        <p><?php echo $deleteMsg; ?></p>
    <?php } ?>

    <?php if ($complaintIdNumber <= 0 || $complaintRow == null) { ?>
        <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-lg p-6">
            <p class="text-stone-400">Ticket not found.</p>
            <p class="mt-4"><a class="underline" href="complaint_list.php">Back to tickets</a></p>
        </div>
    <?php } else { ?>

        <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-lg overflow-hidden">

            <div class="p-6 border-b border-stone-700/50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <p class="text-sm text-stone-500">Ticket ID</p>
                        <p class="text-[#f5f3eb] text-lg font-medium">#<?php echo (int)$complaintRow->getComplaintId(); ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-stone-500">Status</p>
                        <p class="text-[#f5f3eb] text-lg font-medium"><?php echo htmlspecialchars($complaintRow->getStatus()); ?></p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">

                <div>
                    <p class="text-sm text-stone-500 mb-1">Customer</p>
                    <p class="text-[#f5f3eb]"><?php echo htmlspecialchars($complaintRow->getCustomerName()); ?></p>
                </div>

                <div>
                    <p class="text-sm text-stone-500 mb-1">Assigned Technician</p>
                    <p class="text-[#f5f3eb]">
                        <?php
                        $empName = $complaintRow->getEmployeeName();
                        echo ($empName === null || $empName === "") ? "Unassigned" : htmlspecialchars($empName);
                        ?>
                    </p>
                </div>

                <!-- Complaint details -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-stone-500 mb-1">Product / Service</p>
                        <p class="text-[#f5f3eb]"><?php echo htmlspecialchars($complaintRow->getProductServiceName()); ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-stone-500 mb-1">Complaint Type</p>
                        <p class="text-[#f5f3eb]"><?php echo htmlspecialchars($complaintRow->getComplaintTypeName()); ?></p>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-stone-500 mb-1">Description</p>
                    <p class="text-[#f5f3eb] whitespace-pre-line"><?php echo htmlspecialchars($complaintRow->getDescription()); ?></p>
                </div>

<!-- Only show attachment section if an image exists -->
                <?php if ($complaintRow->getImagePath() != null && $complaintRow->getImagePath() !== "") { ?>
                    <div>
                        <p class="text-sm text-stone-500 mb-2">Attachment</p>
                        <img src="../<?php echo htmlspecialchars($complaintRow->getImagePath()); ?>" alt="Complaint attachment" <!-- Attachment preview --> class="max-w-full rounded-lg border border-stone-700/50">
                    </div>
                <?php } ?>

                <div>
                    <p class="text-sm text-stone-500 mb-1">Technician Notes</p>
                    <p class="text-[#f5f3eb] whitespace-pre-line">
                        <?php
                        $notes = $complaintRow->getTechnicianNotes();
                        echo ($notes === null || $notes === "") ? "No notes yet." : htmlspecialchars($notes);
                        ?>
                    </p>
                </div>

                <div>
                    <p class="text-sm text-stone-500 mb-1">Resolution Notes</p>
                    <p class="text-[#f5f3eb] whitespace-pre-line">
                        <?php
                        $res = $complaintRow->getResolutionNotes();
                        echo ($res === null || $res === "") ? "Not resolved yet." : htmlspecialchars($res);
                        ?>
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                    <p class="text-sm text-stone-500">Created: <?php echo htmlspecialchars($complaintRow->getCreatedAt()); ?></p>

                    <div class="flex items-center gap-3">
                        <a class="underline" href="complaint_list.php">Back</a>

<!-- Confirm before running delete action -->
                        <form method="post" action="" onsubmit="return confirm('Delete this complaint?');" <!-- Confirm before deleting complaint -->>
                            <input type="hidden" name="delete_complaint_id" value="<?php echo (int)$complaintRow->getComplaintId(); ?>">
                            <button type="submit" class="underline">Delete</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    <?php } ?>

</div>

<?php require_once("footer.php"); ?>
