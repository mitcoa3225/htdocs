<?php
use Utils\Helpers;
$pageTitle = 'View Image - Original and 200x200 Max';
$homeAction = 'admin_home';
require(__DIR__ . '/_header.php');

$file = isset($file) ? $file : '';
$origWeb = 'images/' . $file;
$resizedWeb = 'images/200/' . $file;
?>
<p><a href="index.php?action=images_list">Back to Images</a></p>

<h3>Original</h3>
<p><img src="<?php echo Helpers::h($origWeb); ?>" alt="Original"></p>

<h3>Resized (max 200x200)</h3>
<p><img src="<?php echo Helpers::h($resizedWeb); ?>" alt="Resized"></p>

<?php require(__DIR__ . '/_footer.php'); ?>
