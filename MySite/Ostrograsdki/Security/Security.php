<?php

namespace Vincent\Security;

use Vincent\Connected\Connected;
use Vincent\SqlRequests\Requestor;
use \PDO;


class Security{

	/**
	 * The instance of PDO connexion
	 * @var Object
	 */
	private $cbd;


	/**
	 * The address of the user the email|the pseudo
	 * @var string
	 */
	private $address;

	/**
	 * The concerned field of the address if it's email => field => 'email' or pseudo => field => 'pseudo'
	 * @var string
	 */
	private $field;



	public function __construct(string $address)
	{
		$this->cbd = (new Connected())->connectedToDataBase();
		$this->address = $address;
		$regex = preg_match_all('/\.com|\.fr|@gmail\.com$|@yahoo.fr$/', $address);
		if ($regex == 0) {
			$this->field = 'pseudo';
		}
		elseif ($regex > 0) {
			$this->field = 'email';
		}

		$id = (int)Requestor::getContentWithWhere('id', 'users', $this->field, $this->address);
		$this->id_user = $id;
	
	}


	/**
	 * Increment the warning wrong password in the db
	 * @return void
	 */
	public function reduceTryingPassWord()
	{
		$id = (int)$this->id_user;
		if ($id !== 0) {
			$tries = (int)Requestor::getContentWithWhere('tries', 'warning', 'id_user' , $this->id_user);
			if ($tries == 0) {
				$tries = 1;
				$query = "INSERT INTO warning(tries, id_user) VALUES (?, ?)";
			}
			elseif ($tries > 0) {
				$tries = $tries + 1;
				$query = "UPDATE warning SET tries = ? WHERE id_user = ?";
			}
			$req = $this->cbd->prepare($query);
			$req->execute([$tries, $this->id_user]);
		}
	}


	/**
	 * Use to block user if over wrong password was set
	 * @return boolean 'true' id the user was blocked and 'false' if not
	 */
	public function blockedThisUser():bool
	{
		$id_already_set = (int)Requestor::getContentWithWhere('id', 'blocked', 'id_user', $this->id_user);
		if ($id_already_set == 0 || $id_already_set == null) {
			$tries = (int)Requestor::getContentWithWhere('tries', 'warning', 'id_user' , $this->id_user);

			if ($tries >= 3) {
				$query = "INSERT INTO blocked(id_user, address) VALUES(?, ?)";
				$req = $this->cbd->prepare($query);
				$succed = $req->execute([$this->id_user, $this->address]);

				if ($succed) {
					return true;
				}
			}
			
		}
		else{
			return false;
		}
	}


	/**
	 * Use to remove the user from the warning table if he set the true password
	 * @return boolean
	 */
	public function deleteOverTriying():bool
	{
		$id_already_set = (int)Requestor::getContentWithWhere('id', 'warning', 'id_user', $this->id_user);
		if ($id_already_set == 0 || $id_already_set == null) {
			return false;
		}
		else{
			$query = "DELETE FROM warning WHERE id_user = $this->id_user";
			$result = $this->cbd->exec($query);
			if ($result !== false && $result !== 0) {
				return true;
			}
			else{
				return false;
			}
		}
	}

	/**
	 * Use to block an user 
	 * @param  int    $user_id [description]
	 * @return void
	 */
	public static function forcedBlocked(int $id_user, string $address)
	{
		$cbd = (new Connected())->connectedToDataBase();
		$query = "INSERT INTO blocked(id_user, address) VALUES(?, ?)";
		$req = $cbd->prepare($query);
		$succed = $req->execute([$id_user, $address]);
	}

	public static function unBlockedThisUser(int $id_user, string $address)
	{
		$cbd = (new Connected())->connectedToDataBase();
		$query = "DELETE FROM blocked WHERE id_user = '$id_user' AND address = '$address'";
		$req = $cbd->exec($query);
	}


	public static function removeThisUser(int $id_user, string $address)
	{
		$cbd = (new Connected())->connectedToDataBase();
		$query = "DELETE FROM users WHERE id_user = '$id_user' AND address = '$address'";
		$req = $cbd->exec($query);
	}


}