<?php
// Lists controller.
// Returns dropdown lists for forms.

require_once(__DIR__ . "/../model/listDB.php");

class ListsController {

    public static function getAllProductsServices() {
        return ListDB::getAllProductsServices();
    }

    public static function getAllComplaintTypes() {
        return ListDB::getAllComplaintTypes();
    }

    public static function getAllTechnicians() {
        return ListDB::getAllTechnicians();
    }
}
