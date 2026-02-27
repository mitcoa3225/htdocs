<?php
// Complaint controller.
// Keeps complaint database work in one place.

require_once(__DIR__ . "/../model/complaintDB.php");

class ComplaintController {

    // Customer/admin list.
    public static function getAllComplaintsWithNames() {
        return ComplaintDB::getAllComplaintsWithNames();
    }

    // Customer list by customer.
    public static function getComplaintsByCustomerIdWithNames($customerIdNumber) {
        return ComplaintDB::getComplaintsByCustomerIdWithNames((int)$customerIdNumber);
    }

    // Tech list by technician.
    public static function getComplaintsByEmployeeIdWithNames($employeeIdNumber) {
        return ComplaintDB::getComplaintsByEmployeeIdWithNames((int)$employeeIdNumber);
    }

    // Admin open list.
    public static function getOpenComplaintsWithNames() {
        return ComplaintDB::getOpenComplaintsWithNames();
    }

    // Admin unassigned open list.
    public static function getUnassignedOpenComplaintsWithNames() {
        return ComplaintDB::getUnassignedOpenComplaintsWithNames();
    }

    // One complaint.
    public static function getComplaintById($complaintIdNumber) {
        return ComplaintDB::getComplaintById((int)$complaintIdNumber);
    }

    // Insert a complaint.
    public static function addComplaint($customerIdNumber, $productServiceIdNumber, $complaintTypeIdNumber, $descriptionText, $imagePathText) {
        return ComplaintDB::insertComplaint((int)$customerIdNumber, (int)$productServiceIdNumber, (int)$complaintTypeIdNumber, $descriptionText, $imagePathText);
    }

    // Assign technician.
    public static function assignComplaintToTechnician($complaintIdNumber, $employeeIdNumber) {
        return ComplaintDB::assignComplaintToTechnician((int)$complaintIdNumber, (int)$employeeIdNumber);
    }

    // Update technician fields.
    public static function updateComplaintTechnicianFields($complaintIdNumber, $technicianNotesText, $statusText, $resolutionDateText, $resolutionNotesText) {
        return ComplaintDB::updateComplaintTechnicianFields((int)$complaintIdNumber, $technicianNotesText, $statusText, $resolutionDateText, $resolutionNotesText);
    }

    // Counts for technicians (admin report).
    public static function getTechnicianOpenComplaintCounts() {
        return ComplaintDB::getTechnicianOpenComplaintCounts();
    }

    // Delete one complaint.
    public static function deleteComplaint($complaintIdNumber) {
        return ComplaintDB::deleteComplaint((int)$complaintIdNumber);
    }
}
