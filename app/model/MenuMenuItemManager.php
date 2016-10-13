<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class MenuMenuItemManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'menu_menu_item',
			COLUMN_ID = 'menu_menu_item_id',
			COLUMN_MENU_ID = 'menu_id',
			COLUMN_MENU_ITEM_ID = 'menu_item_id';

	public function __construct(Context $db)
	{
		$this->db = $db;
	}

	public function getMenuMenuItems()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getMenuMenuItem($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setMenuMenuItem($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateMenuMenuItem($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data[''.self::COLUMN_ID.''])->update($data);
	}

	public function deleteMenuMenuItem($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
        
        /* Additional functions */
        
        public function getMenuMenuItemsByMenuIdAndMenuItemId($data)
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_MENU_ID, $data[''.self::COLUMN_MENU_ID.''])->where(self::COLUMN_MENU_ITEM_ID, $data[''.self::COLUMN_MENU_ITEM_ID.''])->fetch();
        }


        public function getMenuMenuItemByMenuId($id)
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_MENU_ID, $id)->fetchAll();
        }
        
        public function getMenuMenuItemsByMenuItemId($id)
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_MENU_ITEM_ID, $id)->fetchAll();
        }
        
        public function getMenuMenuItemByMenuItemId($id)
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_MENU_ITEM_ID, $id)->fetch();
        }
}