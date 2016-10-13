<?php

namespace Controls;

use App;
use Entity;
use Nette\Application\UI;
use Nette;
use App\Model\LocationManager;

class Location extends UI\Control
{
    private $locationManager;
    private $location;
    
     public function __construct(LocationManager $lm, $id) {
        parent::__construct();
        $this->locationManager = $lm;
        $this->location = $this->locationManager->getLocation($id);
    }
    
    public function render() {
        $this->template->setFile(__DIR__ . '\template\location.latte');
        $this->template->render();
    }
    
    protected function createComponentForm() {
        $form = new UI\Form;
        $form->addHidden('location_id');
        $form->addText('name','Location name')
                ->setAttribute('placeholder', 'Location\'s name');
        $form->addText('minimum_level')
                ->setType('number')
                ->setDefaultValue(1)
                ->setAttribute('placeholder', 'Minimum level of player needed to enter this location');
        $form->addUpload('avatar')
                ->addCondition($form::IMAGE)
                ->addRule($form::MIME_TYPE, 'File has to be JPEG or PNG!', array('image/jpeg', 'image/png'))
                ->addRule($form::MAX_FILE_SIZE, 'Maximum size of image has to be 200 kB.', 200 * 1024);
        if($this->location)
        {
            $form->setDefaults(array(
                'location_id' => $this->location->location_id,
                'name' => $this->location->name,
                'minimum_level' => $this->location->minimum_level
            ));
        }
        $form->addSubmit('save', 'Save');
        $form->onSuccess[] = $this->formSucceeded;
        return $form;
    }
    
    public function formSucceeded(UI\Form $form)
    {
        $values = $form->getValues();
        try 
        {
            if($values->location_id <> 0)
            {
                if($values->avatar->error)
                {
                    unset($values->avatar);
                } else {
                    $values['avatar'] = $this->insertUploadedImage($values->avatar, 'locations', $values->name);
                }
                    $this->locationManager->updateLocation($values);
            } else {
                if($values->avatar->error)
                {
                    unset($values->avatar);
                } else {
                    $values['avatar'] = $this->insertUploadedImage($values->avatar, 'locations', $values->name);
                }
                $this->locationManager->setLocation($values);
            }
        } catch (Exception $ex) {
            $this->presenter->flashMessage($exc->getMessage(), 'danger');
        }
    }
}