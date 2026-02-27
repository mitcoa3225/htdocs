<?php
require_once(__DIR__ . '/../Controller/contacts_controller.php');
require_once(__DIR__ . '/../Controller/contact.php');

use Controllers\ContactsController;
use Controllers\Contact;

// helper to safely show values in HTML
function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES); }

$errors = [
  'ContactFirstName' => '',
  'ContactLastName' => '',
  'ContactAddressLine1' => '',
  'ContactCity' => '',
  'ContactState' => '',
  'ContactZip' => '',
  'ContactBirthdate' => '',
  'ContactEMail' => '',
  'ContactPhone' => '',
  'ContactNotes' => ''
];

// defaults (blank add form)
$values = [
  'ContactNo' => 0,
  'ContactFirstName' => '',
  'ContactLastName' => '',
  'ContactAddressLine1' => '',
  'ContactAddressLine2' => '',
  'ContactCity' => '',
  'ContactState' => '',
  'ContactZip' => '',
  'ContactBirthdate' => '',
  'ContactEMail' => '',
  'ContactPhone' => '',
  'ContactNotes' => ''
];

// if updating, load from DB
if (isset($_GET['ContactNo'])) {
  $row = ContactsController::getContactByNo((int)$_GET['ContactNo']);
  if ($row) {
    $values = array_merge($values, $row);
  }
}

// if submitted, validate + retain values
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($values as $k => $v) {
    if (isset($_POST[$k])) {
      $values[$k] = trim($_POST[$k]);
    }
  }
  $values['ContactNo'] = (int)($values['ContactNo'] ?? 0);

  // Validation rules
  if ($values['ContactFirstName'] ==='') {
    $errors['ContactFirstName'] = 'Required';
  } elseif (strlen($values['ContactFirstName']) < 2) {
    $errors['ContactFirstName'] = 'Must be at least 2 characters.';
  }


  if ($values['ContactLastName']===''){
    $errors['ContactLastName'] = 'Required';
  } elseif (strlen($values['ContactLastName']) < 2) {
    $errors['ContactLastName'] = 'Must be at least 2 characters.';
  }


  if ($values['ContactAddressLine1'] === '') {
    $errors['ContactAddressLine1'] = 'Required';
  }

  if ($values['ContactCity']=== '') {
    $errors['ContactCity'] = 'Required';
  } elseif (strlen($values['ContactCity']) < 2) {
    $errors['ContactCity'] = 'Must be at least 2 characters.';
  }

  if($values['ContactState']===''){
    $errors['ContactState']='Required';
  } elseif (!preg_match('/^[A-Z]{2}$/', $values['ContactState'])) {
    $errors['ContactState'] = 'Invalid state abbreviation - 2 Uppercase letters only.';
  }

  if ($values['ContactZip']=== ''){
    $errors['ContactZip']='Required';
  } elseif (!preg_match('/^[0-9]{5}$/', $values['ContactZip'])) {
    $errors['ContactZip'] = 'Invalid Zip Code - 5 digits only.';
  }


  if ($values['ContactBirthdate'] === '') {
    $errors['ContactBirthdate'] = 'Required.';
  }


  if ($values['ContactEMail'] === '') {
    $errors['ContactEMail'] = 'Required.';
  } elseif (!filter_var($values['ContactEMail'], FILTER_VALIDATE_EMAIL)) {
    $errors['ContactEMail'] = 'Not a valid e-mail address.';
  }

  if ($values['ContactPhone'] === '') {
    $errors['ContactPhone'] = 'Required.';
  } elseif (!preg_match('/^\([0-9]{3}\)[0-9]{3}-[0-9]{4}$/', $values['ContactPhone'])) {
    $errors['ContactPhone'] = 'Invalid phone number - expected format (XXX)XXX-XXXX.';
  }

  if ($values['ContactNotes'] !== '' && strlen($values['ContactNotes']) > 50) {
    $errors['ContactNotes'] = 'Maximum string length is 50 characters.';
  }



  // if no errors, save
  $hasErrors = false;
  foreach ($errors as $e) {
    if ($e !== '') { $hasErrors = true; break; }
  }

  if (!$hasErrors) {
    $contactObj = new Contact(
      $values['ContactFirstName'],
      $values['ContactLastName'],
      $values['ContactAddressLine1'],
      $values['ContactAddressLine2'],
      $values['ContactCity'],
      $values['ContactState'],
      $values['ContactZip'],
      $values['ContactBirthdate'],
      $values['ContactEMail'],
      $values['ContactPhone'],
      $values['ContactNotes'],
      $values['ContactNo']
    );

    if ($values['ContactNo'] > 0) {
      ContactsController::updateContact($contactObj);
    } else {
      ContactsController::addContact($contactObj);
    }

    header("Location: ./display_contacts.php");
    exit();
  }
}

