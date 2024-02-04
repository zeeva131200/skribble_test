<?php

/**
 * SKRIBBLE LAB TECHNICAL ASSESSMENT
 * FEATURES SUPPORTED - Create Contract, Delete Contract, Create Load, Delete Load, Copy Load
 */

namespace App;

//store contract details
//manage loads
//update status

class Contract
{
    public $contractNumber;
    public $product;
    public $quantity;
    public $price;
    public $status;
    private $loads;

    public function __construct($contractNumber, $product, $quantity, $price)
    {
        $this->contractNumber = $contractNumber;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->status = 'NEW';
        $this->loads = [];
    }

    public function addLoad($load)
    {
        if (!$this->canAddLoad($load)) {
            throw new \Exception("Cannot add load. It exceeds the contract quantity or load ID already exists.");
        }
        $this->loads[] = $load;
        $this->updateStatus();
    }

    public function deleteLoad($loadId)
    {
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

    private function canAddLoad($load)
    {
        $totalQuantity = 0;
        foreach ($this->loads as $l) {
            $totalQuantity += $l->quantity;
            if ($l->loadId === $load->loadId) {
                return false; //load ID is not unique
            }
        }
        if ($totalQuantity + $load->quantity > $this->quantity) {
            return false; //adding new load will exceed contract qty
        }
        return true; //load can be added
    }

    private function updateStatus()
    {
        $totalQuantity = 0;
        foreach ($this->loads as $load) {
            $totalQuantity += $load->quantity;
        }
        $this->status = ($totalQuantity == $this->quantity) ? 'COMPLETED' : 'NEW';
    }

    public function getLoads()
    {
        return $this->loads;
    }

    public function getLoad($loadId)
    {
        foreach ($this->loads as $load) {
            if ($load->loadId == $loadId) {
                return $load;
            }
        }
        throw new \Exception("Load with ID $loadId not found.");
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
