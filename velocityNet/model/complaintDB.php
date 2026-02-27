<?php
// Complaints database functions.
// Runs SQL queries for this part of the system.
// Returns results back to controllers.


require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . "/Complaint.php");

class ComplaintDB {

    //helper function to convert a row into an object
    private static function rowToComplaintWithNames($row) {

        // Convert a joined row into a Complaint object.
        $employeeId = null;
        if ($row["employee_id"] != null) $employeeId = (int)$row["employee_id"];

        $complaint = new Complaint(
            (int)$row["customer_id"],
            $employeeId,
            (int)$row["product_service_id"],
            (int)$row["complaint_type_id"],
            $row["description"],
            $row["status"]
        );

        $complaint->setComplaintId((int)$row["complaint_id"]);
        $complaint->setImagePath($row["complaint_image"] == null ? "" : $row["complaint_image"]);
        $complaint->setTechnicianNotes($row["technician_notes"] == null ? "" : $row["technician_notes"]);
        $complaint->setResolutionDate($row["resolution_date"] == null ? "" : $row["resolution_date"]);
        $complaint->setResolutionNotes($row["resolution_notes"] == null ? "" : $row["resolution_notes"]);
        $complaint->setCreatedAt($row["created_at"]);

        // set display-only fields from joins.
        $complaint->setCustomerName($row["customer_name"]);
        $complaint->setEmployeeName($row["employee_name"] == null ? "" : $row["employee_name"]);
        $complaint->setProductServiceName($row["product_service_name"]);
        $complaint->setComplaintTypeName($row["complaint_type_name"]);

        return $complaint;
    }

