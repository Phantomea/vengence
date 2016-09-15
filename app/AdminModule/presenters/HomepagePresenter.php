<?php

namespace AdminModule;

use App\Model\UserManager;
use Nette\Application\UI;
use Nette\Application\UI\Form;

final class HomepagePresenter extends BasePresenter
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
        
        protected function createComponentUserSearchForm()
        {
            $choices = [
                0 => 'ID',
                1 => 'Name'
            ];
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
        }

}
