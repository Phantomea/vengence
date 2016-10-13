<?php

namespace Controls;

use App;
use Entity;
use Nette\Application\UI;
use Nette;
use App\Model\MenuManager;
use App\Model\MenuItemManager;
use App\Model\MenuMenuItemManager;

class Menu extends UI\Control
{
    private $menuManager;
    private $menuMenuItemManager;
    private $menuItemManager;
    private $menuItem;
    private $menus;
    
    public function __construct(MenuManager $mm, MenuMenuItemManager $mmim, MenuItemManager $mim, $id) {
        parent::__construct();
        $this->menuManager = $mm;
        $this->menuMenuItemManager = $mmim;
        $this->menuItemManager = $mim;
        $this->menuItem = $this->menuItemManager->getMenuItem($id);
    }
    
    public function render() {
        $this->template->setFile(__DIR__ . '\template\menu.latte');
        $this->template->render();
    }
    
    protected function createComponentForm() {
        $this->menus = $this->menuManager->getMenus();
        foreach($this->menus as $men)
        {
            $menuList[$men->menu_id] = $men->name;
        }
        $form = new UI\Form;
        $form->addSelect('menu_id')
                ->setItems($menuList);
        $form->addHidden('menu_item_id');
        $form->addText('name', 'Menu item name')
                ->setRequired()
                ->setAttribute('placeholder', 'Name menu item i.e. Weapon manager');
        $form->addText('link', 'Link')
                ->setRequired()
                ->setAttribute('placeholder', 'Choose link i.e Homepage:default');
        $form->addSubmit('save', 'Save');
        if($this->menuItem){
            $menu_id = $this->menuMenuItemManager->getMenuMenuItemByMenuItemId($this->menuItem->menu_item_id);
            \Tracy\Debugger::barDump($menu_id->menu_id);
            $form->setDefaults(array(
                'menu_id' => $menu_id->menu_id,
                'menu_item_id' => $this->menuItem->menu_item_id,
                'name' => $this->menuItem->name,
                'link' => $this->menuItem->link
            ));
        }
        $form->onSuccess[] = $this->formSucceeded;
        return $form;
    }
    
    public function formSucceeded(UI\Form $form) {
        $values = $form->getValues();
        try {
            if($values['menu_item_id'] == 0)
            {
                $this->menuItemManager->setMenuItem(array(
                    'name' => $values['name'],
                    'link' => $values['link']
                ));

                $lastMenuItem = $this->menuItemManager->getLastMenuItem();

                $this->menuMenuItemManager->setMenuMenuItem(array(
                    'menu_id' => $values['menu_id'],
                    'menu_item_id' => $lastMenuItem
                ));
            } else 
            {
                $menuMenuItem = $this->menuMenuItemManager->getMenuMenuItemsByMenuIdAndMenuItemId($values);
                $this->menuMenuItemManager->updateMenuMenuItem(array(
                    'menu_menu_item_id' => $menuMenuItem->menu_menu_item_id,
                    'menu_id' => $values['menu_id'],
                    'menu_item_id' => $values['menu_item_id']
                ));
                
                $this->menuItemManager->updateMenuItem(array(
                    'menu_item_id' => $values['menu_item_id'],
                    'name' => $values['name'],
                    'link' => $values['link']
                ));
            }
            $this->flashMessage('Menu item has been saved', 'success');
        } catch (Exception $ex) {
            $this->presenter->flashMessage($exc->getMessage(), 'danger');
        }
    }
}