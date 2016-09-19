<?php

namespace AdminModule;

use Nette;
use App\Model\UserManager;
use App\Model\UserStateManager;
use App\Model\ArmorManager;
use App\Model\WeaponManager;
use App\Model\BankAccountManager;
use App\Model\HelmetManager;

use App\Forms\RegisterUserFactory;
use App\Forms\EditUserFactory;
use App\Forms\SearchUserFactory;
use App\Forms\EditUserBankAccountFactory;

use Nette\Application\UI;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;

final class UserPresenter extends BasePresenter
{
    
	public function renderDefault()
	{
            $numberOfUsers = $this->userManager->numberOfUsers();
            $numberOfAdministrators = $this->userManager->numberOfAdministrators();
            $numberOfPlayers = $this->userManager->numberOfPlayers();
            $numberOfModerators = $this->userManager->numberOfModerators();
            $numberOfBannedUsers = $this->userManager->numberOfBannedUsers();
            
            $this->template->numberOfUsers = $numberOfUsers;
            $this->template->numberOfAdministrators = $numberOfAdministrators;
            $this->template->numberOfModerators = $numberOfModerators;
            $this->template->numberOfPlayers = $numberOfPlayers;
            $this->template->numberOfBannedUsers = $numberOfBannedUsers;
            
            // \Tracy\Debugger::barDump($users);
	}
        
        public function renderResult($value)
        {
            $result = $this->userManager->searchUserByNameOrId($value);
            $this->template->result = $result;
            $this->template->value = $value;
            $this["searchUserForm"]->setDefaults(array(
                "word" => $value
            ));
        }
        
        public function renderDetail($user_id)
        {
            $user = $this->userManager->getUser($user_id);
            $userBankAccount = $this->bankAccountManager->getBankAccount($user->bank_account);
            
            $userHelmet = $this->helmetManager->getHelmet($user->armor->helmet_id);
            $userCloak = $this->cloakManager->getCloack($user->armor->cloak_id);
            $userCloth = $this->clothManager->getCloth($user->armor->cloth_id);
            $userGloves = $this->gloveManager->getGlove($user->armor->glove_id);
            $userNecklace = $this->necklaceManager->getNecklace($user->armor->necklace_id);
            $userPants = $this->pantsManager->getPants($user->armor->pants_id);
            $userBoots = $this->bootManager->getBoot($user->armor->boot_id);
            
            $user = $user->toArray();
            $userBankAccount = $userBankAccount->toArray();
            
            $this["editUserForm"]->setDefaults($user);
            $this["editUserBankAccountForm"]->setDefaults($userBankAccount);
            
            $this->template->helmet = $userHelmet;
            $this->template->cloak = $userCloak;
            $this->template->cloth = $userCloth;
            $this->template->gloves = $userGloves;
            $this->template->necklace = $userNecklace;
            $this->template->pants = $userPants;
            $this->template->boots = $userBoots;
        }
        
        /* Aciotns */
        
        public function handleBanUser($user_id)
        {
            $banUser = $this->userManager->updateUser(array(
                "user_id" => $user_id,
                "role" => "banned"
            ));
        }
        
        protected function createComponentRegisterUserForm()
        {
            $form = new Form();
            $form = (new RegisterUserFactory())->create();
            $form->onSuccess[] = [$this, 'addUser'];
            return $form;
        }
        
        protected function createComponentEditUserForm()
        {
            $form = new Form();
            $form = (new EditUserFactory())->create();
            $form->onSuccess[] = [$this, 'editUser'];
            return $form;
        }
        
        protected function createComponentSearchUserForm()
        {
            $form = new Form();
            $form = (new SearchUserFactory())->create();
            $form->onSuccess[] = [$this, 'searchUser'];
            return $form;
        }
        
