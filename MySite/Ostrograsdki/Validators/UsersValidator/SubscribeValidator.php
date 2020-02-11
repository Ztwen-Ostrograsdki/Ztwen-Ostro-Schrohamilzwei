<?php

namespace Vincent\Validators\UsersValidator;

use Vincent\Connected\Connected;
use Vincent\Registers\Subscribe;
use Vincent\SqlRequests\Requestor;
use \PDO;


class SubscribeValidator{



	private $user;


	public function __construct(Subscribe $user)
	{
		$this->user = $user;
	}


	/**
	 * Use to set and get the errors on the user info during the subscribing
	 * @return associativ array The errors
	 */
	public function getUsersErrors():?array
	{
		$defaultEmpty = "Veuillez renseigner ce champ!";
		$defaultLength = "La longueur de la chaine de caractères est invalide!";
		$defaultExisted = "Cette valeur est déjà existante dans la base de données!";
		$errorsTab = [];

		$pseudo = $this->user->getPseudo();
		$mail = $this->user->getMail();
		$mailConfirm = $this->user->getMailConfirm();
		$mdp = $this->user->getMdp();
		$mdpConfirm = $this->user->getMdpConfirm();

		if (!$pseudo == '') {
			if ($this->lengthBetween($pseudo)) {
				if ($this->isAlreadyExist($pseudo, null, 0) == 0 ) {
					
				}
				else{
					$errorsTab['pseudo'] = $defaultExisted;
				}
			}
			else{
				$errorsTab['pseudo'] = $defaultLength;
			}
		}
		else{
			$errorsTab['pseudo'] = $defaultEmpty;
		}

		if (!$mail == '') {
			if ($this->lengthBetween($mail, 10, 250)) {
				if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
					if ($this->isAlreadyExist($mail, null, 0, 'email') == 0) {
						if (!empty($mailConfirm)) {
							if (!(Requestor::setEquals($mail, $mailConfirm))) {
								$errorsTab['mailConfirm'] = "Vous avez renseigné des adresses mails différents!";
							}
						}
					}
					else{
						$errorsTab['mail'] = $defaultExisted;
					}
				}
				else{
					$errorsTab['mail'] = "L'adresse mail que vous avez renseignée est invalide!";
				}
			}
			else{
				$errorsTab['mail'] = $defaultLength;
			}
		}
		else{
			$errorsTab['mail'] = $defaultEmpty;
		}

		if ($mailConfirm == '') {
			$errorsTab['mailConfirm'] = $defaultEmpty;
		}

		if ($mdp !== '') {
			if ($this->lengthBetween($mdp, 5, 250)) {
				if ($mdpConfirm !== '') {
					if (!(Requestor::setEquals($mdp, $mdpConfirm))) {
						$errorsTab['mdpConfirm'] = "Vous avez renseigné des mots de passes différents!";
					}
				}
			}
			else{
				$errorsTab['mdp'] = $defaultLength;
			}
		}
		else{
			$errorsTab['mdp'] = $defaultEmpty;
		}

		if ($mdpConfirm == '') {
			$errorsTab['mdpConfirm'] = $defaultEmpty;
		}

		return $errorsTab;
	}

	/**
	 * Use to if an array is empty
	 * @return bool true for is_empty false for not
	 */
	public function theyAreNotErrors(bool $excerption = true):bool
	{
		if ($excerption === true) {
			return empty($this->getUsersErrors());
		}
	}



	public function isAlreadyExist($value, $id, $np, $targetColumn = null)
	{
		$column = $this->user->getColumn();
		$tableName = $this->user->getTableName();
		$excerptionID = $this->user->getExcerptionID();

		$query = "SELECT COUNT($column) FROM $tableName WHERE $column = '$value' ";
		if ($targetColumn !== null) {
			$query = "SELECT COUNT($column) FROM $tableName WHERE $targetColumn = '$value' ";
		}

		if ($np == -1) {
			$query .= "AND $excerptionID != $id";
		}
		elseif ($np == 1) {
			$query .= "AND $excerptionID = $id";
		}
		elseif ($np == 0) {
			$query = $query;
		}
		$cbd = (new Connected())->connectedToDataBase();
        $req = $cbd->query($query);
        $reqCount = (int)$req->fetch(PDO::FETCH_NUM)[0];
        return $reqCount;
	}





	/**
	 * Use to assert if the lenght of a string is between min and max
	 * @param  string  $string The target
	 * @param  integer $min    The minimal lenght
	 * @param  integer $max    The max lenght
	 * @return bool         true|false
	 */
	public function lengthBetween(string $string, $min = 3, $max = 50):bool
	{
		$lenght = strlen($string);
		if ($lenght >= $min && $lenght < $max) {
			return true;
		}
		return false;
	}

}