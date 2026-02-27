<?php
use Utils\Helpers;
$pageTitle = 'User Management - View All Users';
$homeAction = 'admin_home';
require(__DIR__ . '/_header.php');
?>
<p><a href="index.php?action=user_add">Add User</a></p>

<table>
    <tr>
        <th>UserNo</th>
        <th>UserId</th>
        <th>FirstName</th>
        <th>LastName</th>
        <th>HireDate</th>
        <th>EMail</th>
        <th>Extension</th>
        <th>UserLevelNo</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($users as $u): ?>
        <tr>
            <td><?php echo Helpers::h(strval($u->getUserNo())); ?></td>
            <td><?php echo Helpers::h($u->getUserId()); ?></td>
            <td><?php echo Helpers::h($u->getFirstName()); ?></td>
            <td><?php echo Helpers::h($u->getLastName()); ?></td>
            <td><?php echo Helpers::h($u->getHireDate()); ?></td>
            <td><?php echo Helpers::h($u->getEmail()); ?></td>
            <td><?php echo Helpers::h(strval($u->getExtension())); ?></td>
            <td><?php echo Helpers::h(strval($u->getUserLevelNo())); ?></td>
            <td class="actions">
                <a href="index.php?action=user_edit&userNo=<?php echo Helpers::h(strval($u->getUserNo())); ?>">Update</a>
                <a href="index.php?action=user_delete&userNo=<?php echo Helpers::h(strval($u->getUserNo())); ?>" onclick="return confirm('Delete this user?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require(__DIR__ . '/_footer.php'); ?>
