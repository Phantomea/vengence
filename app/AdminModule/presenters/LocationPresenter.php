<?php

namespace AdminModule;

use Nette;
use App\Model\LocationManager;

use App\Forms\LocationFactory\LocationFactory;

use Controls\Location;

use Nette\Application\UI;
use Nette\Application\UI\Form;

class LocationPresenter extends BasePresenter
{
    private $id;
    
    /** @var \App\Forms\LocationFactory\LocationFactory @inject */
    public $locationFactory;
    
    public function renderDefault($id = NULL)
    {
        $this->id = $id;
        
        $locations = $this->locationManager->getLocations();
        $numberOfLocations = $this->locationManager->numberOfLocations();
        $lastTwenty = $this->locationManager->getLastTwenty();
        
        $this->template->locations = $locations;
        $this->template->number = $numberOfLocations;
        $this->template->lastTwenty = $lastTwenty;
    }
    
    public function renderDetail($id)
    {
        $location = $this->locationManager->getLocation($id);
        $this->id = $location->location_id;
        
        $this->template->location = $location;
    }
    
    public function renderResult($value)
    {
        $result = $this->locationManager->searchLocationByNameOrId($value);
        $this->template->result = $result;
        $this->template->value = $value;
    }
    
    protected function createComponentForm() {
        $control = $this->locationFactory->create($this->id);
        $control['form']->onSuccess[] = function () {
            $this->redirect('this');
        };
        return $control;
    }
    
    public function actionDeleteLocation($id)
    {
        $this->locationManager->deleteLocation($id);
        $this->flashMessage('Location has been deleted', 'success');
        $this->redirect('Location:default');
    }
}