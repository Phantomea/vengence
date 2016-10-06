<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class InventoryManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'inventory',
                COLUMN_ID = 'inventory_id',
                COLUMN_SIZE = 'size';

	public function __construct(Context $db)
	{
		$this->db = $db;
	}

	public function getInventories()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getInventory($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->fetch();
	}

	public function setInventory($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateInventory($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["".self::COLUMN_ID.""])->update($data);
	}

	public function deleteInventory($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->delete();
	}
        
        /* Additional funcitons */
        
        
}