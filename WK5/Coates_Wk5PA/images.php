<?php
require_once(__DIR__ . '/image_utilities.php');

$dir = __DIR__ . '/images/';
$imgName = '';
$message = '';

// View selected images
if (isset($_POST['view'])) {
    $imgName = ImageUtilities::CleanFileName($_POST['image_file']);
}

// Delete selected images (all sizes)
if (isset($_POST['delete'])) {
    $fName = ImageUtilities::CleanFileName($_POST['image_file']);
    ImageUtilities::DeleteImageFiles($dir, $fName);
    $imgName = '';
    $message = 'Image deleted.';
}

// Upload a new file and process into sizes
if (isset($_POST['upload'])) {
    $cleanName = ImageUtilities::CleanFileName($_FILES['new_file']['name']);

    if ($cleanName == '') {
        $message = 'Please choose an image file.';
    } else {
        $target = $dir . $cleanName;

        if (!is_uploaded_file($_FILES['new_file']['tmp_name'])) {
            $message = 'Upload failed (no temp file found).';
        } else if (!move_uploaded_file($_FILES['new_file']['tmp_name'], $target)) {
            $message = 'Upload failed (could not move file into /images). Check folder permissions.';
        } else {
            $ok = ImageUtilities::ProcessImage($target);

            if ($ok) {
                // Verify resized files exist
                if (file_exists($dir . '100/' . $cleanName) &&
                    file_exists($dir . '250/' . $cleanName) &&
                    file_exists($dir . '500/' . $cleanName)) {
                    $message = 'Image uploaded and resized.';
                } else {
                    $message = 'Uploaded, but resized files were not created (GD library may be missing).';
                }
            } else {
                $message = 'Upload failed (file is not a valid PNG/JPG image, or server cannot resize).';
                if (file_exists($target)) {
                    unlink($target);
                }
            }
        }
    }

    $imgName = '';
}

$images = ImageUtilities::GetBaseImagesList($dir);
?>
<html>
<head>
    <title>Mitchell Coates Wk 5 Performance Assessment</title>
</head>
<body>
    <h1>Image File Operations</h1>

    <p><a href="index.php">Home</a></p>

    <?php if ($message != '') : ?>
        <p><strong><?php echo $message; ?></strong></p>
    <?php endif; ?>

    <form method="POST">
        <h3>
            Image Files:
            <select name="image_file">
                <?php foreach ($images as $file) : ?>
                    <option value="<?php echo $file; ?>"><?php echo $file; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="View Image" name="view">
            <input type="submit" value="Delete Image" name="delete">
        </h3>
    </form>

    <h3>Upload Image File:</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="new_file" id="new_file" accept="image/png,image/jpeg">
        <input type="submit" value="Upload" name="upload">
    </form>

    <hr>

    <h4>Original Image:</h4>
    <?php if ($imgName != '') : ?>
        <img src="images/<?php echo $imgName; ?>" alt="<?php echo $imgName; ?>">
    <?php endif; ?>

    <h4>100px Max Image:</h4>
    <?php if ($imgName != '') : ?>
        <img src="images/100/<?php echo $imgName; ?>" alt="<?php echo $imgName; ?>">
    <?php endif; ?>

    <h4>250px Max Image:</h4>
    <?php if ($imgName != '') : ?>
        <img src="images/250/<?php echo $imgName; ?>" alt="<?php echo $imgName; ?>">
    <?php endif; ?>

    <h4>500px Max Image:</h4>
    <?php if ($imgName != '') : ?>
        <img src="images/500/<?php echo $imgName; ?>" alt="<?php echo $imgName; ?>">
    <?php endif; ?>
</body>
</html>
