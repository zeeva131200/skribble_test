<?php

/**
 * SKRIBBLE LAB TECHNICAL ASSESSMENT
 * FEATURES SUPPORTED - Create Contract, Delete Contract, Create Load, Delete Load, Copy Load
 */

namespace App;

class Contract {
    public $contractNumber;
    public $product;
    public $quantity;
    public $price;
    public $status;
    private $loads;
    
    public function __construct($contractNumber, $product, $quantity, $price) {
        $this->contractNumber = $contractNumber;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->status = 'NEW';
        $this->loads = [];
    }
    
    public function addLoad($load){
        if(!$this->canAddLoad($load)){
             throw new \Exception("Cannot add load. It exceeds the contract quantity or load ID already exists.");
        }
        $this->loads[] = $load;
        $this->updateStatus();
    }
    
    public function deleteLoad($loadId) {
        foreach ($this->loads as $index => $load) {
            if ($load->loadId == $loadId) {
                unset($this->loads[$index]);
                $this->loads = array_values($this->loads); // Reindex array
                $this->updateStatus();
                return;
            }
        }
        throw new \Exception("Load with ID $loadId not found.");
    }
    
    private function canAddLoad($load) {
        $totalQuantity = array_sum(array_map(function($l) { return $l->quantity; }, $this->loads));
        if ($totalQuantity + $load->quantity > $this->quantity) {
            return false;
        }
        foreach ($this->loads as $l) {
            if ($l->loadId === $load->loadId) {
                return false;
            }
        }
        return true;
    }
    
    private function updateStatus() {
        $totalQuantity = array_sum(array_map(function($l) { return $l->quantity; }, $this->loads));
        $this->status = $totalQuantity == $this->quantity ? 'COMPLETED' : 'NEW';
    }

    public function copyLoadToAnotherContract($loadId, $targetContract) {
        foreach ($this->loads as $load) {
            if ($load->loadId == $loadId) {
                $targetContract->addLoad(new Load($load->loadId, $load->quantity));
                return;
            }
        }
        throw new \Exception("Load with ID $loadId not found.");
    }
    
    public function getLoads() {
    return $this->loads;
}
}
class Load {
    public $loadId;
    public $quantity;

    public function __construct($loadId, $quantity) {
        $this->loadId = $loadId;
        $this->quantity = $quantity;
    }
}


class ContractManagement {
    private $contracts = [];

    public function createContract($contractNumber, $product, $quantity, $price) {
        if (isset($this->contracts[$contractNumber])) {
            throw new \Exception("Contract already exists.");
        }
        $this->contracts[$contractNumber] = new Contract($contractNumber, $product, $quantity, $price);
    }

    public function deleteContract($contractNumber) {
        if (!isset($this->contracts[$contractNumber])) {
            throw new \Exception("Contract not found.");
        }
        if (!empty($this->contracts[$contractNumber]->getLoads())) {
            throw new \Exception("Cannot delete contract with loads.");
        }
        unset($this->contracts[$contractNumber]);
    }

    public function createLoad($contractNumber, $loadId, $quantity) {
        if (!isset($this->contracts[$contractNumber])) {
            throw new \Exception("Contract not found.");
        }
        $this->contracts[$contractNumber]->addLoad(new Load($loadId, $quantity));
    }

    // Methods for deleting loads, copying loads, etc.
    
    public function getContracts() {
    return $this->contracts;
}

    public function getContract($contractNumber) {
        return isset($this->contracts[$contractNumber]) ? $this->contracts[$contractNumber] : null;
}
}


// $cm = new ContractManagement();

// // Create a contract with contract_number 123abc
// $cm->createContract('123abc', 'CPO', 100, 1200);

// // Create a contract with contract_number 456def
// $cm->createContract('456def', 'CPK', 80, 1400);

// // Print list of loads from contract 123abc, which should be an empty list initially
// // Note: To access private properties for printing, you might need to add a getter method in your Contract class
// // For this example, let's assume we have a public method in ContractManagement to get contract details
// echo "Initial loads for 123abc:<br>";
// print_r($cm->getContract('123abc')->getLoads());

// // Create a load under contract 123abc
// $cm->createLoad('123abc', 'A1', 10);

// // Create another load under contract 123abc
// $cm->createLoad('123abc', 'A2', 10);

// // Print out all the contract details after adding loads
// echo "<br>Contracts after adding loads to 123abc:<br>";
// print_r($cm->getContracts());

// // Delete contract 456def
// $cm->deleteContract('456def');

// // Print out all the contract details after deletion
// echo "<br>Contracts after deleting 456def:<br>";
// print_r($cm->getContracts());
?>