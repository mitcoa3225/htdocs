<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::startSession();

// Access denied page.
// Shows a simple message when a user tries to open a page they do not have access to.

require_once("header.php");
?>

<!-- Message shown when a user does not have permission for a page -->
<div class="max-w-2xl mx-auto">
    <div class="bg-[#1d211a]/60 border border-stone-700/50 rounded-xl p-8">
        <h1 class="font-serif text-3xl font-medium text-[#f5f3eb] mb-3">Access denied</h1>
        <p class="text-stone-400 mb-6">
            This account does not have permission to view that page.
        </p>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="<?php echo $homeHref; ?>" class="bg-[#1d211a] hover:bg-[#252a21] text-[#f5f3eb] px-5 py-3 rounded-lg text-sm font-medium border border-stone-700 hover:border-stone-600 transition-all text-center">
                Go to homepage
            </a>
            <a href="<?php echo $viewPrefix; ?>sitemap.php" class="text-stone-400 hover:text-[#f5f3eb] px-5 py-3 rounded-lg text-sm font-medium border border-stone-800 hover:border-stone-700 transition-all text-center">
                View site map
            </a>
        </div>
    </div>
</div>

<?php require_once("footer.php"); ?>