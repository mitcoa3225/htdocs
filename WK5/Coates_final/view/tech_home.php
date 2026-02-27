<?php
$pageTitle = 'Technician Home';
$homeAction = 'tech_home';
require(__DIR__ . '/_header.php');
?>
<ul>
    <li><a href="index.php?action=incidents_list">Incident Management</a></li>
    <li><a href="index.php?action=db_status">Database Connection Status</a></li>
</ul>
<?php require(__DIR__ . '/_footer.php'); ?>
