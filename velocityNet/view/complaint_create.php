<?php
require_once(__DIR__ . "/../util/security.php");

Security::checkHTTPS();
Security::checkAuthority("customer");

// Complaint Create page.
// Inserts a new complaint (customer side).
// 

require_once(__DIR__ . "/../controller/lists_controller.php");
require_once(__DIR__ . "/../controller/complaint_controller.php");

Security::startSession();

$errorMessage = "";
$successMessage = "";

$productServiceIdNumber = 0;
$complaintTypeIdNumber = 0;
$descriptionText = "";

// dropdown data
$productServiceList = ListsController::getAllProductsServices();
$complaintTypeList = ListsController::getAllComplaintTypes();

// insert when user submits the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customerIdNumber = 0;
    if (isset($_SESSION["customer_id"])) $customerIdNumber = (int)$_SESSION["customer_id"];

    if ($customerIdNumber <= 0) {
        $errorMessage = "Login is required to submit a complaint.";
    }

    $productServiceIdNumber = (int)($_POST["product_service_id"] ?? 0);
    $complaintTypeIdNumber = (int)($_POST["complaint_type_id"] ?? 0);
    $descriptionText = trim((string)($_POST["description"] ?? ""));

    //basic field checks
    if ($productServiceIdNumber <= 0) $errorMessage = "Select a product/service.";
    else if ($complaintTypeIdNumber <= 0) $errorMessage = "Select a complaint type.";
    else if ($descriptionText === "") $errorMessage = "Description is required.";
    else if (strlen($descriptionText) < 10) $errorMessage = "Description must be at least 10 characters.";
    else if (strlen($descriptionText) > 1000) $errorMessage = "Description cannot be longer than 1000 characters.";

    //optional image upload
    $imagePathText = "";
    if ($errorMessage === "" && isset($_FILES["complaint_image"]) && $_FILES["complaint_image"]["error"] !== UPLOAD_ERR_NO_FILE) {

        $fileError = (int)$_FILES["complaint_image"]["error"];
        if ($fileError !== UPLOAD_ERR_OK) {
            $errorMessage = "Image upload failed.";
        } else {

            $tmpName = $_FILES["complaint_image"]["tmp_name"];
            $originalName = (string)$_FILES["complaint_image"]["name"];
            $fileSize = (int)$_FILES["complaint_image"]["size"];

            //limit size so large uploads do not break the page
            if ($fileSize > 2 * 1024 * 1024) {
                $errorMessage = "Image must be 2MB or less.";
            } else {

                $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowedExt = array("jpg", "jpeg", "png", "gif");

                if (!in_array($ext, $allowedExt)) {
                    $errorMessage = "Image must be JPG, PNG, or GIF.";
                } else {

                    $uploadsDir = __DIR__ . "/../uploads";
                    if (!is_dir($uploadsDir)) {
                        @mkdir($uploadsDir, 0755, true);
                    }

                    $newName = "complaint_" . date("Ymd_His") . "_" . bin2hex(random_bytes(4)) . "." . $ext;
                    $destPath = $uploadsDir . "/" . $newName;

                    if (move_uploaded_file($tmpName, $destPath)) {
                        //store relative path so it can be used in links
                        $imagePathText = "uploads/" . $newName;
                    } else {
                        $errorMessage = "Image could not be saved.";
                    }
                }
            }
        }
    }

    //insert only after validation and optional upload finish
    if ($errorMessage === "") {
        $ok = ComplaintController::addComplaint($customerIdNumber, $productServiceIdNumber, $complaintTypeIdNumber, $descriptionText, $imagePathText);

        if ($ok) $successMessage = "Complaint submitted.";
        else $errorMessage = "Insert failed.";
    }
}

require_once("header.php");
?>

<h2>Enter a Complaint</h2>

<?php if ($errorMessage != "") { ?>
    <!-- Show validation error if something was left blank -->
    <p><?php echo $errorMessage; ?></p>
<?php } ?>

<?php if ($successMessage != "") { ?>
    <!-- Show success message after insert -->
    <p><?php echo $successMessage; ?></p>
<?php } ?>

<!-- form to enter complaint -->
<form action="complaint_create.php" method="post" enctype="multipart/form-data">

    <label>Product/Service</label><br>

    <!-- value is product_service_id so the controller can insert the correct id -->
<!-- dropdown list built from database values -->
    <select name="product_service_id">
        <option value="0">Select</option>

<?php //loop through productServiceList and build output ?>
<!-- Loop through list returned from controller -->
        <?php foreach ($productServiceList as $productServiceRow) { ?>
            <option value="<?php echo $productServiceRow->getProductServiceId(); ?>" <?php if ($productServiceIdNumber == $productServiceRow->getProductServiceId()) echo "selected"; ?>>
                <?php echo $productServiceRow->getProductServiceName(); ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Complaint Type</label><br>

<!-- dropdown list built from database values -->
    <select name="complaint_type_id">
        <option value="0">Select</option>

<?php //loop through complaintTypeList and build output ?>
<!-- Loop through complaints returned from controller -->
        <?php foreach ($complaintTypeList as $complaintTypeRow) { ?>
            <option value="<?php echo $complaintTypeRow->getComplaintTypeId(); ?>" <?php if ($complaintTypeIdNumber == $complaintTypeRow->getComplaintTypeId()) echo "selected"; ?>>
                <?php echo $complaintTypeRow->getComplaintTypeName(); ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Description</label><br>

    <!-- typed description is stored in complaints.description -->
    <textarea name="description" rows="6" cols="50"><?php echo htmlspecialchars($descriptionText); ?></textarea>

    <br><br>

    <label>Upload Image (optional)</label><br>
    <input type="file" name="complaint_image" accept="image/*">

    <br><br>

    <input type="submit" value="Submit Complaint">

</form>

<?php require_once("footer.php"); ?>