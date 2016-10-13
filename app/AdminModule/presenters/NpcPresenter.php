<?php

namespace AdminModule;

use Nette;
use App\Model\NpcManager;
use App\Model\LocationNpcManager;

use Nette\Application\UI;
use Nette\Application\UI\Form;

use Controls\Npc;
use App\Forms\NpcFactory\NpcFactory;

class NpcPresenter extends BasePresenter
{
    private $id;
    private $value = '';
    
    /** @var \App\Forms\NpcFactory\NpcFactory @inject */
    public $npcFactory;
    
    public function renderDefault($id = NULL)
    {
        $this->id = $id;
        
        $numberOfNpcs = $this->npcManager->getNumberOfNpcs();
        for($i=1;$i<=100;$i=$i+4)
        {
            $numberOfNpcsByLevel[$i] = $this->npcManager->getNumberOfNpcByLevel($i);
        }
        $lastTen = $this->npcManager->getLastTen();
        
        $this->template->number = $numberOfNpcs;
        $this->template->numberByLevel = $numberOfNpcsByLevel;
        $this->template->lastTen = $lastTen;
    }
    
    public function renderDetail($id)
    {
        $this->id = $id;
        
        $npc = $this->npcManager->getNpc($id);
        
        $this->template->npc = $npc;
    }
    
    public function renderResult($value)
    {
        $this->value = $value;
        $result = $this->npcManager->getNpcByNameOrId($value);
        $this->template->result = $result;
        $this->template->value = $value;
    }
    
    public function actionDeleteNpc($id)
    {
        try {
            $locationNpc = $this->locationNpcManager->getLocationNpcByNpcId($id);
            $this->locationNpcManager->deleteLocationNpc($locationNpc->location_npc_id);
            $this->npcManager->deleteNpc($id);
            $this->flashMessage('Npc has been deleted', 'success');
            if($this->value <> '')
            {
                $this->redirect('Npc:result', $this->value);
            } else {
                $this->redirect('Npc:default');
            }
        } catch (Exception $ex) {
            $this->flashMessage($exc->getMessage(), 'danger');
        }
    }
    
    protected function createComponentForm()
    {
        $control = $this->npcFactory->create($this->id);
        $control['form']->onSuccess[] = function () {
            $this->redirect('Npc:default');
        };
        return $control;
    }
}