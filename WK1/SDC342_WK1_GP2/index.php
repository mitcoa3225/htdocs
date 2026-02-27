
<?php
 function numericValue($val) {
 if (!is_numeric($val)) {
 throw new Exception('Not a valid number');
        }
    }
 //Declare and clear variables
 $name = '';
 $ip_address = '';
 $phone = '';
 $num = '';
 //Declare and clear variables for error messages
 $name_error = '';
 $ip_address_error = '';
 $phone_error = '';
 $num_error = '';
 //Retrieve values from query string and store in a local variable
 //as long as the query string exists (which it does not on first
 //load of a page).
 if (isset($_POST['name']))
 $name = $_POST['name'];
 if (isset($_POST['ip']))
 $ip_address = $_POST['ip'];
 if (isset($_POST['phone']))
 $phone = $_POST['phone'];
 if (isset($_POST['num']))
 $num = $_POST['num'];
 //Validate the values entered
 //Simple validation using control statement
 if (strlen($name) < 3)
 $name_error = "Name must be 3 or more characters.";

 //Validation using PHP built-in validation format
 if (strlen($ip_address) > 0) {
 if (!filter_var($ip_address, FILTER_VALIDATE_IP))
 $ip_address_error = "Enter a valid IP address.";
    }
 //Validation using REGEX, pattern ###-###-####
 if (strlen($phone) > 0) {
 if (!preg_match("/^\d{3}-\d{3}-\d{4}$/", $phone))
 $phone_error = "Must be format ###-###-####";
    }
 //Validation using excpetion handling (try-catch)
 if (strlen($num) > 0) {
 try {
 numericValue($num);
        }
 catch (Exception $e) {
 $num_error = $e->getMessage();
        }
    }
?>
<html>
<head>
 <title>Week1 GP2 - Mitchell Coates</title>
</head>
<body>
 <h2>Enter data for Validation</h2>
 <form method='POST'>
 <h3>Enter your name: <input type="text" name="name"
 value="<?php echo $name; ?>">
 <?php if (strlen($name_error) > 0) 
 echo "<span style='color: red;'>{$name_error}</span>"; ?>
 </h3>
 <h3>Enter an IP address: <input type="text" name="ip"
 value="<?php echo $ip_address; ?>">
 <?php if (strlen($ip_address_error) > 0) 
 echo "<span style='color: red;'>
                    {$ip_address_error}</span>"; ?>
 </h3>
 <h3>Enter a phone number: <input type="text" name="phone"
 value="<?php echo $phone; ?>">
 <?php if (strlen($phone_error) > 0) 
 echo "<span style='color: red;'>{$phone_error}</span>"; ?>
 </h3>
 <h3>Enter a number: <input type="text" name="num"
 value="<?php echo $num; ?>">
 <?php if (strlen($num_error) > 0) 
 echo "<span style='color: red;'>{$num_error}</span>"; ?>
 </h3>
 <input type="submit" value="Validate Values">
 </form>
 <h3><?php
 if (strlen($name_error) > 0 || strlen($ip_address_error) > 0
            || strlen($phone_error) > 0 || strlen($num_error) > 0) {
 echo "There are validation errors!";
        } else {
 echo "All fields validate - no errors!";
        }
 ?>
 </h3>
</body>
</html>