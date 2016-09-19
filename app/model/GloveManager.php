<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class GloveManager extends Nette\Object {

	protected $db;

	const TABLE_NAME = "glove",
	COLUMN_ID = "glove_id",
	COLUMN_NAME = "name",
	COLUMN_INFO = "info",
	COLUMN_TYPE = "type",
	COLUMN_AVATAR = "avatar",
	COLUMN_STATE_ID = "state_id";

	public function __construct(Context $db){
		$this->db = $db;
	}

	public function getGloves(){
		return $this->db->table(self::TABLE_NAME)->order(COLUMN_ID)->fetchAll();
	}

	public function getGlove($id){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setGlove($data){
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateGlove($data){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["glove_id"])->update($data);
	}

	public function deleteGlove($id){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}

}
