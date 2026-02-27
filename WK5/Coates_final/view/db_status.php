<?php
use Utils\Helpers;
$pageTitle = 'Database Connection Status';
$homeAction = 'tech_home';
require(__DIR__ . '/_header.php');
?>

<h3>Connection Information</h3>
<table>
    <tr><th>Host</th><td><?php echo Helpers::h($status['host']); ?></td></tr>
    <tr><th>Database</th><td><?php echo Helpers::h($status['name']); ?></td></tr>
    <tr><th>User</th><td><?php echo Helpers::h($status['user']); ?></td></tr>
    <tr><th>Password</th><td><?php echo Helpers::h($status['pass']); ?></td></tr>
</table>

<h3>Summary Status</h3>
<?php if ($status['ok']): ?>
    <p><strong>SUCCESS:</strong> Connected to database.</p>
<?php else: ?>
    <p class="error"><strong>FAILURE:</strong> <?php echo Helpers::h($status['error']); ?></p>
<?php endif; ?>

<?php require(__DIR__ . '/_footer.php'); ?>
