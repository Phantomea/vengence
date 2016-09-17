<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;


class EditUserFactory
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
    
    /**
     * @return Form
     */
    public function create()
    {
        $form = new Form;
        
        $form->addHidden("user_id");
        $form->addText("username", "Username")
                ->setRequired("Choose player's username")
                ->setAttribute("placeholder", "Enter username or user's ID");
        $form->addPassword("password", "Password")
                ->setAttribute("placeholder", "Password");
        $form->addText("birth_date", "Birth date")
                ->setRequired("Choose birth date")
                ->setAttribute("placeholder", "Birth date");
        $form->addText("email", "Email")
                ->setRequired("Enter email address")
                ->addRule(Form::EMAIL, "Bad pattern of email address")
                ->setAttribute("placeholder", "Email");
        $form->addSelect("type", "Type")
                ->setItems($this->types);
        $form->addSelect("role", "Role")
                ->setItems($this->roles);
        $form->addUpload('avatar')
                ->addCondition(Form::IMAGE)
                    ->addRule(Form::MIME_TYPE, 'File has to be JPEG or PNG!', array('image/jpeg', 'image/png'))
                ->addRule(Form::MAX_FILE_SIZE, 'Maximum size of image has to be 64 kB.', 64 * 1024);
        $form->addSubmit("edit", "Edit");
        return $form;
    }
    
}