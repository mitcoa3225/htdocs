<?php
//require_once('display_name.php');
require_once('person.php');

//create an instance of the display name class
//$dispName = new DisplayName("Mitchell", "Coates");


//create 5 instances of person class
$person1 = new Person("Adam","Smith","100 Main St","Apt 1A","Richmond","VA","23220");
$person2 = new Person("John","Smith","101 Main St","Apt 1B","Richmond","VA","23220");
$person3 = new Person("Jane","Doe","102 Main St","Apt 1C","Richmond","VA","23220");
$person4 = new Person("Joe","Cool","103 Main St","","Richmond","VA","23220");
$person5 = new Person("Jen","Smith","104 Main St","","Richmond","VA","23220");

//create an array of people
$people = array($person1,$person2,$person3,$person4,$person5);


//get the full name based on the constructor parameters
//$fullName = $dispName->getFullName();

/*Update the first and last names
$dispName->setFirstName("John");
$dispName->setLastName("Smith");*/
?>
<!DOCTYPE html>
<html lang="en">
<html>
       <head>
              <meta charset="UTF-8">
              <title>Week2 PA - Mitchell Coates</title>
              <style>
                     table { border: 2px solid black; border-collapse: separate;}
                     th, td { border: 2px solid black; padding: 6px; text-align: left;}
              </style>
       </head>

       <body>

              <h2><?php echo Person::getHeaderMessage(); ?></h2>
              <table>
                     <tr>
                            <th><?php echo Person::getFullNameLabel(); ?></th>
                            <th><?php echo Person::getAddressLabel(); ?></th>
                            <th><?php echo Person::getCityStateZipLabel(); ?></th>
                     </tr>
                     <?php foreach ($people as $p): ?>
                     <tr>
                            <td><?php echo $p->getFormattedName(); ?></td>
                            <td><?php echo $p->getFormattedAddress(); ?></td>
                            <td><?php echo $p->getFormattedAddressLocation(); ?></td>
                     </tr>
                     <?php endforeach; ?>
              </table>
       </body>
</html>