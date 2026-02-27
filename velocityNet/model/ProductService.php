<?php
// ProductService class.
// Stores values for this object.


class ProductService {

    private $productServiceId;
    private $productServiceName;

    //constructor 
    public function __construct($name) {
        $this->productServiceId = 0;
        $this->productServiceName = $name;
    }

    //getter/setter to get and set product service id
    public function getProductServiceId() { return $this->productServiceId; }
    public function setProductServiceId($value) { $this->productServiceId = $value; }

    //getter/setter to get and set product service name
    public function getProductServiceName() { return $this->productServiceName; }
    public function setProductServiceName($value) { $this->productServiceName = $value; }
}
?>