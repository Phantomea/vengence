<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class CloackManager extends Nette\Object {

	protected $db;

	const TABLE_NAME = "cloack",
	COLUMN_ID = "cloack_id",
	COLUMN_NAME = "name",
	COLUMN_INFO = "info",
	COLUMN_TYPE = "type",
	COLUMN_AVATAR = "avatar",
	COLUMN_STATE_ID = "state_id";

	public function __constructor(Context $db){
		$this->db = $db;
	}

	public function getCloacks(){
		return $this->db->table(self::TABLE_NAME)->order(COLUMN_ID)->fetchAll();
	}

	public function getCloack($id){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setCloack($data){
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateCloack($data){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["cloack_id"])->update($data);
	}

	public function deleteBoot($id){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}

}
