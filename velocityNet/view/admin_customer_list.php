<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("admin");

// Admin Customer List page.
// Shows all customers.

require_once(__DIR__ . "/../controller/customer_controller.php");

// Handle delete requests.
$deleteMsg = "";

if (isset($_POST["delete_customer_id"])) {

    $deleteId = (int)$_POST["delete_customer_id"];

    if ($deleteId > 0) {
        $deleted = CustomerController::deleteCustomer($deleteId);
        $deleteMsg = $deleted ? "Customer deleted." : "Unable to delete customer.";
    }
}

$customerList = CustomerController::getAllCustomers();

require_once("header.php");
?>

<?php if ($deleteMsg !== "") { ?>
    <p><?php echo $deleteMsg; ?></p>
<?php } ?>

<h2>Admin Customer List</h2>

<p><a href="admin_customer_add.php">Add Customer</a></p>

<!-- table to display records from the database -->
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>City</th>
        <th>State</th>
        <th>Action</th>
    </tr>

<?php //loop through customerList and build output ?>
<!-- Loop through customers returned from controller -->
    <?php foreach ($customerList as $customerRow) { ?>
        <tr>
            <td><?php echo $customerRow->getCustomerId(); ?></td>
            <td><?php echo $customerRow->getLastName(); ?>, <?php echo $customerRow->getFirstName(); ?></td>
            <td><?php echo $customerRow->getEmail(); ?></td>
            <td><?php echo $customerRow->getPhoneNumber(); ?></td>
            <td><?php echo $customerRow->getCity(); ?></td>
            <td><?php echo $customerRow->getState(); ?></td>
            <td>
                <a class="action-link" href="admin_customer_edit.php?customer_id=<?php echo $customerRow->getCustomerId(); ?>">Edit</a>

<!-- Confirm before running delete action -->
                <form method="post" action="" style="display:inline;" onsubmit="return confirm('Delete this customer?');">
                    <input type="hidden" name="delete_customer_id" value="<?php echo (int)$customerRow->getCustomerId(); ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<?php require_once("footer.php"); ?>