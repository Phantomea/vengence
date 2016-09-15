<?php

namespace AdminModule;

use App\Model\UserManager;
use Nette\Application\UI;
use Nette\Application\UI\Form;

final class HomepagePresenter extends BasePresenter
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
        
        protected function createComponentCreateModerator()
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
                    ->setItems($types);
            $form->addSelect("role", "Role")
                    ->setItems($types);
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
            if($form["add"]->isSubmittedBy())
            {
                if($form->isValid())
                {
                    
                }
            }
        }

}
