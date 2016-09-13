<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Security\Passwords;


/**
 * Users management.
 */
class UserManager extends Nette\Object implements Nette\Security\IAuthenticator
{
	const
		TABLE_NAME = 'user',
		COLUMN_ID = 'user_id',
		COLUMN_NAME = 'username',
		COLUMN_PASSWORD_HASH = 'password',
        COLUMN_EMAIL = 'email',
		COLUMN_ROLE = 'role',
        COLUMN_TYPE = 'type',
        COLUMN_ATTACKED = 'attacked';


	/** @var Nette\Database\Context */
	private $database;


	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}


	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		$row = $this->database->table(self::TABLE_NAME)->where(self::COLUMN_NAME, $username)->fetch();

		if (!$row) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} elseif (Passwords::needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
			$row->update(array(
				self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
			));
		}

		$arr = $row->toArray();
		unset($arr[self::COLUMN_PASSWORD_HASH]);
		return new Nette\Security\Identity($row[self::COLUMN_ID], $row[self::COLUMN_ROLE], $arr);
	}


	/**
	 * Adds new user.
	 * @param  string
	 * @param  string
	 * @return void
	 * @throws DuplicateNameException
	 */
	public function add($username, $password, $email)
	{
		try {
			$this->database->table(self::TABLE_NAME)->insert(array(
				self::COLUMN_NAME => $username,
				self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
                                self::COLUMN_EMAIL => $email,
			));
		} catch (Nette\Database\UniqueConstraintViolationException $e) {
			throw new DuplicateNameException;
		}
	} 

	public function getUsers()
	{
		return $this->$db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getUser($id)
	{
		return $this->$db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->fetch();
	}

	public function setUser($data)
	{
		return $this->$db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateUser($data)
	{
		return $this->$db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data[self::COLUMN_ID])->update($data);
	}

	public function deleteUser($id) 
	{
		return $this->$db->table(self::TABLE_NAME)->where(self::COLUMND_ID, $id)->delete();
	}

}



class DuplicateNameException extends \Exception
{}
