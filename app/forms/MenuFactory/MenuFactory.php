<?php

namespace App\Forms\MenuFactory;

use Nette;

class MenuFactory extends Nette\Object {

    private $menuManager;
    private $menuItemManager;
    private $menuMenuItemManager;

    public function __construct(\App\Model\MenuManager $mm, \App\Model\MenuMenuItemManager $mmim, \App\Model\MenuItemManager $mim)
    {
        $this->menuManager = $mm;
        $this->menuItemManager = $mim;
        $this->menuMenuItemManager = $mmim;
    }

    public function create($id)
    {
        return new \Controls\Menu($this->menuManager, $this->menuMenuItemManager, $this->menuItemManager, $id);
    }

}
