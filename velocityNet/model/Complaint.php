<?php
// Complaint class.
// Stores values for this object.


class Complaint {

    private $complaintId;
    private $customerId;
    private $employeeId;
    private $productServiceId;
    private $complaintTypeId;
    private $description;
    private $imagePath;
    private $status;

    private $technicianNotes;
    private $resolutionDate;
    private $resolutionNotes;
    private $createdAt;

    // Optional display-only fields (from joins).
    private $customerName;
    private $employeeName;
    private $productServiceName;
    private $complaintTypeName;

    //constructor 
    public function __construct($customerId, $employeeId, $productServiceId, $complaintTypeId, $description, $status) {

        $this->complaintId = 0;
        $this->customerId = $customerId;
        $this->employeeId = $employeeId;
        $this->productServiceId = $productServiceId;
        $this->complaintTypeId = $complaintTypeId;
        $this->description = $description;
        $this->imagePath = "";
        $this->status = $status;

        // Technician fields start empty and are set later.
        $this->technicianNotes = "";
        $this->resolutionDate = "";
        $this->resolutionNotes = "";
        $this->createdAt = "";

        // Joined display fields start empty and are set on list queries.
        $this->customerName = "";
        $this->employeeName = "";
        $this->productServiceName = "";
        $this->complaintTypeName = "";
    }

    //getter/setter to get and set complaint id
    public function getComplaintId() { return $this->complaintId; }
    public function setComplaintId($value) { $this->complaintId = $value; }

    
    public function getCustomerId() { return $this->customerId; }
    public function setCustomerId($value) { $this->customerId = $value; }

    
    public function getEmployeeId() { return $this->employeeId; }
    public function setEmployeeId($value) { $this->employeeId = $value; }

    
    public function getProductServiceId() { return $this->productServiceId; }
    public function setProductServiceId($value) { $this->productServiceId = $value; }

    
    public function getComplaintTypeId() { return $this->complaintTypeId; }
    public function setComplaintTypeId($value) { $this->complaintTypeId = $value; }

    
    public function getDescription() { return $this->description; }
    public function setDescription($value) { $this->description = $value; }

    //optional image path saved with a complaint
    public function getImagePath() { return $this->imagePath; }
    public function setImagePath($value) { $this->imagePath = $value; }

    
    public function getStatus() { return $this->status; }
    public function setStatus($value) { $this->status = $value; }

    
    public function getTechnicianNotes() { return $this->technicianNotes; }
    public function setTechnicianNotes($value) { $this->technicianNotes = $value; }

    
    public function getResolutionDate() { return $this->resolutionDate; }
    public function setResolutionDate($value) { $this->resolutionDate = $value; }

    
    public function getResolutionNotes() { return $this->resolutionNotes; }
    public function setResolutionNotes($value) { $this->resolutionNotes = $value; }

    
    public function getCreatedAt() { return $this->createdAt; }
    public function setCreatedAt($value) { $this->createdAt = $value; }

    
    public function getCustomerName() { return $this->customerName; }
    public function setCustomerName($value) { $this->customerName = $value; }

    
    public function getEmployeeName() { return $this->employeeName; }
    public function setEmployeeName($value) { $this->employeeName = $value; }

    
    public function getProductServiceName() { return $this->productServiceName; }
    public function setProductServiceName($value) { $this->productServiceName = $value; }

    
    public function getComplaintTypeName() { return $this->complaintTypeName; }
    public function setComplaintTypeName($value) { $this->complaintTypeName = $value; }
}
?>