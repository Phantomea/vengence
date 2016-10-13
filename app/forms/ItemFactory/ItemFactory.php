<?php

namespace App\Forms\ItemFactory;

use Nette;

class ItemFactory extends Nette\Object
{

    private $itemManager;

    public function __construct(\App\Model\ItemManager $im) {
        $this->itemManager = $im;
    }

    public function create($id) {
        return new \Controls\Item($this->itemManager, $id);
    }

}
