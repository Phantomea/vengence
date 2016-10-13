<?php

namespace AdminModule;

use Nette;

use Nette\Application\UI;
use Nette\Application\UI\Form;

class xxxxx  extends BasePresenter
{
    private $id;
    
    public function renderDefault($id = NULL)
    {
        $this->id = $id;
    }
    
    public function renderDetail($id)
    {
        
    }
    
    public function renderResult($value)
    {
        
    }
}