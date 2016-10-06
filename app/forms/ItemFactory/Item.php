<?php

namespace Controls;

use App;
use Entity;
use Nette\Application\UI;
use Nette;
use App\Model\ItemManager;

class Item extends UI\Control {

    private $itemManager;
    private $item;
    private $owners = [
        1 => 'Ghoul',
        2 => 'Investigator'
    ];
    
    private $types = [
        'helmet' => 'Helmet',
        'mask' => 'Mask',
        'cloak' => 'Cloak',
        'necklace' => 'Necklace',
        'armor' => 'Armor',
        'glove' => 'Glove',
        'ring' => 'Ring',
        'belt' => 'Belt',
        'trousers' => 'Trousers',
        'boot' => 'Boots',
        'first_weapon' => 'First weapon',
        'second_wepaon' => 'Second weapon',
        'potion' => 'Potion'
    ];

    public function __construct(ItemManager $im, $id) {
        parent::__construct();
        $this->itemManager = $im;
        $this->item = $this->itemManager->getItem($id);
    }

    public function render() {
        $this->template->setFile(__DIR__ . '\template\item.latte');
        $this->template->render();
    }

    protected function createComponentForm() {
        $form = new UI\Form;
        $form->addHidden('item_id');
        $form->addText('name', 'Name')
                ->setAttribute('placeholder', 'Item\'s name');
        $form->addText('strength', 'Strength')
                ->setType('number')
                ->setDefaultValue(0)
                ->setAttribute('placeholder', '0');
        $form->addText('agility', 'Agiltiy')
                ->setType('number')
                ->setDefaultValue(0)
                ->setAttribute('placeholder', '0');
        $form->addText('intelligence', 'Intelligence')
                ->setType('number')
                ->setDefaultValue(0)
                ->setAttribute('placeholder', '0');
        $form->addText('vitality', 'Vitality')
                ->setType('number')
                ->setDefaultValue(0)
                ->setAttribute('placeholder', '0');
        $form->addText('charisma', 'Charisma')
                ->setType('number')
                ->setDefaultValue(0)
                ->setAttribute('placeholder', '0');
        $form->addText('armor', 'Armor')
                ->setType('number')
                ->setDefaultValue(0)
                ->setAttribute('placeholder', '0');
        $form->addText('first_damage', 'First damage')
                ->setType('number')
                ->setDefaultValue(0)
                ->setAttribute('placeholder', '0');
        $form->addText('second_damage', 'Second damage')
                ->setType('number')
                ->setDefaultValue(0)
                ->setAttribute('placeholder', '0');
        $form->addText('health', 'Health')
                ->setType('number')
                ->setDefaultValue(0)
                ->setAttribute('placeholder', '0');
        $form->addText('level', 'Level')
                ->setType('number')
                ->setDefaultValue(1)
                ->setAttribute('placeholder', '0');
        $form->addUpload('avatar')
                ->addCondition($form::IMAGE)
                    ->addRule($form::MIME_TYPE, 'File has to be JPEG or PNG!', array('image/jpeg', 'image/png'))
                ->addRule($form::MAX_FILE_SIZE, 'Maximum size of image has to be 64 kB.', 64 * 1024);
        $form->addSelect('type', 'Type')
                ->setItems($this->types);
        $form->addSelect('owner', 'Owner')
                ->setItems($this->owners);
        $form->addSubmit('save', 'Save');
        if($this->item) { //výchozí hodnoty jen pokud aktualita již existuje
            $form->setDefaults(array(
                'item_id' => $this->item->item_id,
                'name' => $this->item->name,
                'strength' => $this->item->strength,
                'agility' => $this->item->agility,
                'intelligence' => $this->item->intelligence,
                'vitality' => $this->item->vitality,
                'charisma' => $this->item->charisma,
                'armor' => $this->item->armor,
                'first_damage' => $this->item->first_damage,
                'second_damage' => $this->item->second_damage,
                'health' => $this->item->health,
                'level' => $this->item->level,
                'avatar' => $this->item->avatar,
                'type' => $this->item->type,
                'owner' => $this->item->owner
            ));
        }
        $form->onSuccess[] = $this->itemFormSucceeded;
        return $form;
    }

    public function itemFormSucceeded(UI\Form $form) {
        $values = $form->getValues();
        try {            
            if($values->first_damage > $values->second_damage){
                $this->presenter->flashMessage('First damage can\'t be bigger than second damage', 'success');
            } else {
                if($values->item_id <> 0)
                {
                    if($values->avatar->error)
                    {
                        unset($values->avatar);
                    } else {
                        $values['avatar'] = $this->insertUploadedImage($values->avatar, 'items', $values->name);
                    }
                    $this->itemManager->updateItem($values);
                } else {
                    $this->itemManager->setItem($values);
                }
                $this->presenter->flashMessage('Item has been saved.', 'success');
            }
        } catch (Exception $ex) {
            $this->presenter->flashMessage($exc->getMessage(), 'danger');
        }
        
        //žádný redirect, až v presenteru!
    }

}