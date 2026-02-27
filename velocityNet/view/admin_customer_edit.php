<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("admin");

// Admin Customer Edit page.
// Updates one customer record.

require_once(__DIR__ . "/../controller/customer_controller.php");

$errorMessage = "";
$successMessage = "";

$customerIdNumber = 0;
if (isset($_GET["customer_id"])) $customerIdNumber = (int)$_GET["customer_id"];

// When the user clicks submit, update the record first.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $emailText = $_POST["email"] ?? "";
    $firstNameText = $_POST["first_name"] ?? "";
    $lastNameText = $_POST["last_name"] ?? "";
    $streetText = $_POST["street"] ?? "";
    $cityText = $_POST["city"] ?? "";
    $stateText = $_POST["state"] ?? "";
    $zipCodeText = $_POST["zip"] ?? "";
    $phoneNumberText = $_POST["phone"] ?? "";

    if ($customerIdNumber <= 0) {
        $errorMessage = "Missing customer id.";
    } else {

        $ok = CustomerController::updateCustomer(
            $customerIdNumber,
            $emailText,
            $firstNameText,
            $lastNameText,
            $streetText,
            $cityText,
            $stateText,
            $zipCodeText,
            $phoneNumberText
        );

        if ($ok) $successMessage = "Customer updated.";
        else $errorMessage = "Update failed.";
    }
}

// Pull record for the form.
$customerRow = null;
if ($customerIdNumber > 0) $customerRow = CustomerController::getCustomerById($customerIdNumber);

require_once("header.php");
?>

<h2>Admin Customer Edit</h2>

<?php if ($errorMessage != "") { ?><p><?php echo $errorMessage; ?></p><?php } ?>
<?php if ($successMessage != "") { ?><p><?php echo $successMessage; ?></p><?php } ?>

<?php if ($errorMessage == "" && $customerRow != null) { ?>

<!-- form to update a customer -->
<form action="admin_customer_edit.php?customer_id=<?php echo $customerIdNumber; ?>" method="post">

    <label>Email</label><br>
    <input type="text" name="email" value="<?php echo $customerRow->getEmail(); ?>">

    <br><br>

    <label>First Name</label><br>
    <input type="text" name="first_name" value="<?php echo $customerRow->getFirstName(); ?>">

    <br><br>

    <label>Last Name</label><br>
    <input type="text" name="last_name" value="<?php echo $customerRow->getLastName(); ?>">

    <br><br>

    <label>Street Address</label><br>
    <input type="text" name="street_address" value="<?php echo $customerRow->getStreetAddress(); ?>">

    <br><br>

    <label>City</label><br>
    <input type="text" name="city" value="<?php echo $customerRow->getCity(); ?>">

    <br><br>

    <label>State</label><br>
    <input type="text" name="state" value="<?php echo $customerRow->getState(); ?>">

    <br><br>

    <label>Zip Code</label><br>
    <input type="text" name="zip_code" value="<?php echo $customerRow->getZipCode(); ?>">

    <br><br>

    <label>Phone Number</label><br>
    <input type="text" name="phone_number" value="<?php echo $customerRow->getPhoneNumber(); ?>">

    <br><br>

    <input type="submit" value="Update Customer">

</form>

<p><a href="admin_customer_list.php">Back to customer list</a></p>

<?php } ?>

<?php require_once("footer.php"); ?>