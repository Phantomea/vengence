<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class BankAccountManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'bank_account',
			COLUMN_ID = 'bank_account_id',
			COLUMN_MONEY = 'money',
			COLUMN_DIAMONS = 'diamonds';

	public function __constructor(Context $db)
	{
		$this->db = $db;
	}

	public function getBankAccounts()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getBankAccount($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->fetch();
	}

	public function setBankAccount()
	{
		return $this->db->table(self::TABLE_NAME)->insert();
	}

	public function updateBankAccount($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data[self::COLUMN_ID])->update($data);
	}

	public function deleteBankAccount($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->delete();
	}
}