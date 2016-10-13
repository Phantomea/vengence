<?php

namespace AdminModule;

use Nette;
use App\Model\MenuManager;
use App\Model\MenuItemManager;
use App\Model\MenuMenuItemManager;

use Nette\Application\UI;
use Nette\Application\UI\Form;

use Controls\Menu;
use App\Forms\MenuFactory\MenuFactory;

final class MenuPresenter extends BasePresenter
{
    private $id;
    
    /** @var \App\Forms\MenuFactory\MenuFactory @inject */
    public $menuFactory;
    
	public function renderDefault($id = NULL)
	{
            $this->id = $id;
            
            $menus = $this->menuManager->getMenus();
            foreach($menus as $am)
            {
                $menuItems[$am->menu_id] = $this->menuMenuItemManager->getMenuMenuItemByMenuId($am->menu_id);
            }
            
            $this->template->menus = $menus;
            if($menuItems)
            {
                $this->template->menuItems = $menuItems;
            }
	}
        
        public function renderDetail($id)
        {
            $menuItem = $this->menuItemManager->getMenuItem($id);
            $this->id = $menuItem->menu_item_id;
            $this->template->menu_item = $menuItem;
        }
        
        public function renderResult($value)
        {
            $result = $this->menuItemManager->searchMenuItemByNameOrId($value);
            $this->template->result = $result;
            $this->template->value = $value;
        }


        protected function createComponentForm() {
            $control = $this->menuFactory->create($this->id);
            $control['form']->onSuccess[] = function () {
                $this->redirect('this');
            };
            return $control;
        }
}
