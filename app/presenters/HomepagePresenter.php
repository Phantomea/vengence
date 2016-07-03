<?php

namespace App\Presenters;

use Nette;
use App\Model;


class HomepagePresenter extends BasePresenter
{  
    

	public function renderDefault()
	{
            $user = $this->user->loggedIn;
		if(!$user){
                    $this->redirect('Sign:in');
                }
	}

}
