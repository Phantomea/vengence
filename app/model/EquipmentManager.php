<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class EquipmentManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'equipment',
                COLUMN_ID = 'equipment_id',
                COLUMN_HELMET = 'helmet_id',
                COLUMN_MASK = 'mask_id',
                COLUMN_NECKLACE = 'necklace_id',
                COLUMN_ARMOR = 'armor_id',
                COLUMN_CLOAK = 'cloak_id',
                COLUMN_GLOVE = 'glove_id',
                COLUMN_BELT = 'belt_id',
                COLUMN_RING = 'ring_id',
                COLUMN_TROUSER = 'trouser_id',
                COLUMN_BOOT = 'boot_id';

	public function __construct(Context $db)
	{
		$this->db = $db;
	}

	public function getEquipments()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getEquipment($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setEquipment($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateEquipment($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["".self::COLUMN_ID.""])->update($data);
	}

	public function deleteEquipment($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
        
        /* Additional funcitons */
        
        
}