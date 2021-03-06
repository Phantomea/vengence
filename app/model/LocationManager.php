<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class LocationManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'location',
                COLUMN_ID = 'location_id',
                COLUMN_NAME = 'name',
                COLUMN_MINIMUM_LEVEL = 'minimum_level',
                COLUMN_TYPE = 'type';

	public function __construct(Context $db)
	{
		$this->db = $db;
	}

	public function getLocations()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getLocation($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setLocation($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateLocation($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["".self::COLUMN_ID.""])->update($data);
	}

	public function deleteLocation($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
        
        /* Additional functions */
        
        public function numberOfLocations()
        {
            return $this->db->table(self::TABLE_NAME)->count();
        }
        
        public function searchLocationByNameOrId($value)
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_NAME.' LIKE ? OR '.self::COLUMN_ID.' LIKE ?', '%'.$value.'%','%'.$value.'%')->fetchAll();
        }
        
        public function getLastTen()
        {
            return $this->db->table(self::TABLE_NAME)->order(''.self::COLUMN_ID.' DESC')->limit(10)->fetchAll();
        }
        
        public function getLocationByLevel($level)
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_MINIMUM_LEVEL, $level)->fetch();
        }
        
}