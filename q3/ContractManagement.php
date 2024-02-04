<?php

/**
 * SKRIBBLE LAB TECHNICAL ASSESSMENT
 * FEATURES SUPPORTED - Create Contract, Delete Contract, Create Load, Delete Load, Copy Load
 */

namespace App;

class ContractManagement
{
    private $contracts = [];

    //create contract
    public function createContract($contractNumber, $product, $quantity, $price)
    {
        if (isset($this->contracts[$contractNumber])) {
            throw new \Exception("Contract already exists.");
        }
        $this->contracts[$contractNumber] = new Contract($contractNumber, $product, $quantity, $price);
    }

    //delete contract
    public function deleteContract($contractNumber)
    {
        if (!isset($this->contracts[$contractNumber])) {
            throw new \Exception("Contract not found.");
        }
        if (!empty($this->contracts[$contractNumber]->getLoads())) {
            throw new \Exception("Cannot delete contract with loads.");
        }
        unset($this->contracts[$contractNumber]);
    }

    //create load
    public function createLoad($contractNumber, $loadId, $quantity)
    {
        if (!isset($this->contracts[$contractNumber])) {
            throw new \Exception("Contract not found.");
        }
        $this->contracts[$contractNumber]->addLoad(new Load($loadId, $quantity));
    }

    //delete load
    public function deleteLoad($contractNumber, $loadId)
    {
        if (!isset($this->contracts[$contractNumber])) {
            throw new \Exception("Contract not found.");
        }
        $this->contracts[$contractNumber]->deleteLoad($loadId);
    }

    //copy load
    public function copyLoad($oriContractNumber, $targetContractNumber, $loadId)
    {
        if (!isset($this->contracts[$oriContractNumber])) {
            throw new \Exception("Original Contract not found.");
        }
        if (!isset($this->contracts[$targetContractNumber])) {
            throw new \Exception("Target Contract not found.");
        }

        $oriContract = $this->contracts[$oriContractNumber];
        $loads = $oriContract->getLoads();
        $foundLoad = null;

        foreach ($loads as $load) {
            if ($load->getLoadId() == $loadId) {
                $foundLoad = $load;
                break;
            }
        }

        if ($foundLoad === null) {
            throw new \Exception("Load with ID $loadId not found in source contract.");
        }
        $this->contracts[$targetContractNumber]->addLoad(new Load($load->getLoadId(), $load->getQuantity()));
    }

    public function getContracts()
    {
        return $this->contracts;
    }

    public function getContract($contractNumber)
    {
        return isset($this->contracts[$contractNumber]) ? $this->contracts[$contractNumber] : null;
    }
}
