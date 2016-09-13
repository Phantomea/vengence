<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class ArmorManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'armor',
			COLUMN_ID = 'armor_id';

	public function __constructor(Context $db)
	{
		$this->db = $db;
	}

	public function getArmors ()
	{
		return $this->$db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getArmor($id)
	{
		return $this->$db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->fetch();
	}

	public function setArmor($data)
	{
		return $this->$db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateArmor($data)
	{
		return $this->$db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data[self::COLUMN_ID])->update($data);
	}

	public function deleteArmor($id) 
	{
		return $this->$db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->delete();
	}
}