<?php

namespace App\Forms\SpellFactory;

use Nette;

class SpellFactory extends Nette\Object
{

    private $spellManager;

    public function __construct(\App\Model\SpellManager $sm) {
        $this->spellManager = $sm;
    }

    public function create($id) {
        return new \Controls\Spell($this->spellManager, $id);
    }

}
