<?php

namespace AdminModule;

use Nette;
use App\Model\HelmetManager;

use App\Forms\WeaponFactory;

use Nette\Application\UI;
use Nette\Application\UI\Form;

final class HelmetPresenter extends BasePresenter
{
    
	public function renderDefault()
	{
            $helmets = $this->helmetManager->getNumberOfHelmets();
            $ghoulHelmets = $this->helmetManager->getNumberOfGhoulHelmets();
            $investigatorHelmets = $this->helmetManager->getNumberOfInvestigatorHelmets();
            
            $this->template->numberOfHelmets = $helmets;
            $this->template->numberOfGhoulHelmets = $ghoulHelmets;
            $this->template->numberOfInvestigatorHelmets = $investigatorHelmets;
	}
        
        /* Aciotns */
        
}
