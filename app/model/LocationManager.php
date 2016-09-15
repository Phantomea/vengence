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
			COLUMN_MAXIMUM_LEVEL = 'maximum_level',
			COLUMN_MINIMUM_LEVEL = 'minimum_level';

	public function __constructor(Context $db)
	{
		$this->db = $db;
	}

	public function getLocations()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getLocation($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->fetch();
	}

	public function setLocation($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateLocation($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data[self::COLUMN_ID])->update($data);
	}

	public function deleteLocation($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->delete();
	}
}