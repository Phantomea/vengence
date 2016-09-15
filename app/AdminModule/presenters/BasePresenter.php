<?php

namespace AdminModule;

use Nette;
use App\Model;
use App\Model\UserManager;
use App\Model\MenuManager;
use App\Model\MenuItemManager;
use App\Model\MenuMenuItemManager;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

    /** @var UserManager @inject*/
    public $userManager;

    /** @var MenuManager @inject*/
    public $menuManager;

    /** @var MenuItemManager @inject*/
    public $menuItemManager;

    /** @var MenuMenuItemManager @inject*/
    public $menuMenuItemManager;

    public function startup() 
    {
        parent::startup();
        if(!$this->getUser()->isAllowed($this->getName(), $this->getAction())) {
            if (!$this->getUser()->isLoggedIn()) {
                $this->redirect("Sign:in");
            } else {
                $this->getUser()->logout();
                $this->flashMessage("Wrong username or password!", "danger");
                $this->redirect("Sign:in");
            }
        }

        $this->template->player = $this->getPlayer();
        $this->template->menu = $this->getUserMenu();
    }

    public function getPlayer()
    {
        return $this->userManager->getUser($this->user->getId());
    }

    public function getUserMenu()
    {
        $user = $this->userManager->getUser($this->user->getId());
        return $this->menuManager->getMenu($user->menu);
    }
}
