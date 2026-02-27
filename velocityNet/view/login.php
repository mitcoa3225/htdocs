<?php
require_once(__DIR__ . "/../util/security.php");

// Login page.
// Allows customers, technicians, and admins to sign in.
// Stores role info in session so headers and access checks work.

require_once(__DIR__ . "/../model/customerDB.php");
require_once(__DIR__ . "/../model/employeesDB.php");

Security::checkHTTPS();

Security::startSession();

// If already logged in, send them to a page that matches their role.
if ((isset($_SESSION["admin"]) && $_SESSION["admin"] === true) || (isset($_SESSION["tech"]) && $_SESSION["tech"] === true) || (isset($_SESSION["customer"]) && $_SESSION["customer"] === true)) {
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        header("Location: admin_complaint_unassigned_list.php");
        exit;
    }
    if (isset($_SESSION["tech"]) && $_SESSION["tech"] === true) {
        header("Location: technician_complaint_list.php");
        exit;
    }
    header("Location: customer_my_tickets.php");
    exit;
}

$emailText = "";
$passwordText = "";

$emailError = "";
$passwordError = "";
$formError = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["email"])) $emailText = trim($_POST["email"]);
    if (isset($_POST["password"])) $passwordText = (string)$_POST["password"];

    if ($emailText === "") $emailError = "Email is required.";
    if ($passwordText === "") $passwordError = "Password is required.";

    if ($emailError === "" && $passwordError === "") {

        // Try employees first (admin / tech).
        $employee = EmployeeDB::getEmployeeByEmail($emailText);

        // Passwords are stored hashed in the database.
        // Use password_verify to compare the entered password to the stored hash.
        if ($employee != null && password_verify($passwordText, $employee->getPasswordHash())) {

            $level = strtolower(trim($employee->getRole()));

            // Employees table uses values like "administrator" and "technician".
            // Normalize to app roles: admin / tech.
            $role = "tech";
            if ($level === "admin" || $level === "administrator") $role = "admin";

            $_SESSION["user_type"] = "employee";
            // Store the employee id in session.
            $_SESSION["employee_id"] = (int)$employee->getEmployeeId();
            unset($_SESSION["customer_id"]);
            $_SESSION["role"] = $role;

            $_SESSION["admin"] = ($role === "admin");
            $_SESSION["tech"] = ($role === "tech");
            $_SESSION["customer"] = false;
            $_SESSION["display_name"] = $employee->getFirstName() . " " . $employee->getLastName();

            if ($role === "admin") {
                header("Location: admin_complaint_unassigned_list.php");
                exit;
            }

            header("Location: technician_complaint_list.php");
            exit;

        } else {

            // Try customer login.
            $customer = CustomerDB::getCustomerByEmail($emailText);

            // Passwords are stored hashed in the database.
            if ($customer != null && password_verify($passwordText, $customer->getPasswordHash())) {

                $_SESSION["user_type"] = "customer";
                // Store the customer id in session.
                $_SESSION["customer_id"] = (int)$customer->getCustomerId();
                unset($_SESSION["employee_id"]);
                $_SESSION["role"] = "customer";

                $_SESSION["admin"] = false;
                $_SESSION["tech"] = false;
                $_SESSION["customer"] = true;
                $_SESSION["display_name"] = $customer->getFirstName() . " " . $customer->getLastName();

                header("Location: customer_my_tickets.php");
                exit;

            } else {
                $formError = "Email or password is incorrect.";
            }
        }
    }
}

require_once("header.php");
?>

<!-- Login Section -->
<div class="min-h-[calc(100vh-12rem)] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full space-y-8">

        <div class="text-center">
            <h2 class="font-serif text-4xl font-medium text-[#f5f3eb] mb-3">Welcome back</h2>
            <p class="text-stone-400">Sign in to manage your account</p>
        </div>

        <div class="bg-[#1d211a]/60 backdrop-blur-sm border border-stone-700/50 rounded-xl shadow-2xl p-8">

            <?php if ($formError !== "") { ?>
                <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-200 text-sm rounded-lg px-4 py-3">
                    <?php echo htmlspecialchars($formError); ?>
                </div>
            <?php } ?>

            <!-- form to submit data -->
            <form class="space-y-6" method="POST" action="login.php" novalidate>

                <div>
                    <label for="email" class="block text-sm font-medium text-stone-300 mb-2">Email address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="<?php echo htmlspecialchars($emailText); ?>"
                        class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                        placeholder="you@example.com"
                    >
                    <?php if ($emailError !== "") { ?>
                        <p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($emailError); ?></p>
                    <?php } ?>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-stone-300 mb-2">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                        placeholder="••••••••"
                    >
                    <?php if ($passwordError !== "") { ?>
                        <p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($passwordError); ?></p>
                    <?php } ?>
                </div>

                <button type="submit" class="w-full bg-[#a8b89a] hover:bg-[#9ba662] text-[#0d0f0a] py-3 px-4 rounded-lg text-sm font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                    Sign in
                </button>

                <div class="text-center pt-4 border-t border-stone-800/50">
                    <p class="text-sm text-stone-400">
                        Need an account?
                        <a href="register.php" class="text-[#a8b89a] hover:text-[#c8c9c4] font-medium transition-colors duration-200">Create one</a>
                    </p>
                </div>
            </form>
        </div>

        <div class="text-center">
            <p class="text-sm text-stone-500">Secure, encrypted connection</p>
        </div>
    </div>
</div>

<?php require_once("footer.php"); ?>