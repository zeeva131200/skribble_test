<?php

namespace App;

//store load details

class Load
{
    public $loadId;
    public $quantity;

    public function __construct($loadId, $quantity)
    {
        $this->loadId = $loadId;
        $this->quantity = $quantity;
    }

    public function getLoadId() {
        return $this->loadId;
    }

    public function getQuantity() {
        return $this->quantity;
    }
}