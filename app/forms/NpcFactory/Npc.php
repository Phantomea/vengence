<?php

namespace Controls;

use App;
use Entity;
use Nette\Application\UI;
use Nette;
use App\Model\NpcManager;
use App\Model\LocationManager;
use App\Model\LocationNpcManager;

class Npc extends UI\Control
{
    private $npcManager;
    private $locationManager;
    private $locationNpcManager;
    private $npc;
    
     public function __construct(NpcManager $nm, LocationManager $lm, LocationNpcManager $lnm, $id) {
        parent::__construct();
        $this->npcManager = $nm;
        $this->locationManager = $lm;
        $this->locationNpcManager = $lnm;
        $this->npc = $this->npcManager->getNpc($id);
    }
    
    public function render() {
        $this->template->setFile(__DIR__ . '\template\npc.latte');
        $this->template->render();
    }
    
    protected function createComponentForm() {
        $form = new UI\Form;
        $form->addHidden('npc_id');
        $form->addText('name','NPC name')
                ->setRequired()
                ->setAttribute('placeholder', 'NPC\'s name');
        $form->addText('level')
                ->setType('number')
                ->setDefaultValue(1)
                ->setRequired()
                ->setAttribute('placeholder', 'NPC\'s level');
        $form->addSelect('type', 'Type')
                ->setItems($this->npcTypes);
        $form->addUpload('avatar')
                ->addCondition($form::IMAGE)
                ->addRule($form::MIME_TYPE, 'File has to be JPEG or PNG!', array('image/jpeg', 'image/png'))
                ->addRule($form::MAX_FILE_SIZE, 'Maximum size of image has to be 200 kB.', 200 * 1024);
        $form->addSubmit('save', 'Save');
        if($this->npc) { //výchozí hodnoty jen pokud aktualita již existuje
            $form->setDefaults(array(
                'npc_id' => $this->npc->npc_id,
                'name' => $this->npc->name,
                'level' => $this->npc->level,
                'avatar' => $this->npc->avatar,
                'type' => $this->npc->type
            ));
        }
        $form->onSuccess[] = $this->formSucceeded;
        return $form;
    }
    
    public function formSucceeded(UI\Form $form)
    {
        $values = $form->getValues();
        try 
        {
            if($values->npc_id <> 0)
            {
                if($values->avatar->error)
                {
                    unset($values->avatar);
                } else {
                    $values['avatar'] = $this->insertUploadedImage($values->avatar, 'npcs', $values->name);
                }
                
                for($i=0;$i<=100;$i=$i+5)
                {
                    if(($values['level'] >= ($i)) && ($values['level'] <= ($i+4)))
                    {
                        try {
                            if($i==0)
                            {
                                $j = $i+1;
                            } else {
                                $j = $i;
                            }
                            $this->npcManager->updateNpc($values);
                            $location = $this->locationManager->getLocationByLevel($i);
                            if($location)
                            {
                                $locationNpc = $this->locationNpcManager->getLocationNpcByNpcId($values['npc_id']);
                                $this->locationNpcManager->updateLocationNpc(array(
                                    'location_npc_id' => $locationNpc->location_npc_id,
                                    'location_id' => $location->location_id,
                                    'npc_id' => $values['npc_id']
                                ));
                                $this->presenter->flashMessage('Npc has been succesfully saved!');
                            } 
                        } catch (Exception $ex) {
                            $this->presenter->flashMessage('Something went wrong', 'danger');
                        }
                    }
                }                    
            } else {
                if($values->avatar->error)
                {
                    unset($values->avatar);
                } else {
                    $values['avatar'] = $this->insertUploadedImage($values->avatar, 'npcs', $values->name);
                }
                
                $values['strength'] = rand(round((3 * $values['level']),0), round((5 * $values['level']),0));
                $values['agility'] = rand(round((3 * $values['level']),0), round((5 * $values['level']),0));
                $values['intelligence'] = rand(round((3 * $values['level']),0), round((5 * $values['level']),0));
                $values['vitality'] = rand(round((3 * $values['level']),0), round((5 * $values['level']),0));
                $values['charisma'] = rand(round((3 * $values['level']),0), round((5 * $values['level']),0));
                $values['armor'] = rand(round((12.5 * $values['level']), 0), round((18 * $values['level']), 0));
                $values['health'] = rand(round((33.25 * $values['level']),0), round((50 * $values['level']),0));
                $values['first_damage'] = rand(round((1.5 * $values['level']),0), round((4 * $values['level']),0));
                $values['second_damage'] = rand(round((3 * $values['level']),0), round((5 * $values['level']),0));
                
                for($i=0;$i<=100;$i=$i+5)
                {
                    if(($values['level'] >= ($i)) && ($values['level'] <= ($i+4)))
                    {
                        try{
                            if($i==0)
                            {
                                $j = $i+1;
                            } else {
                                $j = $i;
                            }
                            $location = $this->locationManager->getLocationByLevel($j);
                            if($location)
                            {
                                $this->npcManager->setNpc($values);
                                $lastNpc = $this->npcManager->getLastNpc();
                                $this->locationNpcManager->setLocationNpc(array(
                                    'location_id' => $location->location_id,
                                    'npc_id' => $lastNpc->npc_id
                                ));
                                $this->presenter->flashMessage('Npc has been succesfully saved!');
                            } else {
                                $this->presenter->flashMessage('There is no location for NPC of this level, try to lower it\'s level!', 'danger');
                            }
                        } catch (Exception $ex) {
                            $this->presenter->flashMessage('Something went wrong', 'danger');
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $this->presenter->flashMessage('Something went wrong', 'danger');
        }
    }
}