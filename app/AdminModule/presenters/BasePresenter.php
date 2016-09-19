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
use App\Model\HelmetManager;
use App\Model\BankAccountManager;
use App\Model\CloakManager;
use App\Model\ClothManager;
use App\Model\GloveManager;
use App\Model\PantsManager;
use App\Model\MaskManager;
use App\Model\BootManager;
use App\Model\NecklaceManager;

use Nette\Utils\Image;

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
    
    /** @var HelmetManager @inject*/
    public $helmetManager;
    
    /** @var CloakManager @inject*/
    public $cloakManager;
    
    /** @var ClothManager @inject*/
    public $clothManager;
    
    /** @var MaskManager @inject*/
    public $maskManager;
    
    /** @var NecklaceManager @inject*/
    public $necklaceManager;
    
    /** @var GloveManager @inject*/
    public $gloveManager;
    
    /** @var PantsManager @inject*/
    public $pantsManager;
    
    /** @var BootManager @inject*/
    public $bootManager;
    
    

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
    
    public function getUserAmor($user_id)
    {
        $user = $this->userManager->getUser($user_id);
        
        $userHelmet = $this->helmetManager->getHelmet($user->armor->helmet_id);
        $userCloak = $this->cloakManager->getCloack($user->armor->cloak_id);
        $userCloth = $this->clothManager->getCloth($user->armor->cloth_id);
        $userGloves = $this->gloveManager->getGlove($user->armor->glove_id);
        $userNecklace = $this->necklaceManager->getNecklace($user->armor->necklace_id);
        $userPants = $this->pantsManager->getPants($user->armor->pants_id);
        $userBoots = $this->bootManager->getBoot($user->armor->boot_id);
        
        $userArmor[] = $userHelmet;
        $userArmor[] = $userCloak;
        $userArmor[] = $userCloth;
        $userArmor[] = $userGloves;
        $userArmor[] = $userNecklace;
        $userArmor[] = $userPants;
        $userArmor[] = $userBoots;
        
        return $userArmor;
    }
    
    public function insertUploadedImage($image, $folder, $name)
    {
        $filePath = 'images/';
        $fileName = '/'.$name.'.png';
        $path = $filePath . $folder . $fileName;
        $image->move($path);
        
        return $path;
    }
    
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
          ' '=>''
        );

        $text = strtr($word, $table);
        return $text;
    }
    
}
