<?php

namespace AdminModule;

use Nette;
use App\Model\SpellManager;

use App\Forms\SpellFactory\SpellFactory;

use Nette\Application\UI;
use Nette\Application\UI\Form;

class SpellPresenter  extends BasePresenter
{
    private $id;
    
    /** @var \App\Forms\SpellFactory\SpellFactory @inject */
    public $spellFactory;
    
    public function renderDefault($id = NULL)
    {
        $this->id = $id;
        
        $number = $this->spellManager->getNumberOfSpells();
        $lastTen = $this->spellManager->getLastTen();
        
        $this->template->number = $number;
        $this->template->lastTen = $lastTen;
    }
    
    public function renderDetail($id)
    {
        $this->id = $id;
        
        $spell = $this->spellManager->getSpell($id);
        
        $this->template->spell = $spell;
    }
    
    public function renderResult($value)
    {
        $result = $this->spellManager->getSpellByIdOrName($value);
        $this->template->result = $result;
        $this->template->value = $value;
    }
    
    public function actionDeleteSpell($id)
    {
        try {
            $this->spellManager->deleteSpell($id);
            $this->presenter->flashMessage('Spell has been deleted', 'success');
            $this->redirect('Spell:default');
        } catch (Exception $ex) {
            $this->flashMessage($exc->getMessage(), 'danger');
        }
    }
    
    protected function createComponentForm()
    {
        $control = $this->spellFactory->create($this->id);
        $control['form']->onSuccess[] = function () {
            $this->redirect('this');
        };
        return $control;
    }
}