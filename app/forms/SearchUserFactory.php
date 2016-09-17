<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


class SearchUserFactory
{
    
    /**
     * @return Form
     */
    public function create()
    {
        $form = new Form();
        $form->addText("word", "Word")
                ->setRequired("Type something here!")
                ->setAttribute("placeholder", "Enter username or user's ID");
        $form->addSubmit("search", "Search");
        return $form;
    }
}