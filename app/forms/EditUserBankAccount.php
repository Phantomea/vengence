<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


class EditUserBankAccountFactory
{
    
    /**
     * @return Form
     */
    public function create()
    {
        $form = new Form();
        $form->addHidden('bank_account_id');
        $form->addText('money', 'Money')
                ->setRequired()
                ->setType('number')
                ->setAttribute('placeholder', 'Enter the number');
        $form->addText('diamonds', 'Diamonds')
                ->setRequired()
                ->setType('number')
                ->setAttribute('placeholder', 'Enter the number');
        $form->addSubmit('edit','Edit');
        return $form;
    }
}