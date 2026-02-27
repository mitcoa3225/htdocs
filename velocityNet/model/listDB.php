<?php
// Lists database functions.
// Runs SQL queries for this part of the system.
// Returns results back to controllers.


require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . "/ProductService.php");
require_once(__DIR__ . "/ComplaintType.php");
require_once(__DIR__ . "/Employee.php");

class ListDB {

    //get all products services
    public static function getAllProductsServices() {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return array();

        /*
            SQL pulls all product/service rows for the complaint form dropdown.
        */
        $sql = "select product_service_id, product_service_name
                from products_services
                order by product_service_name";

        $result = mysqli_query($conn, $sql);
        $list = array();

        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                $ps = new ProductService($row["product_service_name"]);
                $ps->setProductServiceId((int)$row["product_service_id"]);
                $list[] = $ps;
            }
        }

        return $list;
    }

    //get all complaint types
    public static function getAllComplaintTypes() {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return array();

        /*
            SQL pulls all complaint types for the complaint form dropdown.
        */
        $sql = "select complaint_type_id, complaint_type_name
                from complaint_types
                order by complaint_type_name";

        $result = mysqli_query($conn, $sql);
        $list = array();

        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                $type = new ComplaintType($row["complaint_type_name"]);
                $type->setComplaintTypeId((int)$row["complaint_type_id"]);
                $list[] = $type;
            }
        }

        return $list;
    }

    //get all technicians
    public static function getAllTechnicians() {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return array();

        /*
            SQL pulls employees where level = technician.
            Used on the admin assign page.
        */
        $sql = "select employee_id, email, first_name, last_name, level, employee_password
                from employees
                where level = 'technician'
                order by last_name, first_name";

        $result = mysqli_query($conn, $sql);
        $list = array();

        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                $emp = new Employee($row["email"], $row["first_name"], $row["last_name"], $row["level"], $row["employee_password"]);
                $emp->setEmployeeId((int)$row["employee_id"]);
                $list[] = $emp;
            }
        }

        return $list;
    }
}
?>
