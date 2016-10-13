<?php

namespace App\Forms\LocationFactory;

use Nette;

class LocationFactory extends Nette\Object
{
    private $locationManager;
    
    public function __construct(\App\Model\LocationManager $lm)
    {
        $this->locationManager = $lm;
    }
    
    public function create($id)
    {
        return new \Controls\Location($this->locationManager, $id);
    }
}