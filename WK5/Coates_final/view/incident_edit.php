<?php
use Utils\Helpers;
$pageTitle = 'Update Incident File';
$homeAction = 'tech_home';
require(__DIR__ . '/_header.php');

$file = isset($file) ? $file : '';
$content = isset($content) ? $content : '';
?>
<p><a href="index.php?action=incidents_list">Back to Incidents</a></p>

<form method="post" action="index.php?action=incident_edit_save">
    <input type="hidden" name="file" value="<?php echo Helpers::h($file); ?>">
    <p><strong>File:</strong> <?php echo Helpers::h($file); ?></p>
    <p>
        <label>Contents</label><br>
        <textarea name="content"><?php echo Helpers::h($content); ?></textarea>
    </p>
    <button type="submit">Update Incident</button>
</form>

<?php require(__DIR__ . '/_footer.php'); ?>