$isUpdate = ($values['ContactNo'] > 0);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Coates Midterm Practical</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Mitchell Coates Midterm Practical<br></h1>
  <h1><?php echo $isUpdate ? 'Update Contact' : 'Add Contact'; ?></h1>

  <form method="post" action="add_update_contact.php<?php echo $isUpdate ? ('?ContactNo=' . $values['ContactNo']) : ''; ?>">
    <input type="hidden" name="ContactNo" value="<?php echo h($values['ContactNo']); ?>">

    <!--<table>-->
      <tr>
        <th>First Name</th>
        <td>
          <input type="text" name="ContactFirstName" value="<?php echo h($values['ContactFirstName']); ?>">
          <span class="error"><?php echo h($errors['ContactFirstName']); ?></span>
        </td>
      </tr>
      <tr>
        <br><th>Last Name</th>
        <td>
          <input type="text" name="ContactLastName" value="<?php echo h($values['ContactLastName']); ?>">
          <span class="error"><?php echo h($errors['ContactLastName']); ?></span>
        </td>
      </tr>
      <tr>
      <br><th>Street Address</th>
        <td>
          <input type="text" name="ContactAddressLine1" value="<?php echo h($values['ContactAddressLine1']); ?>">
          <span class="error"><?php echo h($errors['ContactAddressLine1']); ?></span>
        </td>
      </tr>
      <tr>
      <br><th>Apt/Office/Bldg</th>
        <td>
          <input type="text" name="ContactAddressLine2" value="<?php echo h($values['ContactAddressLine2']); ?>">
        </td>
      </tr>
      <tr>
      <br><th>City</th>
        <td>
          <input type="text" name="ContactCity" value="<?php echo h($values['ContactCity']); ?>">
          <span class="error"><?php echo h($errors['ContactCity']); ?></span>
        </td>
      </tr>
      <tr>
      <br><th>State</th>
        <td>
          <input type="text" name="ContactState" value="<?php echo h($values['ContactState']); ?>" maxlength="2">
          <span class="error"><?php echo h($errors['ContactState']); ?></span>
        </td>
      </tr>
      <tr>
      <br><th>Zip Code</th>
        <td>
          <input type="text" name="ContactZip" value="<?php echo h($values['ContactZip']); ?>" maxlength="5">
          <span class="error"><?php echo h($errors['ContactZip']); ?></span>
        </td>
      </tr>
      <tr>
      <br><th>DOB</th>
        <td>
          <input type="date" name="ContactBirthdate" value="<?php echo h($values['ContactBirthdate']); ?>">
          <span class="error"><?php echo h($errors['ContactBirthdate']); ?></span>
        </td>
      </tr>
      <tr>
      <br><th>E-Mail</th>
        <td>
          <input type="text" name="ContactEMail" value="<?php echo h($values['ContactEMail']); ?>">
          <span class="error"><?php echo h($errors['ContactEMail']); ?></span>
        </td>
      </tr>
      <tr>
      <br><th>Phone</th>
        <td>
          <input type="text" name="ContactPhone" value="<?php echo h($values['ContactPhone']); ?>" placeholder="(123)456-7890">
          <span class="error"><?php echo h($errors['ContactPhone']); ?></span>
        </td>
      </tr>
      <tr>
      <br><th>Notes</th>
        <td>
          <input type="text" name="ContactNotes" value="<?php echo h($values['ContactNotes']); ?>" maxlength="50">
          <span class="error"><?php echo h($errors['ContactNotes']); ?></span>
        </td>
      </tr>
    <!--</table>-->

    <button type="submit"><?php echo $isUpdate ? 'Update' : 'Add'; ?></button>
    <a href="display_contacts.php">Cancel</a>
  </form>
</body>
</html>
