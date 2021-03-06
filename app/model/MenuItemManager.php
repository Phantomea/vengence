<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class MenuItemManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'menu_item',
			COLUMN_ID = 'menu_item_id',
			COLUMN_NAME = 'name',
			COLUMN_LINK = 'link',
			COLUMN_MENU_ID = 'menu_id';

	public function __construct(Context $db)
	{
		$this->db = $db;
	}

	public function getMenuItems()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getMenuItem($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setMenuItem($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateMenuItem($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data[''.self::COLUMN_ID.''])->update($data);
	}

	public function deleteMenuItem($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
        
        /* Additional functions */
        
        public function getLastMenuItem()
        {
            return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID." DESC")->limit(1)->fetch();
        }
        
        public function searchMenuItemByNameOrId($value)
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_NAME.' LIKE ? OR '.self::COLUMN_ID.' LIKE ?', '%'.$value.'%','%'.$value.'%')->fetchAll();
        }
}