<?php
use Utils\Helpers;

$isEdit = isset($isEdit) ? $isEdit : false;
$pageTitle = $isEdit ? 'User Management - Update User' : 'User Management - Add User';
$homeAction = 'admin_home';
require(__DIR__ . '/_header.php');

$errs = isset($errors) ? $errors : [];
$val = isset($values) ? $values : [];

function fieldVal($key, $default = '') {
    global $val;
    return isset($val[$key]) ? strval($val[$key]) : $default;
}
function fieldErr($key) {
    global $errs;
    return isset($errs[$key]) ? strval($errs[$key]) : '';
}

$userNo = isset($userNo) ? intval($userNo) : 0;
$action = $isEdit ? 'user_edit_save' : 'user_add_save';
?>

<form method="post" action="index.php?action=<?php echo Helpers::h($action); ?>">
    <?php if ($isEdit): ?>
        <input type="hidden" name="userNo" value="<?php echo Helpers::h(strval($userNo)); ?>">
    <?php endif; ?>

    <p>
        <label>UserId (max 12 chars)</label><br>
        <input type="text" name="UserId" value="<?php echo Helpers::h(fieldVal('UserId')); ?>">
        <?php if (fieldErr('UserId') !== ''): ?><span class="error"><?php echo Helpers::h(fieldErr('UserId')); ?></span><?php endif; ?>
    </p>

    <p>
        <label>Password (max 20 chars)</label><br>
        <input type="text" name="Password" value="<?php echo Helpers::h(fieldVal('Password')); ?>">
        <?php if (fieldErr('Password') !== ''): ?><span class="error"><?php echo Helpers::h(fieldErr('Password')); ?></span><?php endif; ?>
    </p>

    <p>
        <label>First Name</label><br>
        <input type="text" name="FirstName" value="<?php echo Helpers::h(fieldVal('FirstName')); ?>">
        <?php if (fieldErr('FirstName') !== ''): ?><span class="error"><?php echo Helpers::h(fieldErr('FirstName')); ?></span><?php endif; ?>
    </p>

    <p>
        <label>Last Name</label><br>
        <input type="text" name="LastName" value="<?php echo Helpers::h(fieldVal('LastName')); ?>">
        <?php if (fieldErr('LastName') !== ''): ?><span class="error"><?php echo Helpers::h(fieldErr('LastName')); ?></span><?php endif; ?>
    </p>

    <p>
        <label>Hire Date (YYYY-MM-DD)</label><br>
        <input type="date" name="HireDate" value="<?php echo Helpers::h(fieldVal('HireDate')); ?>">
        <?php if (fieldErr('HireDate') !== ''): ?><span class="error"><?php echo Helpers::h(fieldErr('HireDate')); ?></span><?php endif; ?>
    </p>

    <p>
        <label>Email</label><br>
        <input type="text" name="EMail" value="<?php echo Helpers::h(fieldVal('EMail')); ?>">
        <?php if (fieldErr('EMail') !== ''): ?><span class="error"><?php echo Helpers::h(fieldErr('EMail')); ?></span><?php endif; ?>
    </p>

    <p>
        <label>Extension (int(5))</label><br>
        <input type="text" name="Extension" value="<?php echo Helpers::h(fieldVal('Extension')); ?>">
        <?php if (fieldErr('Extension') !== ''): ?><span class="error"><?php echo Helpers::h(fieldErr('Extension')); ?></span><?php endif; ?>
    </p>

    <p>
        <label>User Level</label><br>
        <select name="UserLevelNo">
            <option value="">-- Select --</option>
            <option value="1" <?php echo fieldVal('UserLevelNo')==='1' ? 'selected' : ''; ?>>1 - Administrator</option>
            <option value="2" <?php echo fieldVal('UserLevelNo')==='2' ? 'selected' : ''; ?>>2 - Technician</option>
        </select>
        <?php if (fieldErr('UserLevelNo') !== ''): ?><span class="error"><?php echo Helpers::h(fieldErr('UserLevelNo')); ?></span><?php endif; ?>
    </p>

    <button type="submit"><?php echo $isEdit ? 'Update User' : 'Add User'; ?></button>
    <a href="index.php?action=users_list">Cancel</a>
</form>

<?php require(__DIR__ . '/_footer.php'); ?>
