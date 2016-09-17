<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class SecondWeaponManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'second_weapon',
			COLUMN_ID = 'second_weapon_id',
			COLUMN_NAME = 'name',
			COLUMN_INFO = 'info',
			COLUMN_TYPE = 'type',
			COLUMN_AVATAR = 'avatar',
			COLUMN_SECOND = 'second_damage',
			COLUMN_FIRST = 'first_damage',
			COLUMN_STATE = 'state_id';

	public function __construct(Context $db)
	{
		$this->db = $db;
	}

	public function getSecondsWeapons()
	{
		return $this->$db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getSecondWeapon($id)
	{
		return $this->$db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setSecondWeapon($data)
	{
		return $this->$db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateSecondWeapon($data)
	{
		return $this->$db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["".self::COLUMN_ID.""])->update($data);
	}

	public function deleteSecondWeapon($id) 
	{
		return $this->$db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
}