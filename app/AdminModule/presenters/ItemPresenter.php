<?php

namespace AdminModule;

use Nette;
use App\Model\ItemManager;

use Nette\Application\UI;
use Nette\Application\UI\Form;
use Controls\Item;
use App\Forms\ItemFactory\ItemFactory;

final class ItemPresenter extends BasePresenter
{
    private $id;
    
    /** @var \App\Forms\ItemFactory\ItemFactory @inject */
    public $itemFactory;
    
    public function renderDefault($id = NULL)
    {
        $this->id = $id;
        
        $lastTen = $this->itemManager->getLastTen();
        $numberOfItems = $this->itemManager->getNumberOfItems();
        $numberOfHelmets = $this->itemManager->getNumberOfHelmets();
        $numberOfMasks = $this->itemManager->getNumberOfMasks();
        $numberOfCloaks = $this->itemManager->getNumberOfCloaks();
        $numberOfNecklaces = $this->itemManager->getNumberOfNecklaces();
        $numberOfArmors = $this->itemManager->getNumberOfArmors();
        $numberOfRings = $this->itemManager->getNumberOfRings();
        $numberOfGloves = $this->itemManager->getNumberOfGloves();
        $numberOfBelts = $this->itemManager->getNumberOfBelts();
        $numberOfTrousers = $this->itemManager->getNumberOfTrousers();
        $numberOfBoots = $this->itemManager->getNumberOfBoots();
        $numberOfFirstWeapons = $this->itemManager->getNumberOfFirstWeapons();
        $numberOfSecondWeapons = $this->itemManager->getNumberOfSecondWeapons();
        $numberOfPotions = $this->itemManager->getNumberOfPotions();
        
        $this->template->items = $numberOfItems;
        $this->template->helmets = $numberOfHelmets;
        $this->template->masks = $numberOfMasks;
        $this->template->cloaks = $numberOfCloaks;
        $this->template->necklaces = $numberOfNecklaces;
        $this->template->armors = $numberOfArmors;
        $this->template->rings = $numberOfRings;
        $this->template->gloves = $numberOfGloves;
        $this->template->belts = $numberOfBelts;
        $this->template->trousers = $numberOfTrousers;
        $this->template->boots = $numberOfBoots;
        $this->template->first_weapon = $numberOfFirstWeapons;
        $this->template->second_weapon = $numberOfSecondWeapons;
        $this->template->potions = $numberOfPotions;
        $this->template->lastTen = $lastTen;
    }
    
    public function renderDetail($id)
    {
        $item = $this->itemManager->getItem($id);
        $this->id = $item->item_id;
        $this->template->item = $item;
    }
    
    public function renderResult($value)
    {
        $result = $this->itemManager->searchItemByNameOrId($value);
        $this->template->result = $result;
        $this->template->value = $value;
    }
    
    protected function createComponentForm()
    {
        $control = $this->itemFactory->create($this->id);
        $control['form']->onSuccess[] = function () {
            $this->redirect('this');
        };
        return $control;
    }
    
    public function actionDeleteItem($id)
    {
        try {
            $this->itemManager->deleteItem($id);
            $this->flashMessage('Item has been deleted', 'success');
            $this->redirect('Item:default');
        } catch (Exception $ex) {
            $this->flashMessage($exc->getMessage(), 'danger');
        }
    }
    
}