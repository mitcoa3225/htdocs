<?php
require_once(__DIR__ . "/../util/security.php");
require_once(__DIR__ . "/../util/password_validator.php");

Security::checkHTTPS();
Security::checkAuthority("customer");

// Customer Profile page.
// Lets the logged-in customer update account info and password.

require_once(__DIR__ . "/../controller/customer_controller.php");

Security::startSession();

$customerIdNumber = isset($_SESSION["customer_id"]) ? (int)$_SESSION["customer_id"] : 0;

//load current customer info so the form can be pre-filled
$customer = null;
if ($customerIdNumber > 0) $customer = CustomerController::getCustomerById($customerIdNumber);

//fields for account info
$emailText = $customer ? $customer->getEmail() : "";
$firstNameText = $customer ? $customer->getFirstName() : "";
$lastNameText = $customer ? $customer->getLastName() : "";
$streetAddressText = $customer ? $customer->getStreetAddress() : "";
$cityText = $customer ? $customer->getCity() : "";
$stateText = $customer ? $customer->getState() : "";
$zipCodeText = $customer ? $customer->getZipCode() : "";
$phoneNumberText = $customer ? $customer->getPhoneNumber() : "";

//password fields
$currentPasswordText = "";
$newPasswordText = "";
$confirmPasswordText = "";

