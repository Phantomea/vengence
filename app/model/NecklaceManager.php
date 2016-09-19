<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class NecklaceManager extends Nette\Object {

	protected $db;

	const TABLE_NAME = "necklace",
	COLUMN_ID = "necklace_id",
	COLUMN_NAME = "name",
	COLUMN_INFO = "info",
	COLUMN_TYPE = "type",
	COLUMN_AVATAR = "avatar",
	COLUMN_STATE_ID = "state_id";

	public function __construct(Context $db){
		$this->db = $db;
	}

	public function getNecklaces(){
		return $this->db->table(self::TABLE_NAME)->order(COLUMN_ID)->fetchAll();
	}

	public function getNecklace($id){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setNecklace($data){
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateNecklace($data){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["necklace_id"])->update($data);
	}

	public function deleteNecklace($id){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}

}
