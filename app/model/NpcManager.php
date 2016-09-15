<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class NpcManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'npc',
			COLUMN_ID = 'npc_id',
			COLUMN_NAME = 'name',
			COLUMN_AVATAR = 'avatar',
			COLUMN_FIRST = 'first_damage',
			COLUMN_SECOND = 'second_damage',
			COLUMN_STATE = 'state_id';

	public function __constructor(Context $db)
	{
		$this->db = $db;
	}

	public function getNpcs()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getNpc($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->fetch();
	}

	public function setNpc($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateNpc($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data[self::COLUMN_ID])->update($data);
	}

	public function deleteNpc($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->delete();
	}
}