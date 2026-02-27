<?php
// ComplaintType class.
// Stores values for this object.


class ComplaintType {

    private $complaintTypeId;
    private $complaintTypeName;

    //constructor
    public function __construct($name) {
        $this->complaintTypeId = 0;
        $this->complaintTypeName = $name;
    }

    //getter/setter to get and set complaint type id
    public function getComplaintTypeId() { return $this->complaintTypeId; }
    public function setComplaintTypeId($value) { $this->complaintTypeId = $value; }

    //getter/setter to get and set complaint type name
    public function getComplaintTypeName() { return $this->complaintTypeName; }
    public function setComplaintTypeName($value) { $this->complaintTypeName = $value; }
}
?>