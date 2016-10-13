<?php

namespace AdminModule;

use Nette;
use App\Model;
use App\Model\UserManager;
use App\Model\MenuManager;
use App\Model\MenuItemManager;
use App\Model\MenuMenuItemManager;
use App\Model\UserStateManager;
use App\Model\EquipmentManager;
use App\Model\BankAccountManager;
use App\Model\ItemManager;
use App\Model\LocationManager;

use Nette\Utils\Image;

use App\Forms\SearchFactory\SearchFactory;

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
    
    /** @var EquipmentManager @inject*/
    public $equipmentManager;
    
    /** @var BankAccountManager @inject*/
    public $bankAccountManager;
    
    /** @var ItemManager @inject*/
    public $itemManager;
    
    /** @var LocationManager @inject*/
    public $locationManager;
    
    
    
    

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
    
    public function insertUploadedImage($image, $folder, $name)
    {
        $filePath = '/images/';
        $name = $this->deleteUtfCharacters($name);
        $fileName = '/'.$name.'.png';
        $path = $filePath . $folder . $fileName;
        $image->move($path);
        
        return $path;
    }
    
    /***************** Form controls  *****************************/
    
    
    public function deleteUtfCharacters($word)
    {
        // i pro multi-byte (napr. UTF-8)
        $table = Array(
          'ä'=>'a',
          'Ä'=>'A',
          'á'=>'a',
          'Á'=>'A',
          'à'=>'a',
          'À'=>'A',
          'ã'=>'a',
          'Ã'=>'A',
          'â'=>'a',
          'Â'=>'A',
          'č'=>'c',
          'Č'=>'C',
          'ć'=>'c',
          'Ć'=>'C',
          'ď'=>'d',
          'Ď'=>'D',
          'ě'=>'e',
          'Ě'=>'E',
          'é'=>'e',
          'É'=>'E',
          'ë'=>'e',
          'Ë'=>'E',
          'è'=>'e',
          'È'=>'E',
          'ê'=>'e',
          'Ê'=>'E',
          'í'=>'i',
          'Í'=>'I',
          'ï'=>'i',
          'Ï'=>'I',
          'ì'=>'i',
          'Ì'=>'I',
          'î'=>'i',
          'Î'=>'I',
          'ľ'=>'l',
          'Ľ'=>'L',
          'ĺ'=>'l',
          'Ĺ'=>'L',
          'ń'=>'n',
          'Ń'=>'N',
          'ň'=>'n',
          'Ň'=>'N',
          'ñ'=>'n',
          'Ñ'=>'N',
          'ó'=>'o',
          'Ó'=>'O',
          'ö'=>'o',
          'Ö'=>'O',
          'ô'=>'o',
          'Ô'=>'O',
          'ò'=>'o',
          'Ò'=>'O',
          'õ'=>'o',
          'Õ'=>'O',
          'ő'=>'o',
          'Ő'=>'O',
          'ř'=>'r',
          'Ř'=>'R',
          'ŕ'=>'r',
          'Ŕ'=>'R',
          'š'=>'s',
          'Š'=>'S',
          'ś'=>'s',
          'Ś'=>'S',
          'ť'=>'t',
          'Ť'=>'T',
          'ú'=>'u',
          'Ú'=>'U',
          'ů'=>'u',
          'Ů'=>'U',
          'ü'=>'u',
          'Ü'=>'U',
          'ù'=>'u',
          'Ù'=>'U',
          'ũ'=>'u',
          'Ũ'=>'U',
          'û'=>'u',
          'Û'=>'U',
          'ý'=>'y',
          'Ý'=>'Y',
          'ž'=>'z',
          'Ž'=>'Z',
          'ź'=>'z',
          'Ź'=>'Z',
          '\''=>'',
          ' '=>'_'
        );

        $text = strtr($word, $table);
        return $text;
    }
    
}
