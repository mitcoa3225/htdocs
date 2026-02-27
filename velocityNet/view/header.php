<?php
// Header page.
// Displays the top navigation and opens the HTML layout.
// Also starts the session so login state is available everywhere.

require_once(__DIR__ . "/../util/security.php");

//check if current file is inside view folder
//adjusts relative paths so links dont break

//true if current page path contains /view/
$inViewFolder = (strpos($_SERVER["PHP_SELF"], "/view/") !== false);
//set corrrect link to home depending on folder location
$homeHref = $inViewFolder ? "../index.php" : "index.php";
//prefix used when linking to view folder
$viewPrefix = $inViewFolder ? "" : "view/";
$assetPrefix = $inViewFolder ? "../" : "";

Security::checkHTTPS();

// Enforce role access rules based on the current file name.
$pageFileName = basename($_SERVER["PHP_SELF"]);
// Current user info for the header.
$isLoggedIn = ((isset($_SESSION["admin"]) && $_SESSION["admin"]===true) || (isset($_SESSION["tech"]) && $_SESSION["tech"]===true) || (isset($_SESSION["customer"]) && $_SESSION["customer"]===true));
$role = (isset($_SESSION["role"]) ? (string)$_SESSION["role"] : "");
$displayName = (isset($_SESSION["display_name"]) ? (string)$_SESSION["display_name"] : "");

// Build nav links based on role.
$leftLinks = array();
$rightLinks = array();

if (!$isLoggedIn) {

    $leftLinks = array(
        array("label" => "Submit", "href" => $viewPrefix . "complaint_create.php")
    );

    $rightLinks = array(
        array("label" => "Log in", "href" => $viewPrefix . "login.php", "type" => "link"),
        array("label" => "Get started", "href" => $viewPrefix . "register.php", "type" => "button")
    );

} else if ($role === "customer") {

    $leftLinks = array(
        array("label" => "Submit", "href" => $viewPrefix . "complaint_create.php"),
        array("label" => "My Tickets", "href" => $viewPrefix . "customer_my_tickets.php"),
        array("label" => "Profile", "href" => $viewPrefix . "customer_profile_edit.php")
    );

    $rightLinks = array(
        array("label" => $displayName, "href" => "#", "type" => "label"),
        array("label" => "Log out", "href" => $viewPrefix . "logout.php", "type" => "link")
    );

} else if ($role === "tech") {

    $leftLinks = array(
        array("label" => "My Queue", "href" => $viewPrefix . "technician_complaint_list.php"),
        array("label" => "Profile", "href" => $viewPrefix . "technician_password_change.php")
    );

    $rightLinks = array(
        array("label" => $displayName . " (Tech)", "href" => "#", "type" => "label"),
        array("label" => "Log out", "href" => $viewPrefix . "logout.php", "type" => "link")
    );

} else if ($role === "admin") {

    $leftLinks = array(
        array("label" => "Unassigned", "href" => $viewPrefix . "admin_complaint_unassigned_list.php"),
        array("label" => "Open Tickets", "href" => $viewPrefix . "admin_complaint_open_list.php"),
        array("label" => "Assign", "href" => $viewPrefix . "admin_complaint_assign.php"),
        array("label" => "Customers", "href" => $viewPrefix . "admin_customer_list.php"),
        array("label" => "Employees", "href" => $viewPrefix . "admin_employee_list.php"),
        array("label" => "Tech Counts", "href" => $viewPrefix . "admin_technician_counts.php"),
        array("label" => "Profile", "href" => $viewPrefix . "admin_profile.php")
    );

    $rightLinks = array(
        array("label" => $displayName . " (Admin)", "href" => "#", "type" => "label"),
        array("label" => "Log out", "href" => $viewPrefix . "logout.php", "type" => "link")
    );
}
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VelocityNet - Customer Support</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $assetPrefix; ?>frontend/css/main.css">
    <script src="<?php echo $assetPrefix; ?>frontend/js/main.js" defer></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'serif': ['Playfair Display', 'Georgia', 'serif'],
                        'sans': ['Inter', 'system-ui', 'sans-serif']
                    },
                    colors: {
                        primary: {
                            50: '#f7f8f3',
                            100: '#e8ebd9',
                            200: '#d1d7b3',
                            300: '#b5be85',
                            400: '#9ba662',
                            500: '#7d8a47',
                            600: '#626d38',
                            700: '#4d552e',
                            800: '#414728',
                            900: '#383d25'
                        },
                        dark: {
                            50: '#0d0f0a',
                            100: '#151912',
                            200: '#1d211a',
                            300: '#252a21',
                            400: '#333430',
                            500: '#4a4b47',
                            600: '#6e6f6a',
                            700: '#9a9b95',
                            800: '#c8c9c4',
                            900: '#f5f3eb'
                        },
                        cream: '#f5f3eb',
                        sage: '#a8b89a',
                        moss: '#5c6b4f'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background: linear-gradient(135deg, #0d0f0a 0%, #151912 50%, #0d0f0a 100%);
            min-height: 100vh;
            font-family: 'Inter', system-ui, sans-serif;
        }
        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }
    </style>
