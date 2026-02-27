<?php
// Register page.
// Adds a customer account.

require_once(__DIR__ . "/../controller/customer_controller.php");
require_once(__DIR__ . "/../util/password_validator.php");

$errorMessage = "";
$successMessage = "";

// form fields
$emailText = "";
$firstNameText = "";
$lastNameText = "";
$streetText = "";
$cityText = "";
$stateText = "";
$zipCodeText = "";
$phoneNumberText = "";
$passwordText = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $emailText = $_POST["email"] ?? "";
    $firstNameText = $_POST["first_name"] ?? "";
    $lastNameText = $_POST["last_name"] ?? "";
    $streetText = $_POST["street_address"] ?? "";
    $cityText = $_POST["city"] ?? "";
    $stateText = $_POST["state"] ?? "";
    $zipCodeText = $_POST["zip_code"] ?? "";
    $phoneNumberText = $_POST["phone_number"] ?? "";
    $passwordText = $_POST["customer_password"] ?? "";

    if ($emailText == "" || $firstNameText == "" || $lastNameText == "" || $passwordText == "") {
        $errorMessage .= "Fill out the required fields.<br>";  
    }
    // Password rules.
    $passwordMessages = PasswordValidator::getMessages($passwordText);
    if (count($passwordMessages) > 0) {
        foreach ($passwordMessages as $msg) {
            $errorMessage .= $msg . "<br>";
        }
    }
    if($errorMessage == "") {
        $ok = CustomerController::addCustomer(
            $emailText,
            $firstNameText,
            $lastNameText,
            $streetText,
            $cityText,
            $stateText,
            $zipCodeText,
            $phoneNumberText,
            $passwordText
        );

        if ($ok) {
            $successMessage = "Account created. You can log in now.";

            // clear fields after a successful insert
            $emailText = "";
            $firstNameText = "";
            $lastNameText = "";
            $streetText = "";
            $cityText = "";
            $stateText = "";
            $zipCodeText = "";
            $phoneNumberText = "";
            $passwordText = "";
        } else {
            $errorMessage = "Create account failed.";
        }
    }
}

require_once(__DIR__ . "/header.php");
?>