        protected function createComponentEditUserBankAccountForm()
        {
            $form = new Form();
            $form = (new \App\Forms\EditUserBankAccountFactory())->create();
            $form->onSuccess[] = [$this, 'editUserBankAccount'];
            return $form;
        }
        
        
        public function searchUser($form, $values)
        {
            if($form["search"]->isSubmittedBy())
            {
                if($form->isValid())
                {
                    $this->redirect("Result", $values["word"]);
                }
            }
        }
        
        public function addUser($form, $values)
        {
            if($form["register"]->isSubmittedBy())
            {
                if($form->isValid())
                {
                    if(!$this->validateUser($values))
                    {
                        $values['password'] = Passwords::hash($values['password']);
                        
                        $empty = [];
                        
                        if($values["role"])
                        {
                            switch ($values["role"])
                            {
                                case "player": 
                                    $values["menu_id"] = 2;
                                    break;
                                
                                case "moderator":
                                    $values["menu_id"] = 3;
                                    break;
                                    
                                case "banned":
                                    $values["menu_id"] = 2;
                                    break;
                                
                                case "admin":
                                    $values["menu_id"] = 1;
                                    break;
                                
                                default:
                                    $values["menu_id"] = 2;
                                    break;
                            }
                        } else 
                        {
                            $values["menu_id"] = 2;
                        }
                        
                        if(isset($values['avatar']))
                        {
                            $values['avatar'] = $this->insertUploadedImage($values['avatar'], 'users', $values['username']);
                        }
                        
                        
                        $createUserState = $this->userStateManager->setUserState($empty);
                        $lastUserState = $this->userStateManager->getLastUserState();
                        $values["user_state_id"] = $lastUserState->user_state_id;
                        
                        $createArmor = $this->armorManager->setArmor($empty);
                        $lastArmor = $this->armorManager->getLastArmor();
                        $values["armor_id"] = $lastArmor->armor_id;
                        
                        $createWeapon = $this->weaponManager->setWeapon($empty);
                        $lastWeapon = $this->weaponManager->getLastWeapon();
                        $values["weapon_id"] = $lastWeapon->weapon_id;
                        
                        $createBankAccount = $this->bankAccountManager->setBankAccount($empty);
                        $lastBankAccount = $this->bankAccountManager->getLastBankAccount();
                        $values["bank_account_id"] = $lastBankAccount->bank_account_id;
                        
                        $createUser = $this->userManager->setUser($values);
                        
                        $this->flashMessage("User has been created!");
                        $this->redirect("this");
                    } else {
                        $this->flashMessage("Username or email are already taken!");
                    }
                }
            }
        }
        
        public function editUser($form, $values)
        {
            if($form["edit"]->isSubmittedBy())
            {
                if($values["password"] == "")
                {
                    unset($values["password"]);
                } else {
                    $values["password"] = Passwords::hash($values["password"]);
                }

                if($values["avatar"] == "")
                {
                    unset($values["avatar"]);
                }

                $empty = [];
                if($values["role"])
                {
                    switch ($values["role"])
                    {
                        case "player": 
                            $values["menu_id"] = 2;
                            break;

                        case "moderator":
                            $values["menu_id"] = 3;
                            break;

                        case "banned":
                            $values["menu_id"] = 2;
                            break;

                        case "admin":
                            $values["menu_id"] = 1;
                            break;

                        default:
                            $values["menu_id"] = 2;
                            break;
                    }
                } else 
                {
                    $values["menu_id"] = 2;
                }
                
                if(isset($values['avatar']))
                {
                    $values['avatar'] = $this->insertUploadedImage($values['avatar'], 'users', $values['username']);
                }
                        
                        
                $editUser = $this->userManager->updateUser($values);
                $this->flashMessage("User has been updated!");
                $this->redirect("User:detail", $values["user_id"]);
            } 
        }
        
        public function editUserBankAccount($form, $values)
        {
            if($form['edit']->isSubmittedBy())
            {
                if($form->isValid())
                {
                    $this->bankAccountManager->updateBankAccount($values);
                    $this->flashMessage('Bank account has been modified');
                    $this->redirect('this');
                }
            }
        }
        

}
