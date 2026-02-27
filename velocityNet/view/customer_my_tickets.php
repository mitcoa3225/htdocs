<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("customer");

// Customer ticket list page.
// Shows tickets for the logged in customer only.

require_once(__DIR__ . "/../controller/complaint_controller.php");

Security::startSession();

// Get the logged in customer id from the session.
$customerIdNumber = (int)$_SESSION["customer_id"];


$ticketList = array();
if ($customerIdNumber > 0) $ticketList = ComplaintController::getComplaintsByCustomerIdWithNames($customerIdNumber);

require_once("header.php");
?>

<div class="mb-8">
    <h1 class="font-serif text-3xl md:text-4xl font-medium text-[#f5f3eb] mb-2">My Tickets</h1>
    <p class="text-stone-400">Tickets submitted from this account</p>
</div>

<div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <!-- Tickets table -->
<table class="min-w-full divide-y divide-stone-800">
            <thead class="bg-[#151912]">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-stone-400 uppercase tracking-wider">Ticket</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-stone-400 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-stone-400 uppercase tracking-wider">Product/Service</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-stone-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-stone-400 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-stone-400 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-800">
                <?php if (count($ticketList) == 0) { ?>
                    <tr>
                        <td colspan="6" class="px-6 py-6 text-stone-400">
                            No tickets found yet.
                        </td>
                    </tr>
                <?php } else { ?>
<!-- Loop through list returned from controller -->
                    <?php foreach ($ticketList as $t) { ?>
                        <tr class="hover:bg-[#252a21]/30 transition-colors">
                            <td class="px-6 py-4 text-sm text-[#f5f3eb]">#<?php echo $t->getComplaintId(); ?></td>
                            <td class="px-6 py-4 text-sm text-stone-300"><?php echo htmlspecialchars($t->getComplaintTypeName()); ?></td>
                            <td class="px-6 py-4 text-sm text-stone-300"><?php echo htmlspecialchars($t->getProductServiceName()); ?></td>
                            <td class="px-6 py-4 text-sm">
                                <?php
                                    $status = strtolower($t->getStatus());
                                    $badgeClass = "bg-stone-700/40 text-stone-300 border border-stone-600/50";
                                    if ($status == "open") $badgeClass = "bg-[#a8b89a]/10 text-[#a8b89a] border border-[#a8b89a]/30";
                                    if ($status == "closed") $badgeClass = "bg-stone-800/40 text-stone-300 border border-stone-700/50";
                                ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo $badgeClass; ?>">
                                    <?php echo strtoupper($t->getStatus()); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-stone-400">
                                <?php echo htmlspecialchars($t->getCreatedAt()); ?>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a <!-- Link to ticket details -->
                <a class="action-link" href="customer_complaint_view.php?complaint_id=<?php echo $t->getComplaintId(); ?>" class="text-[#a8b89a] hover:text-[#f5f3eb] font-medium">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once("footer.php"); ?>