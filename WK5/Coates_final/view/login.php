<?php
use Utils\Helpers;
$pageTitle = 'Login';
$homeAction = '';
require(__DIR__ . '/_header.php');

$userId = isset($values['userId']) ? $values['userId'] : '';
$message = isset($message) ? $message : '';
?>
<form method="post" action="index.php?action=login">
    <p>
        <label>User ID</label><br>
        <input type="text" name="userId" value="<?php echo Helpers::h($userId); ?>">
    </p>
    <p>
        <label>Password</label><br>
        <input type="password" name="password" value="">
    </p>
    <button type="submit">Login</button>
</form>

<?php if ($message !== ''): ?>
    <p class="error"><?php echo Helpers::h($message); ?></p>
<?php endif; ?>

<?php require(__DIR__ . '/_footer.php'); ?>
