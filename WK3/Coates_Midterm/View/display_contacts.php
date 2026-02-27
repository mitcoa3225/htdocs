<?php
require_once(__DIR__ . '\..\Controller\contacts_controller.php');
require_once(__DIR__ . '\..\Controller\contact.php');

use Controllers\ContactsController;

if (isset($_POST['delete']) && isset($_POST['ContactNo'])) {
  ContactsController::deleteContact((int)$_POST['ContactNo']);
  header("Location: ./display_contacts.php");
  exit();
}

$contacts = ContactsController::getAllContacts();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Coates Midterm Practical</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Mitchell Coates Midterm Practical</h1>
  <h2>My Contacts</h2>

  <p>
    <a href="./add_update_contact.php">Add New Contact</a> |
    <a href="../index.php">Main Menu</a>
  </p>

  <?php if ($contacts === false): ?>
    <p>Database connection failed. Check your credentials in model/database.php.</p>
  <?php else: ?>
    <table>
      <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Street Address</th>
        <th>Apt/Office/Bldg</th>
        <th>City</th>
        <th>State</th>
        <th>Zip Code</th>
        <th>DOB</th>
        <th>E-Mail Address</th>
        <th>Phone Number</th>
        <th>Additional Information</th>
        <th>Actions</th>
      </tr>

      <?php foreach ($contacts as $row): ?>
        <tr>
          <td><?php echo $row['ContactNo']; ?></td>
          <td><?php echo $row['ContactLastName'] . ", " . $row['ContactFirstName']; ?></td>
          <td><?php echo $row['ContactAddressLine1']; ?></td>
          <td><?php echo $row['ContactAddressLine2']; ?></td>
          <td><?php echo $row['ContactCity']; ?></td>
          <td><?php echo $row['ContactState']; ?></td>
          <td><?php echo $row['ContactZip']; ?></td>
          <td><?php echo $row['ContactBirthdate']; ?></td>
          <td><?php echo $row['ContactEMail']; ?></td>
          <td><?php echo $row['ContactPhone']; ?></td>
          <td><?php echo $row['ContactNotes']; ?></td>
          <td>
            <form method="post" action="display_contacts.php" style="display:inline;">
              <input type="hidden" name="ContactNo" value="<?php echo $row['ContactNo']; ?>">
              <button type="submit" name="delete">Delete</button>
            </form>

            <form method="get" action="add_update_contact.php" style="display:inline;">
              <input type="hidden" name="ContactNo" value="<?php echo $row['ContactNo']; ?>">
              <button type="submit">Update</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>

    </table>
  <?php endif; ?>
</body>
</html>
