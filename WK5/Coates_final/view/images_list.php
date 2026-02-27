<?php
use Utils\Helpers;
$pageTitle = 'Image File Management';
$homeAction = 'admin_home';
require(__DIR__ . '/_header.php');

$msg = isset($message) ? $message : '';
?>

<h3>Upload Image</h3>
<form method="post" action="index.php?action=image_upload" enctype="multipart/form-data">
    <input type="file" name="imageFile" accept="image/png,image/jpeg">
    <button type="submit">Upload</button>
</form>

<?php if ($msg !== ''): ?>
    <p><?php echo Helpers::h($msg); ?></p>
<?php endif; ?>

<h3>Available Images</h3>
<ul>
<?php foreach ($images as $img): ?>
    <li>
        <?php echo Helpers::h($img); ?>
        - <a href="index.php?action=image_view&file=<?php echo Helpers::h($img); ?>">View</a>
        - <a href="index.php?action=image_delete&file=<?php echo Helpers::h($img); ?>" onclick="return confirm('Delete this image?');">Delete</a>
    </li>
<?php endforeach; ?>
</ul>

<?php require(__DIR__ . '/_footer.php'); ?>
