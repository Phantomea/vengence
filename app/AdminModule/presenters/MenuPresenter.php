<?php

namespace AdminModule;

use Nette;
use App\Model\MenuManager;
use App\Model\MenuItemManager;
use App\Model\MenuMenuItemManager;

use Nette\Application\UI;
use Nette\Application\UI\Form;

final class MenuPresenter extends BasePresenter
{
	public function renderDefault()
	{
            $menus = $this->menuManager->getMenus();
            foreach($menus as $am)
            {
                $menuItems[$am->menu_id] = $this->menuMenuItemManager->getMenuMenuItemsByMenuId($am->menu_id);
            }
            
            $this->template->menus = $menus;
            if($menuItems)
            {
                $this->template->menuItems = $menuItems;
            }
                
                
                
	}
        
        protected function createComponentCreateMenuItemsForm()
        {
            $allMenus = $this->menuManager->getMenus();
            foreach ($allMenus as $am)
            {
                $menus[$am->menu_id] = $am->name;
            }
            
            $form = new Form();
            $form->addSelect("menu_id")
                    ->setItems($menus);
            $form->addText("name", "Menu item name")
                    ->setRequired("Name menu item!")
                    ->setAttribute("placeholder", "Name menu item i.e. Admin menu");
            $form->addText("link", "Menu item link")
                    ->setRequired("Type link here!")
                    ->setAttribute("placeholder", "Homepage:default");
            $form->addSubmit("add", "Add");
            $form->onSuccess[] = array($this, "addMenuItem");
            return $form;
        }
        
        public function addMenuItem($form, $values)
        {
            if($form["add"]->isSubmittedBy())
            {
                if($form->isValid())
                {
                    $createMenuItem = $this->menuItemManager->setMenuItem(array(
                        "name" => $values["name"],
                        "link" => $values["link"]
                    ));
                    $lastMenuItem = $this->menuItemManager->getLastMenuItem();
                    
                    $createMenuMenuItem = $this->menuMenuItemManager->setMenuMenuItem(array(
                        "menu_id" => $values["menu_id"],
                        "menu_item_id" => $lastMenuItem
                    ));
                    
                    $this->flashMessage("Menu item has been added");
                    $this->redirect("this");
                }
            }
        }
}
