<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class HelmetManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'helmet',
			COLUMN_ID = 'helmet_id',
			COLUMN_NAME = 'name',
			COLUMN_INFO = 'info',
			COLUMN_TYPE = 'type',
			COLUMN_AVATAR = 'avatar',
			COLUMN_STATE = 'state_id';

	public function __construct(Context $db)
	{
		$this->db = $db;
	}

	public function getHelmets()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getHelmet($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setHelmet()
	{
		return $this->db->table(self::TABLE_NAME)->insert();
	}

	public function updateHelmet($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["".self::COLUMN_ID.""])->update($data);
	}

	public function deleteHelmet($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
        
        /* Additional functions */
        
        public function getLastTenHelmets()
        {
            return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->limit(10)->fetchAll();
        }
        
        public function getNumberOfHelmets()
        {
            return $this->db->table(self::TABLE_NAME)->count();
        }
        
        public function getNumberOfGhoulHelmets()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 1)->count();
        }
        
        public function getNumberOfInvestigatorHelmets()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 2)->count();
        }
}