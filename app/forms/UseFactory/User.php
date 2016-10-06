<?php

namespace Controls;

use App;
use Entity;
use Nette\Application\UI;
use Nette;
use App\Model\UserManager;

class User extends UI\Control 
{
    private $userManager;
    private $user;
    
    private $owners = [
        1 => 'Ghoul',
        2 => 'Investigator'
    ];
    
    public function __construct(UserManager $um, $id)
    {
        parent::__construct();
        $this->userManager = $um;
        $this->user = $this->userManager->getUser($id);
    }
    
    public function render()
    {
        $this->template->setFile(__DIR__ . '\template\user.latte');
        $this->template->render();
    }
    
     protected function createComponentForm()
     {
         $form = new UI\Form;
         $form->addText('username','Username')
                 ->setRequired()
                 ->setAttribute('placeholder', 'Username')
                 ->addRule($form::MIN_LENGTH, 'Username has to contain atleast 4 characters', 4);
         $form->addPassword('password','Password')
                 ->setRequired()
                 ->setAttribute('placeholder', 'Password')
                 ->addRule($form::MIN_LENGTH, 'Password has to contain atleast 4 characters', 4)
                 ->addRule($form::PATTERN, 'Password has to contain atlest one number', '.*[0-9].*');
     }
}