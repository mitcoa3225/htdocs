<?php
use Utils\Helpers;

$title = isset($pageTitle) ? $pageTitle : 'Home';
$homeAction = isset($homeAction) ? $homeAction : '';
$flash = isset($_SESSION['flash_msg']) ? $_SESSION['flash_msg'] : '';
unset($_SESSION['flash_msg']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mitchell Coates Final Practical</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .topbar { display:flex; gap:12px; align-items:center; }
        .topbar form { display:inline; margin:0; }
        .flash { padding:10px; background:#f2f2f2; border:1px solid #ccc; margin: 12px 0; }
        .error { color: #b00020; font-size: 0.9em; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #999; padding: 6px 8px; text-align: left; }
        th { background: #eee; }
        input[type=text], input[type=password], input[type=date], select, textarea { width: 100%; max-width: 520px; padding: 6px; }
        textarea { height: 180px; }
        .actions a { margin-right: 10px; }
    </style>
</head>
<body>

<h1>Mitchell Coates Final Practical</h1>
<h2><?php echo Helpers::h($title); ?></h2>

<div class="topbar">
    <?php if ($homeAction !== ''): ?>
        <a href="index.php?action=<?php echo Helpers::h($homeAction); ?>">Home</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
        <form method="post" action="index.php?action=logout">
            <button type="submit">Logout</button>
        </form>
        <div>
            Logged in as: <strong><?php echo Helpers::h(strval($_SESSION['user_name'] ?? '')); ?></strong>
            (Level <?php echo Helpers::h(strval($_SESSION['user_level'] ?? '')); ?>)
        </div>
    <?php endif; ?>
</div>

<?php if ($flash !== ''): ?>
    <div class="flash"><?php echo Helpers::h($flash); ?></div>
<?php endif; ?>

<hr>
