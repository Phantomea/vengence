<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class ClothManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'cloth',
			COLUMN_ID = 'clothes_id',
			COLUMN_NAME = 'name',
			COLUMN_INFO = 'info',
			COLUMN_TYPE = 'type',
			COLUMN_AVATAR = 'avatar',
			COLUMN_STATE = 'state_id';

	public function __construt(Context $db)
	{
		$this->db = $db;
	}

	public function getClothes()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getCloth($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setCloth($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateCloth($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data[self::COLUMN_ID])->update($data);
	}

	public function deleteCloth($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
}