<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class MenuManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'menu',
                COLUMN_ID = 'menu_id',
                COLUMN_NAME = 'name';

	public function __construct(Context $database)
        {
            $this->db = $database;
        }

	public function getMenus()
	{
            return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getMenu($id)
	{
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setMenu($data)
	{
            return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateMenu($data)
	{
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data[self::COLUMN_ID])->update($data);
	}

	public function deleteMenu($id) 
	{
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->delete();
	}
}