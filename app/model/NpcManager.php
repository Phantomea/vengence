<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class NpcManager extends Nette\Object {

	protected $db;

	const TABLE_NAME = 'npc',
			COLUMN_ID = 'npc_id',
			COLUMN_NAME = 'name',
			COLUMN_AVATAR = 'avatar',
			COLUMN_FIRST_DAMAGE = 'first_damage',
			COLUMN_SECOND_DAMAGE = 'second_damage',
			COLUMN_STATE_ID = 'state_id';

	public function __constructor(Context $db){
		$this->db = $db;
	}

	public function getAllNpc(){
		
	}

}