<!-- Registration Section -->
<div class="min-h-[calc(100vh-12rem)] flex items-center justify-center py-12 px-4">
    <div class="max-w-2xl w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="font-serif text-4xl font-medium text-[#f5f3eb] mb-3">Create your account</h2>
            <p class="text-stone-400">Join us to submit and track your support tickets</p>
        </div>

        <?php if (isset($errorMessage) && $errorMessage != "") { ?>
            <!-- Show validation or insert errors -->
            <div class="bg-[#c75d5d]/10 border border-[#c75d5d]/20 rounded-lg p-4 mb-6">
                <div class="flex">
                    <svg class="w-5 h-5 text-[#c75d5d] mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="ml-3 text-sm text-[#c75d5d]"><?php echo $errorMessage; ?></p>
                </div>
            </div>
        <?php } ?>

        <?php if (isset($successMessage) && $successMessage != "") { ?>
            <!-- Show success message after insert -->
            <div class="bg-[#7cb369]/10 border border-[#7cb369]/20 rounded-lg p-4 mb-6">
                <div class="flex">
                    <svg class="w-5 h-5 text-[#7cb369] mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="ml-3 text-sm text-[#7cb369]"><?php echo $successMessage; ?></p>
                </div>
            </div>
        <?php } ?>

        <!-- Registration Form Card -->
        <div class="bg-[#1d211a]/60 backdrop-blur-sm border border-stone-700/50 rounded-xl shadow-2xl p-8">
<!-- form to create an account -->
            <form action="register.php" method="post" class="space-y-6">

                <!-- Required Fields Section -->
                <div class="space-y-6">
                    <div class="border-b border-stone-700/50 pb-6">
                        <h3 class="font-serif text-lg text-[#f5f3eb] mb-4">Required Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email Field -->
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium text-stone-300 mb-2">
                                    Email Address <span class="text-[#c75d5d]">*</span>
                                </label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="<?php echo htmlspecialchars($emailText); ?>"
                                    required
                                    class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                                    placeholder="you@example.com"
                                >
                            </div>

                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-stone-300 mb-2">
                                    First Name <span class="text-[#c75d5d]">*</span>
                                </label>
                                <input
                                    id="first_name"
                                    name="first_name"
                                    type="text"
                                    value="<?php echo htmlspecialchars($firstNameText); ?>"
                                    required
                                    class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                                    placeholder="John"
                                >
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-stone-300 mb-2">
                                    Last Name <span class="text-[#c75d5d]">*</span>
                                </label>
                                <input
                                    id="last_name"
                                    name="last_name"
                                    type="text"
                                    value="<?php echo htmlspecialchars($lastNameText); ?>"
                                    required
                                    class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                                    placeholder="Doe"
                                >
                            </div>

                            <!-- Password -->
                            <div class="md:col-span-2">
                                <label for="customer_password" class="block text-sm font-medium text-stone-300 mb-2">
                                    Password <span class="text-[#c75d5d]">*</span>
                                </label>
                                <input
                                    id="customer_password"
                                    name="customer_password"
                                    type="password"
                                    required
                                    class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                                    placeholder="Create a secure password"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Optional Fields Section -->
                    <div>
                        <h3 class="font-serif text-lg text-[#f5f3eb] mb-4">Contact Information <span class="text-sm font-sans text-stone-500">(Optional)</span></h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Street Address -->
                            <div class="md:col-span-2">
                                <label for="street_address" class="block text-sm font-medium text-stone-300 mb-2">
                                    Street Address
                                </label>
                                <input
                                    id="street_address"
                                    name="street_address"
                                    type="text"
                                    value="<?php echo htmlspecialchars($streetText); ?>"
                                    class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                                    placeholder="123 Main Street"
                                >
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-stone-300 mb-2">
                                    City
                                </label>
                                <input
                                    id="city"
                                    name="city"
                                    type="text"
                                    value="<?php echo htmlspecialchars($cityText); ?>"
                                    class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                                    placeholder="New York"
                                >
                            </div>

                            <!-- State -->
                            <div>
                                <label for="state" class="block text-sm font-medium text-stone-300 mb-2">
                                    State
                                </label>
                                <input
                                    id="state"
                                    name="state"
                                    type="text"
                                    value="<?php echo htmlspecialchars($stateText); ?>"
                                    class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                                    placeholder="NY"
                                >
                            </div>

                            <!-- Zip Code -->
                            <div>
                                <label for="zip_code" class="block text-sm font-medium text-stone-300 mb-2">
                                    Zip Code
                                </label>
                                <input
                                    id="zip_code"
                                    name="zip_code"
                                    type="text"
                                    value="<?php echo htmlspecialchars($zipCodeText); ?>"
                                    class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                                    placeholder="10001"
                                >
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-stone-300 mb-2">
                                    Phone Number
                                </label>
                                <input
                                    id="phone_number"
                                    name="phone_number"
                                    type="tel"
                                    value="<?php echo htmlspecialchars($phoneNumberText); ?>"
                                    class="w-full px-4 py-3 bg-[#151912] border border-stone-700 rounded-lg text-[#f5f3eb] placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-[#a8b89a]/30 focus:border-[#a8b89a] transition-all duration-200"
                                    placeholder="(555) 123-4567"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button
                        type="submit"
                        class="w-full bg-[#1d211a] hover:bg-[#252a21] text-[#f5f3eb] font-medium py-3 px-4 rounded-lg border border-stone-600 hover:border-stone-500 transition-all duration-200"
                    >
                        Create Account
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-stone-700/50"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-[#1d211a] text-stone-500">or</span>
                </div>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-stone-400">
                    Already have an account?
                    <a href="login.php" class="text-[#a8b89a] hover:text-[#c8c9c4] font-medium transition-colors duration-200">
                        Sign in
                    </a>
                </p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="text-center">
            <p class="text-sm text-stone-500">
                By creating an account, you agree to our Terms of Service and Privacy Policy
            </p>
        </div>
    </div>
</div>

<?php require_once("footer.php"); ?>