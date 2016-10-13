<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class SpellManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'spell',
                COLUMN_ID = 'spell_id',
                COLUMN_NAME = 'name',
                COLUMN_INFO = 'info',
                COLUMN_MANA = 'mana',
                COLUMN_LEVEL = 'level',
                COLUMN_PRICE = 'price',
                COLUMN_DAMAGE = 'damage',
                COLUMN_AVATAR = 'avatar',
                COLUMN_TYPE = 'type';

	public function __construct(Context $db)
	{
		$this->db = $db;
	}

	public function getSpells()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getSpell($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setSpell($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateSpell($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["".self::COLUMN_ID.""])->update($data);
	}

	public function deleteSpell($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
        
        /* Additional functions */
        
        public function getNumberOfSpells()
        {
            return $this->db->table(self::TABLE_NAME)->count();
        }
        
        public function getSpellByIdOrName($value)
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_NAME.' LIKE ? OR '.self::COLUMN_ID.' LIKE ?', '%'.$value.'%','%'.$value.'%')->fetchAll();
        }
        
        public function getLastTen()
        {
            return $this->db->table(self::TABLE_NAME)->order(''.self::COLUMN_ID.' DESC')->limit(10)->fetchAll();
        }
        
        public function getSpellByLevel($level)
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_MINIMUM_LEVEL, $level)->fetch();
        }
        
}