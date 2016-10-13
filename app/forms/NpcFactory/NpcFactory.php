<?php

namespace App\Forms\NpcFactory;

use Nette;

class NpcFactory extends Nette\Object
{
    private $npcManager;
    private $locationManager;
    private $locationNpcManager;
    
    public function __construct(\App\Model\NpcManager $nm, \App\Model\LocationManager $lm,\App\Model\LocationNpcManager $lnm)
    {
        $this->npcManager = $nm;
        $this->locationManager = $lm;
        $this->locationNpcManager = $lnm;
    }
    
    public function create($id)
    {
        return new \Controls\Npc($this->npcManager, $this->locationManager, $this->locationNpcManager, $id);
    }
}