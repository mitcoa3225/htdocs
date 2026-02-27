<?php
use Utils\Helpers;
$pageTitle = 'View Incident (Read Only)';
$homeAction = 'tech_home';
require(__DIR__ . '/_header.php');

$file = isset($file) ? $file : '';
$content = isset($content) ? $content : '';
?>
<p><a href="index.php?action=incidents_list">Back to Incidents</a></p>

<p><strong>File:</strong> <?php echo Helpers::h($file); ?></p>
<pre style="border:1px solid #999; padding:10px; background:#fafafa; white-space:pre-wrap;"><?php echo Helpers::h($content); ?></pre>

<?php require(__DIR__ . '/_footer.php'); ?>
