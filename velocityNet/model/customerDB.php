<?php
// Customers database functions.
// Runs SQL queries for this part of the system.
// Returns results back to controllers.

// Use __DIR__ so this works no matter what file included us.
require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . "/Customer.php");

class CustomerDB {

    //helper function to convert a row into an object
    private static function rowToCustomer($row) {

        // Turn a database row (associative array) into a Customer object.
        $customer = new Customer(
            $row["email"],
            $row["first_name"],
            $row["last_name"],
            $row["street_address"],
            $row["city"],
            $row["state"],
            $row["zip_code"],
            $row["phone_number"],
            $row["customer_password"]
        );

        $customer->setCustomerId((int)$row["customer_id"]);
        return $customer;
    }

    //insert a new record
    public static function insertCustomer($emailText, $firstNameText, $lastNameText, $streetAddressText, $cityText, $stateText, $zipCodeText, $phoneNumberText, $passwordText) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        
        $sql = "insert into customer
                (email, first_name, last_name, street_address, city, state, zip_code, phone_number, customer_password)
                values (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        // Bind form values to prepared statement 
        mysqli_stmt_bind_param(
            $statement,
            "sssssssss",
            $emailText,
            $firstNameText,
            $lastNameText,
            $streetAddressText,
            $cityText,
            $stateText,
            $zipCodeText,
            $phoneNumberText,
            $passwordText
        );

        return mysqli_stmt_execute($statement);
    }

    //get all customers
    public static function getAllCustomers() {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return array();

        /*
            SQL pulls all customer rows, sorted newest first.
        */
        $sql = "select customer_id, email, first_name, last_name, street_address, city, state, zip_code, phone_number, customer_password
                from customer
                order by customer_id desc";

        $result = mysqli_query($conn, $sql);
        $customerList = array();

        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                $customerList[] = self::rowToCustomer($row);
            }
        }

        return $customerList;
    }

    //get customer by id
    public static function getCustomerById($customerIdNumber) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return null;

        /*
            SQL pulls one customer by primary key.
        */
        $sql = "select customer_id, email, first_name, last_name, street_address, city, state, zip_code, phone_number, customer_password
                from customer
                where customer_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return null;

        mysqli_stmt_bind_param($statement, "i", $customerIdNumber);
        mysqli_stmt_execute($statement);

        $result = mysqli_stmt_get_result($statement);
        if ($result == false) return null;

        $row = mysqli_fetch_assoc($result);
        if ($row == null) return null;

        return self::rowToCustomer($row);
    }

    //update an existing record
    public static function updateCustomer($customerIdNumber, $emailText, $firstNameText, $lastNameText, $streetAddressText, $cityText, $stateText, $zipCodeText, $phoneNumberText) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        /*
            SQL updates one customer row.

        */
        $sql = "update customer
                set email = ?, first_name = ?, last_name = ?, street_address = ?, city = ?, state = ?, zip_code = ?, phone_number = ?
                where customer_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        mysqli_stmt_bind_param(
            $statement,
            "ssssssssi",
            $emailText,
            $firstNameText,
            $lastNameText,
            $streetAddressText,
            $cityText,
            $stateText,
            $zipCodeText,
            $phoneNumberText,
            $customerIdNumber
        );

        return mysqli_stmt_execute($statement);
    }

    //update customer password
    public static function updateCustomerPassword($customerIdNumber, $passwordText) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        /*
            SQL updates the password for one customer.
        */
        $sql = "update customer
                set customer_password = ?
                where customer_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        mysqli_stmt_bind_param($statement, "si", $passwordText, $customerIdNumber);
        return mysqli_stmt_execute($statement);
    }

    //get customer by email
    public static function getCustomerByEmail($emailText) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return null;

        /*
            SQL finds one customer row by email.
            Used for login checks.
        */
        $sql = "select customer_id, email, first_name, last_name, street_address, city, state, zip_code, phone_number, customer_password
                from customer
                where email = ?
                limit 1";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return null;

        mysqli_stmt_bind_param($statement, "s", $emailText);
        if (mysqli_stmt_execute($statement) == false) return null;

        $result = mysqli_stmt_get_result($statement);
        if ($result == false) return null;

        $row = mysqli_fetch_assoc($result);
        if ($row == null) return null;

        return self::rowToCustomer($row);
    }


    // Delete one customer by id.
    public static function deleteCustomer($customerIdNumber) {

        $db = new Database();
        $conn = $db->getDbConn();
        if ($conn == false) return false;

        $sql = "delete from customer where customer_id = ?";

        $statement = mysqli_prepare($conn, $sql);
        if ($statement == false) return false;

        mysqli_stmt_bind_param($statement, "i", $customerIdNumber);
        mysqli_stmt_execute($statement);

        return (mysqli_stmt_affected_rows($statement) > 0);
    }

}
?>
