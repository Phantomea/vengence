<?php

namespace AdminModule;

use Nette;
use App\Model;
use App\Model\UserManager;
use App\Model\MenuManager;
use App\Model\MenuItemManager;
use App\Model\MenuMenuItemManager;
use App\Model\UserStateManager;
use App\Model\ArmorManager;
use App\Model\WeaponManager;
use App\Model\BankAccountManager;

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
    
    /** @var UserStateManager @inject*/
    public $userStateManager;
    
    /** @var ArmorManager @inject*/
    public $armorManager;
    
    /** @var WeaponManager @inject*/
    public $weaponManager;
    
    /** @var BankAccountManager @inject*/
    public $bankAccountManager;

    public function startup() 
    {
        parent::startup();
        if(!$this->getUser()->isAllowed($this->getName(), $this->getAction())) {
            if (!$this->getUser()->isLoggedIn()) {
                $this->getUser()->logout(TRUE);
                $this->flashMessage("Wrong username or password!", "danger");
                $this->redirect("Sign:in");
            }else{
                $this->getUser()->logout(TRUE);
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
        if($user)
        {
            return $this->menuManager->getMenu($user->menu);
        } else {
            return false;
        }
    }
    
    public function validateUser($data)
    {
        $emailExists = $this->userManager->getUserByEmail($data["email"]);
        $nameExists = $this->userManager->getUserByName($data["username"]);
        
        if($emailExists)
        {
            return true;
        } elseif($nameExists)
        {
            return true;
        } else 
        {
            return false;
        }
        
    }
}
