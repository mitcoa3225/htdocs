<?php
require_once(__DIR__ . "/../util/security.php");
require_once(__DIR__ . "/../util/password_validator.php");

Security::checkHTTPS();
Security::checkAuthority("tech");

// Employee Profile page.
// Allows a technician to change their password.
// Uses the same password rules as registration.

require_once(__DIR__ . "/../controller/employee_controller.php");

Security::startSession();

$employeeIdNumber = isset($_SESSION["employee_id"]) ? (int)$_SESSION["employee_id"] : 0;

$currentPasswordText = "";
$newPasswordText = "";
$confirmPasswordText = "";

$currentPasswordError = "";
$newPasswordError = "";
$confirmPasswordError = "";
$formMessage = "";
$formMessageType = ""; // success | error

// Handle form submit.
// Verifies the current password, validates the new password, then saves the hash.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["current_password"])) $currentPasswordText = (string)$_POST["current_password"];
    if (isset($_POST["new_password"])) $newPasswordText = (string)$_POST["new_password"];
    if (isset($_POST["confirm_password"])) $confirmPasswordText = (string)$_POST["confirm_password"];

    if ($currentPasswordText === "") $currentPasswordError = "Current password is required.";
    if ($newPasswordText === "") $newPasswordError = "New password is required.";
    if ($confirmPasswordText === "") $confirmPasswordError = "Confirm password is required.";

    if ($newPasswordError === "") {
        $newPasswordError = PasswordValidator::getFirstMessage($newPasswordText);
    }

    if ($newPasswordError === "" && $confirmPasswordError === "" && $newPasswordText !== $confirmPasswordText) {
        $confirmPasswordError = "Passwords do not match.";
    }

    if ($currentPasswordError === "" && $newPasswordError === "" && $confirmPasswordError === "") {

        $employee = EmployeeController::getEmployeeById($employeeIdNumber);

        if ($employee == null) {
            $formMessage = "Employee record not found.";
            $formMessageType = "error";
        } else if (!password_verify($currentPasswordText, $employee->getPasswordHash())) {
            // Current password is verified against the stored hash.

            $currentPasswordError = "Current password is incorrect.";
        } else {

            $ok = EmployeeController::updateEmployeePassword($employeeIdNumber, $newPasswordText);

            if ($ok) {
                $formMessage = "Password updated.";
                $formMessageType = "success";

                $currentPasswordText = "";
                $newPasswordText = "";
                $confirmPasswordText = "";
            } else {
                $formMessage = "Password could not be updated.";
                $formMessageType = "error";
            }
        }
    }
}

require_once("header.php");
?>

<!-- Page heading and password change form -->

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h2 class="font-serif text-3xl text-[#f5f3eb] mb-2">Profile</h2>
    <p class="text-stone-400 mb-8">Update the password for this account.</p>

    <div class="bg-[#1d211a]/60 backdrop-blur-sm border border-stone-700/50 rounded-xl shadow-2xl p-8">

        <?php if ($formMessage !== "") { ?>
            <?php if ($formMessageType === "success") { ?>
                <div class="mb-6 bg-green-500/10 border border-green-500/30 text-green-200 text-sm rounded-lg px-4 py-3">
                    <?php echo htmlspecialchars($formMessage); ?>
                </div>
            <?php } else { ?>
                <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-200 text-sm rounded-lg px-4 py-3">
                    <?php echo htmlspecialchars($formMessage); ?>
                </div>
            <?php } ?>
        <?php } ?>

        <form method="POST" action="technician_password_change.php" class="space-y-6" novalidate>

            <div>
                <label for="current_password" class="block text-sm font-medium text-stone-300 mb-2">Current password</label>
                <input
                    id="current_password"
                    name="current_password"
                    type="password"
                    value="<?php echo htmlspecialchars($currentPasswordText); ?>"
                    class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                >
                <?php if ($currentPasswordError !== "") { ?>
                    <p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($currentPasswordError); ?></p>
                <?php } ?>
            </div>

            <div>
                <label for="new_password" class="block text-sm font-medium text-stone-300 mb-2">New password</label>
                <input
                    id="new_password"
                    name="new_password"
                    type="password"
                    value="<?php echo htmlspecialchars($newPasswordText); ?>"
                    class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                >
                <?php if ($newPasswordError !== "") { ?>
                    <p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($newPasswordError); ?></p>
                <?php } ?>
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-medium text-stone-300 mb-2">Confirm new password</label>
                <input
                    id="confirm_password"
                    name="confirm_password"
                    type="password"
                    value="<?php echo htmlspecialchars($confirmPasswordText); ?>"
                    class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                >
                <?php if ($confirmPasswordError !== "") { ?>
                    <p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($confirmPasswordError); ?></p>
                <?php } ?>
            </div>

            <button type="submit" class="bg-[#a8b89a] hover:bg-[#9ba662] text-[#0d0f0a] py-3 px-5 rounded-lg text-sm font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                Save password
            </button>

        </form>
    </div>
</div>

<?php require_once("footer.php"); ?>
