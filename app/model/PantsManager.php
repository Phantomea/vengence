<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class PantsManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'pants',
			COLUMN_ID = 'pants_id',
			COLUMN_NAME = 'name',
			COLUMN_INFO = 'info',
			COLUMN_TYPE = 'type',
			COLUMN_AVATAR = 'avatar',
			COLUMN_STATE = 'state_id';

	public function __constructor(Context $db)
	{
		$this->db = $db;
	}

	public function getAllPants()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getPants($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setPants($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updatePants($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data[self::COLUMN_ID])->update($data);
	}

	public function deletePants($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
        
        /* Additional functions */
}