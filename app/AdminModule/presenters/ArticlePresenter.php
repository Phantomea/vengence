<?php

namespace AdminModule;

use Nette;
use App\Model\ArticleManager;

use Nette\Application\UI;
use Nette\Application\UI\Form;

final class ArticlePresenter extends BasePresenter
{
	private $meno;
    
	public function renderDefault()
	{

			$meno = 'palovy smrda nohy';
            $this->template->name = $meno;
            $articles = $this->articleManager->getArticles();
            $this->template->articles = $articles;

            
    }
        
        /* Aciotns */
        
}
