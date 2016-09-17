<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class MaskManager extends Nette\Object {

	protected $db;

	const TABLE_NAME = "mask",
	COLUMN_ID = "mask_id",
	COLUMN_NAME = "name",
	COLUMN_INFO = "info",
	COLUMN_TYPE = "type",
	COLUMN_AVATAR = "avatar",
	COLUMN_STATE_ID = "state_id";

	public function __constructor(Context $db){
		$this->db = $db;
	}

	public function getMasks(){
		return $this->db->table(self::TABLE_NAME)->order(COLUMN_ID)->fetchAll();
	}

	public function getMask($id){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setMask($data){
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateMask($data){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["mask_id"])->update($data);
	}

	public function deleteMask($id){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}

}
