<?php
require_once(__DIR__ . '/text_file_utilities.php');

// Directory for text files (must be in application root /text_files)
$dir = __DIR__ . '/text_files/';

$viewFile = '';
$editFile = '';
$message = '';

// View file contents (non-editable)
if (isset($_POST['view'])) {
    $fName = TextFileUtilities::CleanFileName($_POST['fileToView']);
    $viewFile = TextFileUtilities::GetFileContents($dir . $fName);
    $editFile = '';
}

// Load file for editing
if (isset($_POST['load'])) {
    $fName = TextFileUtilities::CleanFileName($_POST['fileToUpdate']);
    $editFile = TextFileUtilities::GetFileContents($dir . $fName);
    $viewFile = '';
}

// Save edited file contents
if (isset($_POST['save'])) {
    $fName = TextFileUtilities::CleanFileName($_POST['fileToUpdate']);
    $content = $_POST['editFile'];
    TextFileUtilities::WriteFile($dir . $fName, $content);
    $editFile = '';
    $viewFile = '';
    $message = 'File saved.';
}

// Create a new file
if (isset($_POST['create'])) {
    $fName = TextFileUtilities::CleanFileName($_POST['newFileName']);

    // If user did not type an extension, add .txt
    if ($fName != '' && pathinfo($fName, PATHINFO_EXTENSION) == '') {
        $fName .= '.txt';
    }

    $content = $_POST['createFile'];
    if ($fName != '') {
        TextFileUtilities::WriteFile($dir . $fName, $content);
        $message = 'File created.';
    }

    $editFile = '';
    $viewFile = '';
}

$files = TextFileUtilities::GetFileList($dir);
?>
<html>
<head>
    <title>Mitchell Coates Wk 5 Performance Assessment</title>
</head>
<body>
    <h1>Text File Operations</h1>

    <p><a href="index.php">Home</a></p>

    <?php if ($message != '') : ?>
        <p><strong><?php echo $message; ?></strong></p>
    <?php endif; ?>

    <h3>Text Files Available:</h3>
    <ul>
        <?php foreach ($files as $file) : ?>
            <li><?php echo $file; ?></li>
        <?php endforeach; ?>
    </ul>

    <form method="POST">
        <h3>
            View Text File:
            <select name="fileToView">
                <?php foreach ($files as $file) : ?>
                    <option value="<?php echo $file; ?>"><?php echo $file; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="View File" name="view">
        </h3>
        <textarea id="viewFile" name="viewFile" rows="8" cols="70" disabled><?php echo $viewFile; ?></textarea>

        <h3>
            Update Text File:
            <select name="fileToUpdate">
                <?php foreach ($files as $file) : ?>
                    <option value="<?php echo $file; ?>"><?php echo $file; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Load File" name="load">
            <input type="submit" value="Save" name="save">
        </h3>
        <textarea id="editFile" name="editFile" rows="8" cols="70"><?php echo $editFile; ?></textarea>

        <h3>
            Create Text File:
            <input type="text" name="newFileName" placeholder="example.txt">
            <input type="submit" value="Create" name="create">
        </h3>
        <textarea id="createFile" name="createFile" rows="8" cols="70"></textarea>
    </form>
</body>
</html>
