<?php
//helper functions for dealing with security

class Security {
 public static function checkHTTPS() {
 //if not HTTPS, post a message and exit
 if (!isset($_SERVER['HTTPS']) 
            || $_SERVER['HTTPS'] != 'on') 
        {
 //for demonstration - normally just
 //redirect to your https:// url
 echo "<h1>HTTPS is Required!</h1>";
 exit();
        }
    }
}