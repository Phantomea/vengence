<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class StateManager extends Nette\Object {

	protected $db;

	const TABLE_NAME = "state",
	COLUMN_ID = "state_id",
	COLUMN_STRENGHT = "strenght",
	COLUMN_AGILITY = "agility",
	COLUMN_INTELLIGENCE = "intelligence",
	COLUMN_VITALITY = "vitalty",
	COLUMN_CHARISMA = "charisma",
	COLUMN_ARMOR = "armor";

	public function __constructor(Context $db){
		$this->db = $db;
	}

	public function getStates(){
		return $this->db->table(self::TABLE_NAME)->order(COLUMN_ID)->fetchAll();
	}

	public function getState($id){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setState($data){
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateState($data){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["state_id"])->update($data);
	}

	public function deleteState($id){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}

}
