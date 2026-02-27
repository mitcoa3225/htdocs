<?php
//Role class to represent a single entry in the Roles table
class Role {
 //class properties - match the columns in the
 //Roles table; control access via get/set
 //methods and the constructor
 private $roleNo;
 private $roleName;

 public function __construct($roleNo, $roleName) {
 $this->roleNo = $roleNo;
 $this->roleName = $roleName;
    }

 //get and set the roleNo property
 public function getRoleNo() {
 return $this->roleNo;
    }
 public function setRoleNo($value) {
 $this->roleNo = $value;
    }

 //get and set roleName property
 public function getRoleName() {
 return $this->roleName;
    }
 public function setRoleName($value) {
 $this->roleName = $value;
    }
}