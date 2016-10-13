<?php

namespace Controls;

use App;
use Entity;
use Nette\Application\UI;
use Nette;
use App\Model\SpellManager;

class Spell extends UI\Control
{
    private $spellManager;
    private $spell;
    
     public function __construct(SpellManager $sm, $id) {
        parent::__construct();
        $this->spellManager = $sm;
        $this->spell = $this->spellManager->getSpell($id);
    }
    
    public function render() {
        $this->template->setFile(__DIR__ . '\template\spell.latte');
        $this->template->render();
    }
    
    protected function createComponentForm() {
        $form = new UI\Form;
        $form->addHidden('spell_id');
        $form->addText('name','NPC name')
                ->setRequired()
                ->setAttribute('placeholder', 'Spell\'s name');
        $form->addText('level')
                ->setType('number')
                ->setDefaultValue(1)
                ->setRequired()
                ->setAttribute('placeholder', 'Spell\'s level');
        $form->addText('price', 'Price')
                ->setType('number')
                ->setDefaultValue(1)
                ->setRequired()
                ->setAttribute('placeholder', 'Spell\'s price');
        $form->addText('damage', 'Damage')
                ->setType('number')
                ->setDefaultValue(1)
                ->setRequired()
                ->setAttribute('placeholder', 'Spell\'s damage');
        $form->addTextArea('info', 'Info')
                ->setRequired()
                ->setAttribute('placeholder', 'Spell\'s information');
        $form->addText('mana', 'Mana')
                ->setType('number')
                ->setDefaultValue(1)
                ->setRequired()
                ->setAttribute('placeholder', 'Spell\'s mana cost');
        $form->addSelect('type', 'Type')
                ->setItems($this->owners);
        $form->addUpload('avatar')
                ->addCondition($form::IMAGE)
                ->addRule($form::MIME_TYPE, 'File has to be JPEG or PNG!', array('image/jpeg', 'image/png'))
                ->addRule($form::MAX_FILE_SIZE, 'Maximum size of image has to be 200 kB.', 200 * 1024);
        $form->addSubmit('save', 'Save');
        if($this->spell) { //výchozí hodnoty jen pokud aktualita již existuje
            $form->setDefaults(array(
                'spell_id' => $this->spell->spell_id,
                'name' => $this->spell->name,
                'info' => $this->spell->info,
                'damage' => $this->spell->damage,
                'mana' => $this->spell->mana,
                'level' => $this->spell->level,
                'type' => $this->spell->type,
                'avatar' => $this->spell->avatar,
                'price' => $this->spell->price
            ));
        }
        $form->onSuccess[] = $this->formSucceeded;
        return $form;
    }
    
    public function formSucceeded(UI\Form $form)
    {
        $values = $form->getValues();
        try {
            if($values->avatar->error)
            {
                unset($values->avatar);
            } else {
                $values['avatar'] = $this->insertUploadedImage($values->avatar, 'spells', $values['name']);
            }
                
            if($values->spell_id <> 0)
            {
                $this->spellManager->updateSpell($values);
                $this->presenter->flashMessage('Spell has been saved.', 'success');
            } else {
                $this->spellManager->setSpell($values);
                $this->presenter->flashMessage('Spell has been saved.', 'success');
            }
        } catch (Exception $ex) {
            $this->presenter->flashMessage('Something went wrong.', 'danger');
        }
    }
}