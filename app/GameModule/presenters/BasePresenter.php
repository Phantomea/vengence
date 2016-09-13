<?php

namespace GameModule;

use Nette;
use App\Model;
use Nette\Security\Identity;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

    public function startup() 
    {
        parent::startup();
        if(!$this->getUser()->isAllowed($this->getName(), $this->getAction())) {
            if (!$this->getUser()->isLoggedIn()) {
                $this->redirect(":Front:Sign:in");
            } else {
                $this->getUser()->logout();
                $this->flashMessage("Wrong username or password!", "danger");
                $this->redirect(":Front:Sign:in");
            }
        }
    }   
    
}