    //insert a new record
    public static function insertComplaint($customerIdNumber, $productServiceIdNumber, $complaintTypeIdNumber, $complaintDescriptionText, $imagePathText) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        /*
            SQL inserts a new complaint.

            status starts as 'open'.
            employee_id starts as null until an admin assigns a technician.
        */
        $sql = "insert into complaints
                (customer_id, product_service_id, complaint_type_id, description, complaint_image, status)
                values (?, ?, ?, ?, ?, 'open')";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        mysqli_stmt_bind_param($statement, "iiiss", $customerIdNumber, $productServiceIdNumber, $complaintTypeIdNumber, $complaintDescriptionText, $imagePathText);
        return mysqli_stmt_execute($statement);
    }

    //get all complaints with names
    public static function getAllComplaintsWithNames() {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return array();

        /*
            get all complaints with related customer, employee, product, and type details
            joins multiple tables so names can be displayed instead of ids
            orders by newest complaint first

        */
        $sql = "select c.complaint_id,
                       c.customer_id,
                       c.employee_id,
                       c.product_service_id,
                       c.complaint_type_id,
                       c.description,
                       c.complaint_image,
                       c.status,
                       c.technician_notes,
                       c.resolution_date,
                       c.resolution_notes,
                       c.created_at,
                       concat(cu.first_name, ' ', cu.last_name) customer_name,
                       concat(e.first_name, ' ', e.last_name) employee_name,
                       ps.product_service_name,
                       ct.complaint_type_name
                from complaints c
                join customer cu on c.customer_id = cu.customer_id
                left join employees e on c.employee_id = e.employee_id
                join products_services ps on c.product_service_id = ps.product_service_id
                join complaint_types ct on c.complaint_type_id = ct.complaint_type_id
                order by c.complaint_id desc";

        $result = mysqli_query($conn, $sql);
        $list = array();

        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                $list[] = self::rowToComplaintWithNames($row);
            }
        }

        return $list;
    }

    //get open complaints with names
    public static function getOpenComplaintsWithNames() {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return array();

        /*
            get only open complaints with customer, employee, product, and type names
            joins related tables so full names shown instead of ids
            filters results to status open and sorts newest first
        */
        $sql = "select c.complaint_id,
                       c.customer_id,
                       c.employee_id,
                       c.product_service_id,
                       c.complaint_type_id,
                       c.description,
                       c.complaint_image,
                       c.status,
                       c.technician_notes,
                       c.resolution_date,
                       c.resolution_notes,
                       c.created_at,
                       concat(cu.first_name, ' ', cu.last_name) customer_name,
                       concat(e.first_name, ' ', e.last_name) employee_name,
                       ps.product_service_name,
                       ct.complaint_type_name
                from complaints c
                join customer cu on c.customer_id = cu.customer_id
                left join employees e on c.employee_id = e.employee_id
                join products_services ps on c.product_service_id = ps.product_service_id
                join complaint_types ct on c.complaint_type_id = ct.complaint_type_id
                where c.status = 'open'
                order by c.complaint_id desc";

        $result = mysqli_query($conn, $sql);
        $list = array();

        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                $list[] = self::rowToComplaintWithNames($row);
            }
        }

        return $list;
    }

    //get unassigned open complaints with names
    public static function getUnassignedOpenComplaintsWithNames() {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return array();

        /*
            get open complaints that are not assigned to any employee
            joins related tables
            filters for open status with no employee and sorts newest first
        */
        $sql = "select c.complaint_id,
                       c.customer_id,
                       c.employee_id,
                       c.product_service_id,
                       c.complaint_type_id,
                       c.description,
                       c.complaint_image,
                       c.status,
                       c.technician_notes,
                       c.resolution_date,
                       c.resolution_notes,
                       c.created_at,
                       concat(cu.first_name, ' ', cu.last_name) customer_name,
                       concat(e.first_name, ' ', e.last_name) employee_name,
                       ps.product_service_name,
                       ct.complaint_type_name
                from complaints c
                join customer cu on c.customer_id = cu.customer_id
                left join employees e on c.employee_id = e.employee_id
                join products_services ps on c.product_service_id = ps.product_service_id
                join complaint_types ct on c.complaint_type_id = ct.complaint_type_id
                where c.status = 'open' and c.employee_id is null
                order by c.complaint_id desc";

        $result = mysqli_query($conn, $sql);
        $list = array();

        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                $list[] = self::rowToComplaintWithNames($row);
            }
        }

        return $list;
    }

    //run assign complaint to technician
    public static function assignComplaintToTechnician($complaintIdNumber, $employeeIdNumber) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        /*
            SQL assigns a technician by setting employee_id for the complaint.
        */
        $sql = "update complaints
                set employee_id = ?
                where complaint_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        mysqli_stmt_bind_param($statement, "ii", $employeeIdNumber, $complaintIdNumber);
        return mysqli_stmt_execute($statement);
    }

    //get complaints by employee id with names
    public static function getComplaintsByEmployeeIdWithNames($employeeIdNumber) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return array();

        /*
            get complaints assigned to a specific employee id
            joins related tables to show customer, employee, product, and type names
            filters by employee id and sorts newest complaints first
        */
        $sql = "select c.complaint_id,
                       c.customer_id,
                       c.employee_id,
                       c.product_service_id,
                       c.complaint_type_id,
                       c.description,
                       c.complaint_image,
                       c.status,
                       c.technician_notes,
                       c.resolution_date,
                       c.resolution_notes,
                       c.created_at,
                       concat(cu.first_name, ' ', cu.last_name) customer_name,
                       concat(e.first_name, ' ', e.last_name) employee_name,
                       ps.product_service_name,
                       ct.complaint_type_name
                from complaints c
                join customer cu on c.customer_id = cu.customer_id
                left join employees e on c.employee_id = e.employee_id
                join products_services ps on c.product_service_id = ps.product_service_id
                join complaint_types ct on c.complaint_type_id = ct.complaint_type_id
                where c.employee_id = ?
                order by c.complaint_id desc";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return array();

        mysqli_stmt_bind_param($statement, "i", $employeeIdNumber);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        $list = array();

        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                $list[] = self::rowToComplaintWithNames($row);
            }
        }

        return $list;
    }

    //get complaint by id
    public static function getComplaintById($complaintIdNumber) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return null;

        /*
            get one complaint by complaint id
            joins related tables so page can display names instead of id numbers
            filters results to single complaint id
        */
        $sql = "select c.complaint_id,
                       c.customer_id,
                       c.employee_id,
                       c.product_service_id,
                       c.complaint_type_id,
                       c.description,
                       c.complaint_image,
                       c.status,
                       c.technician_notes,
                       c.resolution_date,
                       c.resolution_notes,
                       c.created_at,
                       concat(cu.first_name, ' ', cu.last_name) customer_name,
                       concat(e.first_name, ' ', e.last_name) employee_name,
                       ps.product_service_name,
                       ct.complaint_type_name
                from complaints c
                join customer cu on c.customer_id = cu.customer_id
                left join employees e on c.employee_id = e.employee_id
                join products_services ps on c.product_service_id = ps.product_service_id
                join complaint_types ct on c.complaint_type_id = ct.complaint_type_id
                where c.complaint_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return null;

        mysqli_stmt_bind_param($statement, "i", $complaintIdNumber);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        if ($result == false) return null;

        $row = mysqli_fetch_assoc($result);
        if ($row == null) return null;

        return self::rowToComplaintWithNames($row);
    }

    //update an existing record
    public static function updateComplaintTechnicianFields($complaintIdNumber, $technicianNotesText, $statusText, $resolutionDateText, $resolutionNotesText) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        /*
            SQL updates technician-controlled fields.
            Used when a technician marks a complaint resolved or adds notes.
        */
        $sql = "update complaints
                set technician_notes = ?,
                    status = ?,
                    resolution_date = ?,
                    resolution_notes = ?
                where complaint_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        mysqli_stmt_bind_param($statement, "ssssi", $technicianNotesText, $statusText, $resolutionDateText, $resolutionNotesText, $complaintIdNumber);
        return mysqli_stmt_execute($statement);
    }

    //get technician open complaint counts
    public static function getTechnicianOpenComplaintCounts() {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return array();

        /*
           count open complaints for each tech
           uses left join so techs with zero open complaints are included
           groups by employee and sorts by highest open count
        */
        $sql = "select e.employee_id,
                       e.user_id,
                       e.first_name,
                       e.last_name,
                       concat(e.first_name, ' ', e.last_name) employee_name,
                       count(c.complaint_id) open_count
                from employees e
                left join complaints c
                    on e.employee_id = c.employee_id
                    and c.status = 'open'
                where lower(e.level) = 'technician'
                group by e.employee_id, e.user_id, e.first_name, e.last_name
                order by open_count desc, employee_name";

        $result = mysqli_query($conn, $sql);
        $list = array();

        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Keep counts as associative arrays because this is a report row, not a full table entity.
                $list[] = array(
                    "employee_id" => (int)$row["employee_id"],
                    "user_id" => $row["user_id"],
                    "first_name" => $row["first_name"],
                    "last_name" => $row["last_name"],
                    "employee_name" => $row["employee_name"],
                    "open_count" => (int)$row["open_count"]
                );
            }
        }

        return $list;
    }

    //get complaints by customer id
    public static function getComplaintsByCustomerIdWithNames($customerIdNumber) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return array();

        /*
            SQL pulls complaint rows for one customer.
            Joins other tables so the list can display names.
            Orders by newest complaint first.
        */
        $sql = "select c.complaint_id,
                       c.customer_id,
                       c.employee_id,
                       c.product_service_id,
                       c.complaint_type_id,
                       c.description,
                       c.complaint_image,
                       c.status,
                       c.technician_notes,
                       c.resolution_date,
                       c.resolution_notes,
                       c.created_at,
                       concat(cu.first_name, ' ', cu.last_name) customer_name,
                       concat(e.first_name, ' ', e.last_name) employee_name,
                       ps.product_service_name,
                       ct.complaint_type_name
                from complaints c
                join customer cu on c.customer_id = cu.customer_id
                left join employees e on c.employee_id = e.employee_id
                join products_services ps on c.product_service_id = ps.product_service_id
                join complaint_types ct on c.complaint_type_id = ct.complaint_type_id
                where c.customer_id = ?
                order by c.complaint_id desc";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return array();

        mysqli_stmt_bind_param($statement, "i", $customerIdNumber);
        if (mysqli_stmt_execute($statement) == false) return array();

        $result = mysqli_stmt_get_result($statement);
        $list = array();

        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                $list[] = self::rowToComplaintWithNames($row);
            }
        }

        return $list;
    }


    // Delete one complaint by id.
    public static function deleteComplaint($complaintIdNumber) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        $sql = "delete from complaints where complaint_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        mysqli_stmt_bind_param($statement, "i", $complaintIdNumber);
        mysqli_stmt_execute($statement);

        return (mysqli_stmt_affected_rows($statement) > 0);
    }

    // Delete all complaints for a customer.
    public static function deleteComplaintsByCustomerId($customerIdNumber) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        $sql = "delete from complaints where customer_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        mysqli_stmt_bind_param($statement, "i", $customerIdNumber);
        mysqli_stmt_execute($statement);

        // Zero rows affected is ok (customer may have no complaints).
        return (mysqli_stmt_errno($statement) === 0);
    }

    // Unassign an employee from any complaints before deleting that employee.
    public static function clearEmployeeFromComplaints($employeeIdNumber) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        $sql = "update complaints set employee_id = null where employee_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        mysqli_stmt_bind_param($statement, "i", $employeeIdNumber);
        mysqli_stmt_execute($statement);

        return (mysqli_stmt_errno($statement) === 0);
    }

}
?>
