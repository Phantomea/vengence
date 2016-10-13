<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class NpcManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'npc',
                COLUMN_ID = 'npc_id',
                COLUMN_NAME = 'name',
                COLUMN_AVATAR = 'avatar',
                COLUMN_STRENGTH = 'strength',
                COLUMN_AGILITY = 'agility',
                COLUMN_INTELLIGENCE = 'intelligence',
                COLUMN_VITALITY = 'vitality',
                COLUMN_CHARISMA = 'charisma',
                COLUMN_ARMOR = 'armor',
                COLUMN_FIRST_DAMAGE = 'first_damage',
                COLUMN_SECOND_DAMAGE = 'second_damage',
                COLUMN_LEVEL = 'level';

	public function __construct(Context $db)
	{
		$this->db = $db;
	}

	public function getNpcs()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getNpc($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setNpc($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateNpc($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["".self::COLUMN_ID.""])->update($data);
	}

	public function deleteNpc($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
        
        /* Additional functions */
        
        public function getLastNpc()
        {
            return $this->db->table(self::TABLE_NAME)->order(''.self::COLUMN_ID.' DESC')->limit(1)->fetch();
        }
        
        public function getNpcByNameOrId($value)
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_NAME.' LIKE ? OR '.self::COLUMN_ID.' LIKE ?', '%'.$value.'%','%'.$value.'%')->order(''.self::COLUMN_LEVEL.' DESC')->fetchAll();
        }
        
        public function getLastTen()
        {
            return $this->db->table(self::TABLE_NAME)->order(''.self::COLUMN_ID.' DESC')->limit(10)->fetchAll();
        }
        
        public function getNumberOfNpcs()
        {
            return $this->db->table(self::TABLE_NAME)->count();
        }
        
        public function getNumberOfNpcByLevel($level)
        {
            return $this->db->table(self::TABLE_NAME)->where(''.self::COLUMN_LEVEL.' >= ?',($level))->where(''.self::COLUMN_LEVEL.' < ?', $level+4)->count();
        }
}