<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class FirstWeaponManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'first_weapon',
			COLUMN_ID = 'first_weapon_id',
			COLUMN_NAME = 'name',
			COLUMN_STATE = 'state_id';

	public function __constructor(Context $db)
	{
		$this->db = $db;
	}

	public function getFirstWeapons()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getFirstWeapon($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->fetch();
	}

	public function setFirstWeapon($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateFirstWeapon($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data[self::COLUMN_ID])->update($data);
	}

	public function deleteFirstWeapon($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->delete();
	}
}