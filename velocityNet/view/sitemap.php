<?php
// Sitemap page.
// Displays output for this part of the site.
// Uses controller/model data to fill in the page.

require_once("header.php");
?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="font-serif text-3xl md:text-4xl font-medium text-[#f5f3eb] mb-2">Site Map</h1>
    <p class="text-stone-400">Quick access to all pages in the system</p>
</div>

<!-- Site Map Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    <!-- Public Pages -->
    <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-[#a8b89a]/20 rounded-lg">
                <svg class="w-5 h-5 text-[#a8b89a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <h2 class="font-serif text-lg text-[#f5f3eb]">Public</h2>
        </div>
        <ul class="space-y-2">
            <li>
                <a href="<?php echo $homeHref; ?>" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <a href="<?php echo $viewPrefix; ?>login.php" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Login
                </a>
            </li>
            <li>
                <a href="<?php echo $viewPrefix; ?>register.php" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Register
                </a>
            </li>
        </ul>
    </div>

    <!-- Customer Pages -->
    <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-[#6b9dad]/20 rounded-lg">
                <svg class="w-5 h-5 text-[#6b9dad]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h2 class="font-serif text-lg text-[#f5f3eb]">Customer</h2>
        </div>
        <ul class="space-y-2">
            <li>
                <a href="<?php echo $viewPrefix; ?>complaint_create.php" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Submit Complaint
                </a>
            </li>
            <li>
                <a href="<?php echo $viewPrefix; ?>complaint_list.php" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    View All Complaints
                </a>
            </li>
        </ul>
    </div>

    <!-- Technician Pages -->
    <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-[#d4a84b]/20 rounded-lg">
                <svg class="w-5 h-5 text-[#d4a84b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h2 class="font-serif text-lg text-[#f5f3eb]">Technician</h2>
        </div>
        <ul class="space-y-2">
            <li>
                <a href="<?php echo $viewPrefix; ?>technician_complaint_list.php?employee_id=1" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    My Complaints
                </a>
            </li>
            <li>
                <a href="<?php echo $viewPrefix; ?>technician_password_change.php" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Change Password
                </a>
            </li>
        </ul>
    </div>

    <!-- Admin User Management -->
    <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-[#c75d5d]/20 rounded-lg">
                <svg class="w-5 h-5 text-[#c75d5d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <h2 class="font-serif text-lg text-[#f5f3eb]">Admin - Users</h2>
        </div>
        <ul class="space-y-2">
            <li>
                <a href="<?php echo $viewPrefix; ?>admin_customer_list.php" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Customer List
                </a>
            </li>
            <li>
                <a href="<?php echo $viewPrefix; ?>admin_customer_add.php" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Add Customer
                </a>
            </li>
            <li>
                <a href="<?php echo $viewPrefix; ?>admin_employee_list.php" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Employee List
                </a>
            </li>
        </ul>
    </div>

    <!-- Admin Complaints -->
    <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-[#7cb369]/20 rounded-lg">
                <svg class="w-5 h-5 text-[#7cb369]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h2 class="font-serif text-lg text-[#f5f3eb]">Admin - Tickets</h2>
        </div>
        <ul class="space-y-2">
            <li>
                <a href="<?php echo $viewPrefix; ?>admin_complaint_open_list.php" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Open Complaints
                </a>
            </li>
            <li>
                <a href="<?php echo $viewPrefix; ?>admin_complaint_unassigned_list.php" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Unassigned Complaints
                </a>
            </li>
            <li>
                <a href="<?php echo $viewPrefix; ?>admin_complaint_assign.php" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Assign Complaint
                </a>
            </li>
        </ul>
    </div>

    <!-- Admin Reports -->
    <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-[#a8b89a]/20 rounded-lg">
                <svg class="w-5 h-5 text-[#a8b89a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h2 class="font-serif text-lg text-[#f5f3eb]">Admin - Reports</h2>
        </div>
        <ul class="space-y-2">
            <li>
                <a href="<?php echo $viewPrefix; ?>admin_technician_counts.php" class="flex items-center gap-2 text-sm text-stone-400 hover:text-[#a8b89a] transition-colors py-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Technician Workload
                </a>
            </li>
        </ul>
    </div>

</div>

<?php require_once("footer.php"); ?>