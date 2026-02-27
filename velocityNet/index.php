<?php
// Main landing page.
// Shows the homepage and links to the view pages.

require_once("view/header.php");
?>


    <!-- Hero Section -->
    <div class="hero text-center py-16 md:py-24">
        <!-- Announcement Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#1d211a] border border-stone-700/50 rounded-full text-sm text-stone-400 mb-8">
            <span>Welcome to VelocityNet support</span>
        </div>

        <!-- Hero Title -->
        <h1 class="font-serif text-4xl md:text-6xl lg:text-7xl font-medium text-[#f5f3eb] leading-tight mb-6 max-w-4xl mx-auto">
            Customer support that<br>feels like a conversation.
        </h1>

        <!-- Hero Subtitle -->
        <p class="text-lg text-stone-400 max-w-2xl mx-auto mb-10 leading-relaxed">
            Submit your concerns, track their progress, and get personalized responses from our support team , all in one place.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="view/register.php" class="bg-[#1d211a] hover:bg-[#252a21] text-[#f5f3eb] px-6 py-3 rounded-lg text-sm font-medium border border-stone-600 hover:border-stone-500 transition-all">
                Get started free
            </a>
            <a href="view/login.php" class="text-stone-400 hover:text-[#f5f3eb] text-sm font-medium flex items-center gap-2 transition-colors">
                Log in
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Product Preview -->
    <div class="max-w-5xl mx-auto px-4 pb-16">
        <div class="bg-[#1d211a] border border-stone-700/50 rounded-2xl p-4 md:p-6 shadow-2xl">
            <!-- Preview Window -->
            <div class="bg-[#151912] border border-stone-800 rounded-xl overflow-hidden">
                <!-- Window Header -->
                <div class="flex items-center gap-2 px-4 py-3 border-b border-stone-800">
                    <div class="flex gap-2">
                        <div class="w-3 h-3 rounded-full bg-stone-700"></div>
                        <div class="w-3 h-3 rounded-full bg-stone-700"></div>
                        <div class="w-3 h-3 rounded-full bg-stone-700"></div>
                    </div>
                </div>

                <!-- Preview Content - Inbox Layout -->
                <div class="flex min-h-[400px]">
                    <!-- Sidebar -->
                    <div class="hidden md:block w-48 border-r border-stone-800 p-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2 px-3 py-2 bg-[#1d211a] rounded-md text-[#f5f3eb] text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                Inbox
                            </div>
                            <div class="flex items-center gap-2 px-3 py-2 text-stone-500 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Assigned
                            </div>
                            <div class="flex items-center gap-2 px-3 py-2 text-stone-500 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                                Archived
                            </div>
                        </div>
                    </div>

                    <!-- Ticket List -->
                    <div class="flex-1 border-r border-stone-800">
                        <div class="p-4 border-b border-stone-800">
                            <h3 class="text-sm font-medium text-stone-300">Your Inbox</h3>
                        </div>
                        <div class="divide-y divide-stone-800">
                            <div class="p-4 bg-[#1d211a]/50 border-l-2 border-[#a8b89a]">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-sm font-medium text-[#f5f3eb]">Login issue with account</span>
                                    <span class="text-xs text-stone-500">2h ago</span>
                                </div>
                                <p class="text-xs text-stone-500 truncate">Unable to access my account after password reset...</p>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-sm text-stone-400">Billing question</span>
                                    <span class="text-xs text-stone-600">1d ago</span>
                                </div>
                                <p class="text-xs text-stone-600 truncate">Question about recent invoice charges...</p>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-sm text-stone-400">Feature request</span>
                                    <span class="text-xs text-stone-600">3d ago</span>
                                </div>
                                <p class="text-xs text-stone-600 truncate">Would love to see dark mode support...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Detail -->
                    <div class="hidden lg:block flex-1 p-4">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs px-2 py-1 bg-[#7cb369]/20 text-[#7cb369] rounded-full">In Progress</span>
                            <span class="text-xs text-stone-500">Ticket #1024</span>
                        </div>
                        <h4 class="text-sm font-medium text-[#f5f3eb] mb-2">Login issue with account</h4>
                        <p class="text-xs text-stone-500 mb-4">Submitted by customer@email.com</p>
                        <div class="bg-[#0d0f0a] rounded-lg p-3 text-xs text-stone-400">
                            Hi Support,<br><br>
                            I'm unable to access my account after resetting my password. The new password doesn't seem to work...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

require_once("view/footer.php");
?>
