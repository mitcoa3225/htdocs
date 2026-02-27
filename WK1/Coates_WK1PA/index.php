<?php
require_once __DIR__ . '/validation.php';

use function lastname_validator\validate_name;
use function lastname_validator\validate_dob;
use function lastname_validator\validate_email;
use function lastname_validator\validate_favorite_integer;
use function lastname_validator\validate_nickname;

// Default values
$name = '';
$dob = '';
$email = '';
$favInt = '';
$nickname = '';

// Error messages
$name_error = '';
$dob_error = '';
$email_error = '';
$favInt_error = '';
$nickname_error = '';

$overall_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read form values
    $name = $_POST['name'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $email = $_POST['email'] ?? '';
    $favInt = $_POST['favInt'] ?? '';
    $nickname = $_POST['nickname'] ?? '';

    // Validate
    $name_error = validate_name($name);
    $dob_error = validate_dob($dob);
    $email_error = validate_email($email);
    $favInt_error = validate_favorite_integer($favInt);

    // nickname uses pass-by-reference (normalizes)
    $normalizedNickname = '';
    $nickname_error = validate_nickname($nickname, $normalizedNickname);
    $nickname = $normalizedNickname; // keep normalized in textbox

    // Overall message
    $hasErrors = (
        $name_error !== '' ||
        $dob_error !== '' ||
        $email_error !== '' ||
        $favInt_error !== '' ||
        $nickname_error !== ''
    );

    if ($hasErrors) {
        $overall_message = "Errors found, please check your entries";
    } else {
        $overall_message = "All fields valid";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mitchell Coates Wk 1 Performance Assessment</title>
</head>
<body>
    <h2>Mitchell Coates Wk 1 Performance Assessment</h2>

    <form method="POST">
        <p>
            <label>Name (Lastname, Firstname): </label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
            <?php
            if ($name_error !== '') {
                echo "<span style='color:red; margin-left:10px;'>" . htmlspecialchars($name_error) . "</span>";
            }
            ?>
        </p>

        <p>
            <label>Date of Birth (MM/DD/YYYY): </label>
            <input type="text" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
            <?php
            if ($dob_error !== '') {
                echo "<span style='color:red; margin-left:10px;'>" . htmlspecialchars($dob_error) . "</span>";
            }
            ?>
        </p>

        <p>
            <label>Email Address: </label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <?php
            if ($email_error !== '') {
                echo "<span style='color:red; margin-left:10px;'>" . htmlspecialchars($email_error) . "</span>";
            }
            ?>
        </p>

        <p>
            <label>Favorite Integer: </label>
            <input type="text" name="favInt" value="<?php echo htmlspecialchars($favInt); ?>">
            <?php
            if ($favInt_error !== '') {
                echo "<span style='color:red; margin-left:10px;'>" . htmlspecialchars($favInt_error) . "</span>";
            }
            ?>
        </p>

        <p>
            <label>Nickname (optional): </label>
            <input type="text" name="nickname" value="<?php echo htmlspecialchars($nickname); ?>">
            <?php
            if ($nickname_error !== '') {
                echo "<span style='color:red; margin-left:10px;'>" . htmlspecialchars($nickname_error) . "</span>";
            }
            ?>
        </p>

        <p>
            <input type="submit" value="Validate">
        </p>
    </form>

    <h3>
        <?php echo htmlspecialchars($overall_message); ?>
    </h3>
</body>
</html>
