<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("customer");

// Customer Complaint View page.
// Shows one complaint and the current status/notes.

require_once(__DIR__ . "/../controller/complaint_controller.php");

Security::startSession();

$role = (isset($_SESSION["role"]) ? (string)$_SESSION["role"] : "");
$sessionUserIdNumber = isset($_SESSION["customer_id"]) ? (int)$_SESSION["customer_id"] : 0;

$complaintIdNumber = 0;
if (isset($_GET["complaint_id"])) $complaintIdNumber = (int)$_GET["complaint_id"];

$complaintRow = null;
if ($complaintIdNumber > 0) $complaintRow = ComplaintController::getComplaintById($complaintIdNumber);

//basic access rules for this page
$canView = false;
if ($complaintRow != null) {

    if ($role === "admin") {
        $canView = true;
    } else if ($role === "tech") {
        //techs can only view complaints assigned to them
        if ((int)$complaintRow->getEmployeeId() === $sessionUserIdNumber) $canView = true;
    } else if ($role === "customer") {
        //customers can only view their own complaints
        if ((int)$complaintRow->getCustomerId() === $sessionUserIdNumber) $canView = true;
    }
}

require_once("header.php");
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="font-serif text-3xl md:text-4xl font-medium text-[#f5f3eb] mb-2">Ticket Details</h1>
        <p class="text-stone-400">Review the complaint information and technician updates</p>
    </div>

    <?php if ($complaintIdNumber <= 0 || $complaintRow == null) { ?>
        <div class="bg-red-500/10 border border-red-500/30 text-red-200 text-sm rounded-lg px-4 py-3">
            Complaint not found.
        </div>
    <?php } else if (!$canView) { ?>
        <div class="bg-red-500/10 border border-red-500/30 text-red-200 text-sm rounded-lg px-4 py-3">
            This ticket cannot be viewed from the current account.
        </div>
    <?php } else { ?>

        <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-xl overflow-hidden">
            <div class="p-6 border-b border-stone-800">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="text-stone-400 text-sm">Ticket</div>
                        <div class="text-[#f5f3eb] text-2xl font-serif">#<?php echo $complaintRow->getComplaintId(); ?></div>
                    </div>

                    <div>
                        <?php
                            $status = strtolower($complaintRow->getStatus());
                            $badgeClass = "bg-stone-700/40 text-stone-300 border border-stone-600/50";
                            if ($status == "open") $badgeClass = "bg-[#a8b89a]/10 text-[#a8b89a] border border-[#a8b89a]/30";
                            if ($status == "closed") $badgeClass = "bg-stone-800/40 text-stone-300 border border-stone-700/50";
                        ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo $badgeClass; ?>">
                            <?php echo strtoupper($complaintRow->getStatus()); ?>
                        </span>
                    </div>
                </div>

            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <div class="text-stone-400 text-sm mb-1">Product/Service</div>
                    <div class="text-stone-200"><?php echo htmlspecialchars($complaintRow->getProductServiceName()); ?></div>
                </div>

                <div>
                    <div class="text-stone-400 text-sm mb-1">Complaint Type</div>
                    <div class="text-stone-200"><?php echo htmlspecialchars($complaintRow->getComplaintTypeName()); ?></div>
                </div>

                <div>
                    <div class="text-stone-400 text-sm mb-1">Created</div>
                    <div class="text-stone-200"><?php echo htmlspecialchars($complaintRow->getCreatedAt()); ?></div>
                </div>

                <div>
                    <div class="text-stone-400 text-sm mb-1">Assigned Technician</div>
                    <div class="text-stone-200"><?php echo htmlspecialchars($complaintRow->getEmployeeName()); ?></div>
                </div>

                <div class="md:col-span-2">
                    <div class="text-stone-400 text-sm mb-1">Description</div>
                    <div class="text-stone-200 whitespace-pre-wrap"><?php echo htmlspecialchars($complaintRow->getDescription()); ?></div>
                </div>

<!-- Only show attachment section if an image exists -->
                <?php if ($complaintRow->getImagePath() !== "") { ?>
                    <div class="md:col-span-2">
                        <div class="text-stone-400 text-sm mb-2">Uploaded Image</div>
                        <img src="../<?php echo htmlspecialchars($complaintRow->getImagePath()); ?>" alt="Complaint image" class="max-w-full rounded-lg border border-stone-700/50">
                    </div>
                <?php } ?>

                <div class="md:col-span-2">
                    <div class="text-stone-400 text-sm mb-1">Technician Notes</div>
                    <div class="text-stone-200 whitespace-pre-wrap">
                        <?php
                            $notes = trim((string)$complaintRow->getTechnicianNotes());
                            echo $notes === "" ? "No technician notes yet." : htmlspecialchars($notes);
                        ?>
                    </div>
                </div>

                <?php if (strtolower($complaintRow->getStatus()) === "closed") { ?>
                    <div>
                        <div class="text-stone-400 text-sm mb-1">Resolution Date</div>
                        <div class="text-stone-200"><?php echo htmlspecialchars($complaintRow->getResolutionDate()); ?></div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="text-stone-400 text-sm mb-1">Resolution Notes</div>
                        <div class="text-stone-200 whitespace-pre-wrap"><?php echo htmlspecialchars($complaintRow->getResolutionNotes()); ?></div>
                    </div>
                <?php } ?>

            </div>

            <div class="p-6 border-t border-stone-800">
                <?php if ($role === "customer") { ?>
                    <a href="customer_my_tickets.php" class="text-[#a8b89a] hover:text-[#f5f3eb] font-medium">Back to My Tickets</a>
                <?php } else if ($role === "tech") { ?>
                    <a href="technician_complaint_list.php" class="text-[#a8b89a] hover:text-[#f5f3eb] font-medium">Back to My Queue</a>
                <?php } else { ?>
                    <a href="admin_complaint_open_list.php" class="text-[#a8b89a] hover:text-[#f5f3eb] font-medium">Back to Open Tickets</a>
                <?php } ?>
            </div>
        </div>

    <?php } ?>
</div>

<?php require_once("footer.php"); ?>
