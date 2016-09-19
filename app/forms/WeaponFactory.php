<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;


class WeaponFactory extends Nette\Object
{
    /** @var FormFactory */
	private $factory;

	/** @var User */
	private $user;
        
        public function __construct(FormFactory $factory, User $user)
	{
		$this->factory = $factory;
		$this->user = $user;
	}
        
        /**
	 * @return Form
	 */
	public function create()
        {
            $type = [
                1 => 'Ghoul',
                2 => 'Investigator'
            ];
            $form = $this->factory->create();
            $form->addText('name', 'Name')
                    ->setRequired()
                    ->setAttribute('placeholder','Enter helmet\'s name');
            $form->addText('info', 'Info')
                    ->setRequired()
                    ->setAttribute('placeholder', 'Enter description of helmet');
            $form->addSelect('type', 'Type')
                    ->setItems($type);
            $form->addUpload('avatar')
                    ->addCondition(Form::IMAGE)
                    ->addRule(Form::MIME_TYPE, 'File has to be JPEG or PNG!', array('image/jpeg', 'image/png'))
                    ->addRule(Form::MAX_FILE_SIZE, 'Maximum size of image has to be 150 kB.', 150 * 1024 /* v bytech */);
            $form->addText('strength','Strength')
                    ->setType('number')
                    ->setRequired()
                    ->setDefaultValue(0)
                    ->setAttribute('placeholder', 'Enter bonus number (5, -5, 0)');
            $form->addText('agility','Agility')
                    ->setType('number')
                    ->setRequired()
                    ->setDefaultValue(0)
                    ->setAttribute('placeholder', 'Enter bonus number (5, -5, 0)');
            $form->addText('intelligence','Intelligence')
                    ->setType('number')
                    ->setRequired()
                    ->setDefaultValue(0)
                    ->setAttribute('placeholder', 'Enter bonus number (5, -5, 0)');
            $form->addText('vitality','Vitality')
                    ->setType('number')
                    ->setRequired()
                    ->setDefaultValue(0)
                    ->setAttribute('placeholder', 'Enter bonus number (5, -5, 0)');
            $form->addText('charisma','Charisma')
                    ->setType('number')
                    ->setRequired()
                    ->setDefaultValue(0)
                    ->setAttribute('placeholder', 'Enter bonus number (5, -5, 0)');
            $form->addText('armor','Armor')
                    ->setType('number')
                    ->setRequired()
                    ->setDefaultValue(0)
                    ->setAttribute('placeholder', 'Enter bonus number (5, -5, 0)');
            $form->addSubmit('add', 'Add');
            
            return $form;
        }

}