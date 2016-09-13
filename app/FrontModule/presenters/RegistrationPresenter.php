<?php

namespace FrontModule;

use Nette\Application\UI;
use Nette\Application\UI\Form;
use App\Model\UserManager;
use App\Model\GhoulManager;
use Nette\Security\Passwords;


final class RegistrationPresenter extends BasePresenter
{
    private $userManager;
    
    public function __construct(UserManager $um) {
        parent::__construct();
        $this->userManager = $um;
    }

    public function renderDefault()
    {
        $this->template->anyVariable = 'any value';
    }

    protected function createComponentRegisterPlayerForm() {

        $years = array();
        for($i = date("Y"); $i>=1900; $i--){ // Do premenej $years daj roky od tohoto roku až po rok 1900
            $years[$i] = $i;
        }
        
        $typesOfPlayers = array( // Pridanie typov hráčov - Ghoulovia a Vyšetrovatelia
            'ghoul' => 'Ghoul',
            'investigator' => 'Investigator'
        );

        $form = new Form;
        $form->addText('username','Username')
                ->setRequired('Username is required!')
                ->setAttribute('placeholder', 'Choose username')
                ->addRule(FORM::MIN_LENGTH, 'Username has to be longer than 4 characters!', 5)
                ->addRule(FORM::MAX_LENGTH, 'Username cannot contain more than 15 characters!', 15);
        $form->addText('email','Email')
                ->setRequired('Email is required!')
                ->setAttribute('placeholder', 'Enter email')
                ->addRule(FORM::EMAIL, 'Use correct email address!');
        $form->addPassword('password','Password')
                ->setRequired('Password is required!')
                ->setAttribute('placeholder', 'Choose password')
                ->addRule(FORM::MIN_LENGTH, 'Password has to be longer than 4 characters!', 5)
                ->addRule(FORM::PATTERN, 'Password has to contain atleast one number', '.*[0-9].*');
        $form->addText('month', 'MM')
                ->setRequired('Month is required')
                ->setType('number')
                ->setAttribute('placeholder', 'MM')
                ->addRule(FORM::MIN, 'Months of a year starts with 1!', 1)
                ->addRule(FORM::MAX, 'There are not more than 12 months!',12);
        $form->addText('day', 'DD')
                ->setRequired('Day is required')
                ->setType('number')
                ->setAttribute('placeholder', 'DD')
                ->addRule(FORM::MIN, 'Days of a month starts with 1!', 1)
                ->addRule(FORM::MAX, 'There are not more than 31 days!',31);
        $form->addSelect('year', 'Year')
                ->setRequired('Year is required')
                ->setItems($years)
                ->setAttribute('placeholder', 'YY');
        $form->addRadioList('role', 'Role:', $typesOfPlayers)
                ->setRequired('Role is required')
                ->getSeparatorPrototype()->setName(NULL);
        $form->addSubmit('register','Register');

        $form->onSuccess[] = array($this,'registerPlayer');

        return $form;

    }
    
    public function registerPlayer(Form $form, $values) {
        if($form['register']->isSubmittedBy()){
            if($form->isValid()){
                if($this->userManager->userExists($values['username'])){
                    $this->flashMessage('Username is already taken');
                    $this->redirect('this');
                } elseif($this->userManager->emailExists($values['email'])){
                    $this->flashMessage('Email is already taken');
                    $this->redirect('this');
                }
                $values['password'] = Passwords::hash($values['password']);
                $this->userManager->registerUser(array(
                    'username' => $values['username'],
                    'password' => $values['password'],
                    'email' => $values['email'],
                    'birth_date' => $values['year'].'-'.$values['month'].'-'.$values['day'],
                    'type' => $values['role']
                ));
                
                $this->flashMessage('You have been successfully registered');
                $this->redirect('Sign:in');
            } else {
                $this->flashMessage('Something went wrong!');
                $this->redirect('Sign:in');
            }
        }
    }
               
}