</head>
<body class="text-stone-300 antialiased">
    <!-- Navigation Header -->
    <nav class="border-b border-stone-800/50 sticky top-0 z-50 backdrop-blur-sm bg-[#0d0f0a]/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16">

                <!-- Left Navigation Links -->
                <div class="hidden md:flex items-center space-x-4 overflow-x-auto whitespace-nowrap pr-4 flex-1 header-scroll">
<!-- Loop through list returned from controller -->
                    <?php foreach ($leftLinks as $l) { ?>
                        <a href="<?php echo $l["href"]; ?>" class="text-stone-400 hover:text-stone-200 text-sm font-medium transition-colors duration-200">
                            <?php echo $l["label"]; ?>
                        </a>
                    <?php } ?>
                </div>

                <!-- Center Logo -->
                <div class="flex-none px-3">
                    <a href="<?php echo $homeHref; ?>" class="font-serif text-2xl font-medium text-[#f5f3eb] tracking-tight hover:opacity-80 transition-opacity whitespace-nowrap">
                        VelocityNet
                    </a>
                </div>

                <!-- Right Links -->
                <div class="hidden md:flex items-center space-x-4 pl-4 flex-1 justify-end header-scroll overflow-x-auto whitespace-nowrap">
<!-- Loop through list returned from controller -->
                    <?php foreach ($rightLinks as $r) { ?>
                        <?php if ($r["type"] === "button") { ?>
                            <a href="<?php echo $r["href"]; ?>" class="bg-[#1d211a] hover:bg-[#252a21] text-[#f5f3eb] px-4 py-2 rounded-full text-sm font-medium border border-stone-700 hover:border-stone-600 transition-all duration-200">
                                <?php echo $r["label"]; ?>
                            </a>
                        <?php } else if ($r["type"] === "label") { ?>
                            <span class="text-stone-400 text-sm font-medium">
                                <?php echo htmlspecialchars($r["label"]); ?>
                            </span>
                        <?php } else { ?>
                            <a href="<?php echo $r["href"]; ?>" class="text-stone-400 hover:text-stone-200 text-sm font-medium transition-colors duration-200">
                                <?php echo $r["label"]; ?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-stone-400 hover:text-stone-200 p-2 rounded-md transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-stone-800/50 bg-[#0d0f0a]">
            <div class="px-4 py-4 space-y-3">
<!-- Loop through list returned from controller -->
                <?php foreach ($leftLinks as $l) { ?>
                    <a href="<?php echo $l["href"]; ?>" class="block text-stone-400 hover:text-stone-200 text-sm font-medium py-2 transition-colors">
                        <?php echo $l["label"]; ?>
                    </a>
                <?php } ?>

                <?php if (count($rightLinks) > 0) { ?>
                    <div class="pt-3 border-t border-stone-800/50 space-y-3">
<!-- Loop through list returned from controller -->
                        <?php foreach ($rightLinks as $r) { ?>
                            <?php if ($r["type"] === "label") { ?>
                                <div class="text-stone-400 text-sm font-medium py-2">
                                    <?php echo htmlspecialchars($r["label"]); ?>
                                </div>
                            <?php } else if ($r["type"] === "button") { ?>
                                <a href="<?php echo $r["href"]; ?>" class="block bg-[#1d211a] text-[#f5f3eb] px-4 py-2 rounded-full text-sm font-medium text-center border border-stone-700 transition-colors">
                                    <?php echo $r["label"]; ?>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo $r["href"]; ?>" class="block text-stone-400 hover:text-stone-200 text-sm font-medium py-2 transition-colors">
                                    <?php echo $r["label"]; ?>
                                </a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
