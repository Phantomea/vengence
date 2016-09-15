<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class LocationManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'weapon',
			COLUMN_WEAPON_ID = 'weapon_id',
			COLUMN_FIRST = 'first_weapon_id',
			COLUMN_SECOND = 'second_weapon_id';

	public function __constructor(Context $db)
	{
		$this->db = $db;
	}

	public function getWeapons()
	{
		return $this->$db->table(self::TABLE_NAME)->order(self::COLUMN_WEAPON_ID)->fetchAll();
	}

	public function getWeapon($id)
	{
		return $this->$db->table(self::TABLE_NAME)->where(self::COLUMND_WEAPON_ID, $id)->fetch();
	}

	public function setWeapon($data)
	{
		return $this->$db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateWeapon($data)
	{
		return $this->$db->table(self::TABLE_NAME)->where(self::COLUMN_WEAPON_ID, $data[self::COLUMN_WEAPON_ID])->update($data);
	}

	public function deleteWeapon($id) 
	{
		return $this->$db->table(self::TABLE_NAME)->where(self::COLUMND_WEAPON_ID, $id)->delete();
	}
}