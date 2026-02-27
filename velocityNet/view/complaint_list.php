<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("admin");

// Complaint List page.
// Shows tickets.

require_once(__DIR__ . "/../controller/complaint_controller.php");

// Handle delete requests.
$deleteMsg = "";

if (isset($_POST["delete_complaint_id"])) {

    $deleteId = (int)$_POST["delete_complaint_id"];

    if ($deleteId > 0) {
        $deleted = ComplaintController::deleteComplaint($deleteId);
        $deleteMsg = $deleted ? "Complaint deleted." : "Unable to delete complaint.";
    }
}

$complaintList = ComplaintController::getAllComplaintsWithNames();

require_once("header.php");
?>

<?php if ($deleteMsg !== "") { ?>
    <p><?php echo $deleteMsg; ?></p>
<?php } ?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="font-serif text-3xl md:text-4xl font-medium text-[#f5f3eb] mb-2">All Tickets</h1>
    <p class="text-stone-400">View and track all submitted support tickets</p>
</div>

<!-- Stats Summary -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <?php
    $totalCount = count($complaintList);
    $openCount = 0;
    $closedCount = 0;
    foreach ($complaintList as $c) {
        if (strtolower($c->getStatus()) == "open") $openCount++;
        else $closedCount++;
    }
    ?>
    <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-lg p-4">
        <p class="text-sm text-stone-500 mb-1">Total Tickets</p>
        <p class="font-serif text-2xl text-[#f5f3eb]"><?php echo $totalCount; ?></p>
    </div>
    <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-lg p-4">
        <p class="text-sm text-stone-500 mb-1">Open</p>
        <p class="font-serif text-2xl text-[#d4a84b]"><?php echo $openCount; ?></p>
    </div>
    <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-lg p-4">
        <p class="text-sm text-stone-500 mb-1">Resolved</p>
        <p class="font-serif text-2xl text-[#7cb369]"><?php echo $closedCount; ?></p>
    </div>
</div>

<!-- Complaints Table Card -->
<div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-xl overflow-hidden">
    <!-- Table Header -->
    <div class="px-6 py-4 border-b border-stone-700/50">
        <h2 class="font-serif text-lg text-[#f5f3eb]">Ticket List</h2>
    </div>

    <?php if (count($complaintList) > 0) { ?>
        <!--  Table Container -->
        <div class="overflow-x-auto">
<!-- table to display records from the database -->
            <table class="w-full">
                <thead>
                    <tr class="bg-[#151912]">
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Assigned To</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Product/Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Description</th>
                        
                        <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-700/50">
<?php //loop through complaintList and build output ?>
<!-- Loop through complaints returned from controller -->
                    <?php foreach ($complaintList as $complaintRow) { ?>
                        <tr class="hover:bg-[#252a21]/50 transition-colors">
                            <!-- Complaint ID -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-[#f5f3eb]">#<?php echo htmlspecialchars($complaintRow->getComplaintId()); ?></span>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $status = strtolower($complaintRow->getStatus());
                                $badgeClass = $status == "open"
                                    ? "bg-[#d4a84b]/15 text-[#d4a84b] border-[#d4a84b]/25"
                                    : "bg-[#7cb369]/15 text-[#7cb369] border-[#7cb369]/25";
                                ?>
                                <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full border <?php echo $badgeClass; ?>">
                                    <?php echo htmlspecialchars(ucfirst($complaintRow->getStatus())); ?>
                                </span>
                            </td>

                            <!-- Customer Name -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-stone-300"><?php echo htmlspecialchars($complaintRow->getCustomerName()); ?></span>
                            </td>

                            <!-- Technician Name -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if (!empty($complaintRow->getEmployeeName())) { ?>
                                    <span class="text-sm text-stone-300"><?php echo htmlspecialchars($complaintRow->getEmployeeName()); ?></span>
                                <?php } else { ?>
                                    <span class="text-sm text-stone-500 italic">Unassigned</span>
                                <?php } ?>
                            </td>

                            <!-- Product/Service -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-stone-400"><?php echo htmlspecialchars($complaintRow->getProductServiceName()); ?></span>
                            </td>

                            <!-- Complaint Type -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-stone-400"><?php echo htmlspecialchars($complaintRow->getComplaintTypeName()); ?></span>
                            </td>

                            <!-- Description  -->
                            <td class="px-6 py-4">
                                <p class="text-sm text-stone-400 max-w-xs truncate" title="<?php echo htmlspecialchars($complaintRow->getDescription()); ?>">
                                    <?php echo htmlspecialchars($complaintRow->getDescription()); ?>
                                </p>
                            </td>

                            <!-- Created Date -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="admin_complaint_view.php?complaint_id=<?php echo (int)$complaintRow->getComplaintId(); ?>" class="text-sm underline">View</a>

<!-- Confirm before running delete action -->
                                <form method="post" action="" style="display:inline;" onsubmit="return confirm('Delete this complaint?');">
                                    <input type="hidden" name="delete_complaint_id" value="<?php echo (int)$complaintRow->getComplaintId(); ?>">
                                    <button type="submit" class="text-sm underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <!-- Empty State -->
        <div class="text-center py-12 px-6">
            <svg class="w-12 h-12 text-stone-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="font-serif text-lg text-stone-300 mb-2">No tickets yet</h3>
            <p class="text-sm text-stone-500 mb-4">When support tickets are submitted, they'll appear here.</p>
            <a href="complaint_create.php" class="inline-flex items-center gap-2 bg-[#1d211a] hover:bg-[#252a21] text-[#f5f3eb] px-4 py-2 rounded-lg text-sm font-medium border border-stone-600 hover:border-stone-500 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Submit a Ticket
            </a>
        </div>
    <?php } ?>
</div>

<?php require_once("footer.php"); ?>