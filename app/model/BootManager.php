<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class BootManager extends Nette\Object {

	protected $db;

	const TABLE_NAME = "boot",
	COLUMN_ID = "boot_id",
	COLUMN_NAME = "name",
	COLUMN_INFO = "info",
	COLUMN_TYPE = "type",
	COLUMN_AVATAR = "avatar",
	COLUMN_STATE_ID = "state_id";
	
	public function __construct(Context $db){
		$this->db = $db;
	}

	public function getBoots(){
		return $this->db->table(self::TABLE_NAME)->order(COLUMN_ID)->fetchAll();
	}

	public function getBoot($id){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setBoot($data){
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateBoot($data){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["boot_id"])->update($data);
	}

	public function deleteBoot($id){
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}


} 