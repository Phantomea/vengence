<?php

namespace AdminModule;

use App\Model\UserManager;
use App\Model\UserStateManager;
use App\Model\ArmorManager;
use App\Model\WeaponManager;
use App\Model\BankAccountManager;
use Nette\Application\UI;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;

final class UserPresenter extends BasePresenter
{
    public $types = [
                1 => "Ghoul",
                2 => "Investigator"
            ];
    
    public $roles = [
        "player" => "Player",
        "moderator" => "Moderator",
        "banned" => "Banned",
        "admin" => "Admin"
    ];
    
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
            $this["userSearchForm"]->setDefaults(array(
                "word" => $value
            ));
        }
        
        public function renderDetail($user_id)
        {
            $user = $this->userManager->getUser($user_id);
            $user = $user->toArray();
            $this["editUserForm"]->setDefaults($user);
        }
        
        /* Aciotns */
        
        public function handleBanUser($user_id)
        {
            $banUser = $this->userManager->updateUser(array(
                "user_id" => $user_id,
                "role" => "banned"
            ));
        }


        
        protected function createComponentUserSearchForm()
        {
            $form = new Form();
            $form->addText("word", "Word")
                    ->setRequired("Type something here!")
                    ->setAttribute("placeholder", "Enter username or user's ID");
            $form->addSubmit("search", "Search");
            $form->onSuccess[] = array($this, "searchUser");
            return $form;
        }
        
        protected function createComponentCreateUserForm()
        {
            $form = new Form();
            $form->addText("username", "Username")
                    ->setRequired("Choose player's username")
                    ->setAttribute("placeholder", "Enter username or user's ID");
            $form->addPassword("password", "Password")
                    ->setRequired("Choose the password")
                    ->addRule(Form::MIN_LENGTH, "Password has to contain atleast % characters", 4)
                    ->setAttribute("placeholder", "Password");
            $form->addText("birth_date", "Birth date")
                    ->setRequired("Choose birth date")
                    ->setAttribute("placeholder", "Birth date");
            $form->addText("email", "Email")
                    ->setRequired("Enter email address")
                    ->addRule(Form::EMAIL, "Bad pattern of email address")
                    ->setAttribute("placeholder", "Email");
            $form->addSelect("type", "Type")
                    ->setItems($this->types);
            $form->addSelect("role", "Role")
                    ->setItems($this->roles);
            $form->addUpload('avatar')
                    ->addCondition(Form::IMAGE)
                        ->addRule(Form::MIME_TYPE, 'File has to be JPEG or PNG!', array('image/jpeg', 'image/png'))
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximum size of image has to be 64 kB.', 64 * 1024 /* v bytech */);
            $form->addSubmit("register", "Register");
            $form->onSuccess[] = array($this, "addUser");
            return $form;
        }
        
        protected function createComponentEditUserForm()
        {
            $form = new Form();
            $form->addHidden("user_id");
            $form->addText("username", "Username")
                    ->setRequired("Choose player's username")
                    ->setAttribute("placeholder", "Enter username or user's ID");
            $form->addPassword("password", "Password")
                    ->setAttribute("placeholder", "Password");
            $form->addText("birth_date", "Birth date")
                    ->setRequired("Choose birth date")
                    ->setAttribute("placeholder", "Birth date");
            $form->addText("email", "Email")
                    ->setRequired("Enter email address")
                    ->addRule(Form::EMAIL, "Bad pattern of email address")
                    ->setAttribute("placeholder", "Email");
            $form->addSelect("type", "Type")
                    ->setItems($this->types);
            $form->addSelect("role", "Role")
                    ->setItems($this->roles);
            $form->addUpload('avatar')
                    ->addCondition(Form::IMAGE)
                        ->addRule(Form::MIME_TYPE, 'File has to be JPEG or PNG!', array('image/jpeg', 'image/png'))
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximum size of image has to be 64 kB.', 64 * 1024 /* v bytech */);
            $form->addSubmit("edit", "Edit");
            $form->onSuccess[] = array($this, "editUser");
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
                        
                        $createUser = $this->userManager->setUser($values);
                        $this->flashMessage("User has been created!");
                        $this->redirect("this");
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
                $editUser = $this->userManager->updateUser($values);
                $this->flashMessage("User has been updated!");
                $this->redirect("User:detail", $values["user_id"]);
            } 
        }

}
