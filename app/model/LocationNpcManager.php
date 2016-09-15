<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class LocationNpcManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'location_npc',
			COLUMN_ID = 'location_npc_id',
			COLUMN_NPC = 'npc_id';

	public function __constructor(Context $db)
	{
		$this->db = $db;
	}

	public function getLocationNpcs()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getLocationNpc($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->fetch();
	}

	public function setLocationNpc($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateLocationNpc($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data[self::COLUMN_ID])->update($data);
	}

	public function deleteLocationNpc($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->delete();
	}
}