<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class UserStateManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'user_state',
			COLUMN_ID = 'user_state_id';

	public function __construct(Context $db)
	{
		$this->db = $db;
	}

	public function getUserStates()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getUserState($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setUserState($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateUserState($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["".self::COLUMN_ID.""])->update($data);
	}

	public function deleteUserState($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
        
        /* Additional functions */
        
        public function getLastUserState()
        {
            return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID." DESC")->limit(1)->fetch();
        }
}