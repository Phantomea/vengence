<?php

namespace AdminModule;

use Nette;
use App\Forms\SignFormFactory;


class SignPresenter extends BasePresenter
{
	/** @var SignFormFactory @inject */
	public $factory;


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
        
        
        public function renderIn(){
            if(!$this->getUser()->isAllowed($this->getName(), $this->getAction())) {
                if (!$this->getUser()->isLoggedIn()) {
                    $this->getUser()->logout(TRUE);
                    $this->redirect("Sign:in");
                } else {
                    $this->getUser()->logout(TRUE);
                    $this->flashMessage("Wrong username or password!", "danger");
                    $this->redirect("Sign:in");
                }
            } else {
                $this->getUser()->logout(TRUE);
            }
        }
        
        public function renderOut()
        {
            $this->getUser()->logout(TRUE);
            $this->redirect('Sign:in');
        }
        
        
	protected function createComponentSignInForm()
	{
		$form = $this->factory->create();
		$form->onSuccess[] = function ($form) {
			$form->getPresenter()->redirect('Homepage:');
                        
		};
		return $form;
	}

	public function actionOut()
	{
		$this->getUser()->logout();
	}

}
