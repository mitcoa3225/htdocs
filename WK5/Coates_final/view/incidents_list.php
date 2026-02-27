<?php
use Utils\Helpers;
$pageTitle = 'Incident Management';
$homeAction = 'tech_home';
require(__DIR__ . '/_header.php');

$msg = isset($message) ? $message : '';
$err = isset($error) ? $error : '';
?>

<h3>Add New Incident File</h3>
<form method="post" action="index.php?action=incident_add">
    <p>
        <label>File Name (example: incident1.txt)</label><br>
        <input type="text" name="fileName" value="<?php echo Helpers::h(strval($values['fileName'] ?? '')); ?>">
        <?php if ($err !== ''): ?><span class="error"><?php echo Helpers::h($err); ?></span><?php endif; ?>
    </p>
    <p>
        <label>Contents</label><br>
        <textarea name="content"><?php echo Helpers::h(strval($values['content'] ?? '')); ?></textarea>
    </p>
    <button type="submit">Save Incident</button>
</form>

<?php if ($msg !== ''): ?>
    <p><?php echo Helpers::h($msg); ?></p>
<?php endif; ?>

<h3>Available Incident Files</h3>
<ul>
<?php foreach ($files as $f): ?>
    <li>
        <?php echo Helpers::h($f); ?>
        - <a href="index.php?action=incident_view&file=<?php echo Helpers::h($f); ?>">View</a>
        - <a href="index.php?action=incident_edit&file=<?php echo Helpers::h($f); ?>">Update</a>
    </li>
<?php endforeach; ?>
</ul>

<?php require(__DIR__ . '/_footer.php'); ?>
