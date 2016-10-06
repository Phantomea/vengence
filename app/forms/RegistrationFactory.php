<?php

use Nette\Application\UI;

class RegistrationControl extends Nette\Application\UI\Control
{
    private $emailValidator, $registrator, $mailer, $facebook;

    public function __construct(EmailValidator $emailValidator, Registrator $registrator, Nette\Mail\IMailer $mailer, Facebook $facebook)
    {
        $this->emailValidator = $emailValidator;
        // etc.
    }
}