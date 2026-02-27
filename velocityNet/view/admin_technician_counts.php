<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("admin");

// Admin Technician Counts page.
// Shows open complaint counts per technician.

require_once(__DIR__ . "/../controller/complaint_controller.php");

$countList = ComplaintController::getTechnicianOpenComplaintCounts();

require_once("header.php");
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-white mb-2">Technician Workload Overview</h1>
    <p class="text-gray-400">Monitor open complaint assignments across your technical team</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-500/20 rounded-lg">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM9 3a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-400">Active Technicians</p>
                <p class="text-2xl font-bold text-white"><?php echo count($countList); ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl p-6">
        <div class="flex items-center">
            <div class="p-3 bg-orange-500/20 rounded-lg">
                <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-400">Total Open Complaints</p>
                <p class="text-2xl font-bold text-white"><?php echo array_sum(array_column($countList, 'open_count')); ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-500/20 rounded-lg">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-400">Average per Technician</p>
                <p class="text-2xl font-bold text-white">
                    <?php echo count($countList) > 0 ? round(array_sum(array_column($countList, 'open_count')) / count($countList), 1) : 0; ?>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Technician Table -->
<div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl shadow-xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-700">
        <h3 class="text-lg font-semibold text-white">Technician Assignments</h3>
        <p class="text-sm text-gray-400 mt-1">Current workload distribution across all technicians</p>
    </div>
    
    <div class="overflow-x-auto">
<!-- table to display records from the database -->
        <table class="w-full">
            <thead class="bg-gray-900/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Employee ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Technician</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Open Complaints</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
<?php //loop through countList and build output ?>
<!-- Loop through list returned from controller -->
                <?php foreach ($countList as $countRow) { ?>
                    <tr class="hover:bg-gray-700/30 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-300"><?php echo $countRow["employee_id"]; ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-400"><?php echo htmlspecialchars($countRow["user_id"]); ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">
                                            <?php echo substr($countRow["first_name"], 0, 1) . substr($countRow["last_name"], 0, 1); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-white">
                                        <?php echo htmlspecialchars($countRow["last_name"]); ?>, <?php echo htmlspecialchars($countRow["first_name"]); ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php 
                            $count = $countRow["open_count"];
                            $badgeColor = $count == 0 ? 'bg-green-500/20 text-green-400' : 
                                         ($count <= 3 ? 'bg-yellow-500/20 text-yellow-400' : 
                                          'bg-red-500/20 text-red-400');
                            ?>
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium <?php echo $badgeColor; ?>">
                                <?php echo $count; ?> complaints
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="technician_complaint_list.php?employee_id=<?php echo $countRow["employee_id"]; ?>" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Details
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
    <?php if (empty($countList)) { ?>
        <div class="px-6 py-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM9 3a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-300">No technicians found</h3>
            <p class="mt-1 text-sm text-gray-400">Get started by adding technicians to your system.</p>
        </div>
    <?php } ?>
</div>

<?php require_once("footer.php"); ?>