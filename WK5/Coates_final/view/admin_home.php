<?php
$pageTitle = 'Administrator Home';
$homeAction = 'admin_home';
require(__DIR__ . '/_header.php');
?>
<ul>
    <li><a href="index.php?action=users_list">User Management</a></li>
    <li><a href="index.php?action=images_list">Image File Management</a></li>
</ul>
<?php require(__DIR__ . '/_footer.php'); ?>
