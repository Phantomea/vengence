<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class ItemManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'item',
                COLUMN_ID = 'item_id',
                COLUMN_NAME = 'name',
                COLUMN_STRENGTH = 'strength',
                COLUMN_AGILITY = 'agility',
                COLUMN_INTELLIGENCE = 'intelligence',
                COLUMN_VITALITY = 'vitality',
                COLUMN_CHARISMA = 'charisma',
                COLUMN_ARMOR = 'armor',
                COLUMN_FIRST_DAMAGE = 'first_damage',
                COLUMN_SECOND_DAMAGE = 'second_damage',
                COLUMN_LEVEL = 'level',
                COLUMN_TYPE = 'type',
                COLUMN_OWNER = 'owner';

	public function __construct(Context $db)
	{
		$this->db = $db;
	}

	public function getItems()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getItem($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setItem($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateItem($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["".self::COLUMN_ID.""])->update($data);
	}

	public function deleteItem($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
        
        /* Additional funcitons */
        
        public function getShopItems($level, $owner, $type)
        {
                return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_LEVEL, $level)->where(self::COLUMN_OWNER, $owner)->where(self::COLUMN_TYPE, $type)->limit(8)->order('rand()')->fetchAll();
        }
        
        public function getNumberOfItems()
        {
            return $this->db->table(self::TABLE_NAME)->count();
        }
        
        public function getNumberOfHelmets()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'helmet')->count();
        }
        
        public function getNumberOfMasks()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'mask')->count();
        }
        
        public function getNumberOfNecklaces()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'necklace')->count();
        }
        
        public function getNumberOfCloaks()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'cloak')->count();
        }
        
        public function getNumberOfArmors()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'armor')->count();
        }
        
        public function getNumberOfGloves()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'glove')->count();
        }
        
        public function getNumberOfRings()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'rings')->count();
        }
        
        public function getNumberOfBelts()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'belt')->count();
        }
        
        public function getNumberOfTrousers()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'trouser')->count();
        }
        
        public function getNumberOfBoots()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'boots')->count();
        }
        
        public function getNumberOfFirstWeapons()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'first_weapon')->count();
        }
        
        public function getNumberOfSecondWeapons()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'second_weapon')->count();
        }
        
        public function getNumberOfPotions()
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_TYPE, 'potion')->count();
        }
        
        public function searchItemByNameOrId($value)
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_NAME.' LIKE ? OR '.self::COLUMN_ID.' LIKE ?', '%'.$value.'%','%'.$value.'%')->fetchAll();
        }
        
        public function getLastTen()
        {
            return $this->db->table(self::TABLE_NAME)->order(''.self::COLUMN_ID.' DESC')->limit(10)->fetchAll();
        }
}