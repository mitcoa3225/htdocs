<?php
require_once(__DIR__.'\file_utilities.php');

//get logs directory in current working directory
$dir = getcwd() . "/logs/";

$viewFile = '';
$editFile = '';

//User selected to view file contents
if (isset($_POST['view'])) {
 $fName = $_POST['fileToView'];
 $viewFile = FileUtilities::GetFileContents($dir . $fName);
 $editFile = '';
}

//User is loading a file to edit
if (isset($_POST['load'])) {
 $fName = $_POST['fileToUpdate'];
 $editFile = FileUtilities::GetFileContents($dir . $fName);
 $viewFile = '';
}

//User wants to save edited file contents
if (isset($_POST['save'])) {
 $fName = $_POST['fileToUpdate'];
 $content = $_POST['editFile'];
 FileUtilities::WriteFile($dir . $fName, $content);
 $editFile = '';
 $viewFile = '';
}

//User wants to create a new file
if (isset($_POST['create'])) {
 $fName = $_POST['newFileName'];
 $content = $_POST['createFile'];
 FileUtilities::WriteFile($dir . $fName, $content);
 $editFile = '';
 $viewFile = '';
}
?>
<html>
<head>
 <title>Week5 GP1 - Mitchell Coates</title>
</head>
<body>
 <h1>Week5 GP1 - Mitchell Coates</h1>
 <h3>Log Files Available:</h3>
 <form method="POST">
 <ul>
 <?php foreach(FileUtilities::GetFileList($dir) as $file) : ?>
 <li><?php echo $file?></li>
 <?php endforeach; ?>
 </ul>
 <h3>View Log File: <select name="fileToView">
 <?php foreach(FileUtilities::GetFileList($dir) as $file) : ?>
 <option value="<?php echo $file; ?>"><?php echo $file; ?>
 </option>
 <?php endforeach; ?></select>
 <input type="submit" value="View File" name="view">
 </h3>
 <textarea id="viewFile" name="viewFile" rows="5" cols="50"
 disabled><?php echo $viewFile ?></textarea>
 <h3>Update Log File: <select name="fileToUpdate">
 <?php foreach(FileUtilities::GetFileList($dir) as $file) : ?>
 <option value="<?php echo $file; ?>"><?php echo $file; ?>
 </option>
 <?php endforeach; ?></select>
 <input type="submit" value="Load File" name="load">
 <input type="submit" value="Save" name="save">
 </h3>
 <textarea id="editFile" name="editFile" rows="5" cols="50"
 ><?php echo $editFile ?></textarea>
 <h3>Create Log File: 
 <input type="text" name="newFileName">
 <input type="submit" value="Create" name="create">
 </h3>
 <textarea id="createFile" name="createFile" rows="5" cols="50"></textarea>
 </form>
</body>
</html>