//validation messages
$infoErrors = array();
$passwordErrors = array();
$formMessage = "";
$formMessageType = ""; // success | error

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //update account info
    if (isset($_POST["save_info"])) {

        $emailText = trim((string)($_POST["email"] ?? ""));
        $firstNameText = trim((string)($_POST["first_name"] ?? ""));
        $lastNameText = trim((string)($_POST["last_name"] ?? ""));
        $streetAddressText = trim((string)($_POST["street_address"] ?? ""));
        $cityText = trim((string)($_POST["city"] ?? ""));
        $stateText = strtoupper(trim((string)($_POST["state"] ?? "")));
        $zipCodeText = trim((string)($_POST["zip_code"] ?? ""));
        $phoneNumberText = trim((string)($_POST["phone_number"] ?? ""));

        //required fields
        if ($emailText === "") $infoErrors["email"] = "Email is required.";
        if ($firstNameText === "") $infoErrors["first_name"] = "First name is required.";
        if ($lastNameText === "") $infoErrors["last_name"] = "Last name is required.";

        //length checks based on database field sizes
        if ($emailText !== "" && strlen($emailText) > 100) $infoErrors["email"] = "Email cannot be longer than 100 characters.";
        if ($firstNameText !== "" && strlen($firstNameText) > 50) $infoErrors["first_name"] = "First name cannot be longer than 50 characters.";
        if ($lastNameText !== "" && strlen($lastNameText) > 50) $infoErrors["last_name"] = "Last name cannot be longer than 50 characters.";
        if ($streetAddressText !== "" && strlen($streetAddressText) > 100) $infoErrors["street_address"] = "Street address cannot be longer than 100 characters.";
        if ($cityText !== "" && strlen($cityText) > 50) $infoErrors["city"] = "City cannot be longer than 50 characters.";
        if ($stateText !== "" && strlen($stateText) != 2) $infoErrors["state"] = "State must be 2 letters.";
        if ($zipCodeText !== "" && strlen($zipCodeText) > 10) $infoErrors["zip_code"] = "Zip code cannot be longer than 10 characters.";
        if ($phoneNumberText !== "" && strlen($phoneNumberText) > 20) $infoErrors["phone_number"] = "Phone number cannot be longer than 20 characters.";

        //simple email format check
        if ($emailText !== "" && !filter_var($emailText, FILTER_VALIDATE_EMAIL)) {
            $infoErrors["email"] = "Enter a valid email address.";
        }

        if ($customerIdNumber <= 0) {
            $formMessage = "Login is required.";
            $formMessageType = "error";
        } else if (count($infoErrors) === 0) {

            $ok = CustomerController::updateCustomer($customerIdNumber, $emailText, $firstNameText, $lastNameText, $streetAddressText, $cityText, $stateText, $zipCodeText, $phoneNumberText);

            if ($ok) {
                $formMessage = "Profile updated.";
                $formMessageType = "success";

                //refresh customer object so the header display stays in sync
                $_SESSION["display_name"] = $firstNameText . " " . $lastNameText;
            } else {
                $formMessage = "Profile could not be updated.";
                $formMessageType = "error";
            }
        }
    }

    //update password
    if (isset($_POST["save_password"])) {

        $currentPasswordText = (string)($_POST["current_password"] ?? "");
        $newPasswordText = (string)($_POST["new_password"] ?? "");
        $confirmPasswordText = (string)($_POST["confirm_password"] ?? "");

        if ($currentPasswordText === "") $passwordErrors["current_password"] = "Current password is required.";
        if ($newPasswordText === "") $passwordErrors["new_password"] = "New password is required.";
        if ($confirmPasswordText === "") $passwordErrors["confirm_password"] = "Confirm password is required.";

        if (!isset($passwordErrors["new_password"])) {
            $passwordRuleMessage = PasswordValidator::getFirstMessage($newPasswordText);
            if ($passwordRuleMessage !== "") {
                $passwordErrors["new_password"] = $passwordRuleMessage;
            }
        }

        if (!isset($passwordErrors["confirm_password"]) && $newPasswordText !== $confirmPasswordText) {
            $passwordErrors["confirm_password"] = "Passwords do not match.";
        }

        if ($customerIdNumber <= 0) {
            $formMessage = "Login is required.";
            $formMessageType = "error";
        } else if (count($passwordErrors) === 0) {

            $customerCheck = CustomerController::getCustomerById($customerIdNumber);

            if ($customerCheck == null) {
                $formMessage = "Customer record not found.";
                $formMessageType = "error";
            } else if (!password_verify($currentPasswordText, $customerCheck->getPasswordHash())) {
                $passwordErrors["current_password"] = "Current password is incorrect.";
            } else {

                $ok = CustomerController::updateCustomerPassword($customerIdNumber, $newPasswordText);

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
}

require_once("header.php");
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h2 class="font-serif text-3xl text-[#f5f3eb] mb-2">Profile</h2>
    <p class="text-stone-400 mb-8">Update account information and password</p>

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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- account info card -->
        <div class="bg-[#1d211a]/60 backdrop-blur-sm border border-stone-700/50 rounded-xl shadow-2xl p-8">
            <h3 class="font-serif text-2xl text-[#f5f3eb] mb-1">Account Info</h3>
            <p class="text-stone-400 mb-6 text-sm">Contact and address details</p>

            <form method="POST" action="customer_profile_edit.php" class="space-y-5" novalidate>

                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-2">Email</label>
                    <input name="email" type="text" value="<?php echo htmlspecialchars($emailText); ?>" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb]">
                    <?php if (isset($infoErrors["email"])) { ?><p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($infoErrors["email"]); ?></p><?php } ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-300 mb-2">First name</label>
                        <input name="first_name" type="text" value="<?php echo htmlspecialchars($firstNameText); ?>" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb]">
                        <?php if (isset($infoErrors["first_name"])) { ?><p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($infoErrors["first_name"]); ?></p><?php } ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-300 mb-2">Last name</label>
                        <input name="last_name" type="text" value="<?php echo htmlspecialchars($lastNameText); ?>" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb]">
                        <?php if (isset($infoErrors["last_name"])) { ?><p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($infoErrors["last_name"]); ?></p><?php } ?>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-2">Street address</label>
                    <input name="street_address" type="text" value="<?php echo htmlspecialchars($streetAddressText); ?>" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb]">
                    <?php if (isset($infoErrors["street_address"])) { ?><p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($infoErrors["street_address"]); ?></p><?php } ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-stone-300 mb-2">City</label>
                        <input name="city" type="text" value="<?php echo htmlspecialchars($cityText); ?>" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb]">
                        <?php if (isset($infoErrors["city"])) { ?><p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($infoErrors["city"]); ?></p><?php } ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-300 mb-2">State</label>
                        <input name="state" type="text" maxlength="2" value="<?php echo htmlspecialchars($stateText); ?>" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb]">
                        <?php if (isset($infoErrors["state"])) { ?><p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($infoErrors["state"]); ?></p><?php } ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-300 mb-2">Zip</label>
                        <input name="zip_code" type="text" value="<?php echo htmlspecialchars($zipCodeText); ?>" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb]">
                        <?php if (isset($infoErrors["zip_code"])) { ?><p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($infoErrors["zip_code"]); ?></p><?php } ?>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-2">Phone number</label>
                    <input name="phone_number" type="text" value="<?php echo htmlspecialchars($phoneNumberText); ?>" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb]">
                    <?php if (isset($infoErrors["phone_number"])) { ?><p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($infoErrors["phone_number"]); ?></p><?php } ?>
                </div>

                <button type="submit" name="save_info" value="1" class="bg-[#a8b89a] hover:bg-[#9ba662] text-[#0d0f0a] py-3 px-5 rounded-lg text-sm font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                    Save profile
                </button>

            </form>
        </div>

        <!-- password card -->
        <div class="bg-[#1d211a]/60 backdrop-blur-sm border border-stone-700/50 rounded-xl shadow-2xl p-8">
            <h3 class="font-serif text-2xl text-[#f5f3eb] mb-1">Password</h3>
            <p class="text-stone-400 mb-6 text-sm">Change the password for this account</p>

            <form method="POST" action="customer_profile_edit.php" class="space-y-5" novalidate>

                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-2">Current password</label>
                    <input name="current_password" type="password" value="<?php echo htmlspecialchars($currentPasswordText); ?>" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb]">
                    <?php if (isset($passwordErrors["current_password"])) { ?><p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($passwordErrors["current_password"]); ?></p><?php } ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-2">New password</label>
                    <input name="new_password" type="password" value="<?php echo htmlspecialchars($newPasswordText); ?>" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb]">
                    <?php if (isset($passwordErrors["new_password"])) { ?><p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($passwordErrors["new_password"]); ?></p><?php } ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-300 mb-2">Confirm new password</label>
                    <input name="confirm_password" type="password" value="<?php echo htmlspecialchars($confirmPasswordText); ?>" class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb]">
                    <?php if (isset($passwordErrors["confirm_password"])) { ?><p class="mt-2 text-sm text-red-200"><?php echo htmlspecialchars($passwordErrors["confirm_password"]); ?></p><?php } ?>
                </div>

                <button type="submit" name="save_password" value="1" class="bg-[#a8b89a] hover:bg-[#9ba662] text-[#0d0f0a] py-3 px-5 rounded-lg text-sm font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                    Save password
                </button>

            </form>
        </div>

    </div>
</div>

<?php require_once("footer.php"); ?>
