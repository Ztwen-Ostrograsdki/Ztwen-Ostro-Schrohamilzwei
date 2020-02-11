<?php

namespace Vincent\Validators\UsersValidator;

use Vincent\Connected\Connected;
use Vincent\Registers\Subscribe;
use Vincent\SqlRequests\Requestor;
use \PDO;


class LoginValidator{



	private $user;


	public function __construct(Subscribe $user)
	{
		$this->user = $user;
		$address = $this->user->getPseudo();
		$regex = preg_match_all('/\.com|\.fr|@gmail\.com$|@yahoo.fr$/', $address);

		if ($regex > 0) {
			$this->user->setMail($address);
			$this->user->setPseudo(null);
		}

	}


	/**
	 * Use to set and get the errors on the user info during the subscribing
	 * @return associativ array The errors
	 */
	public function getUsersErrors():?array
	{
		$defaultEmpty = "Veuillez renseigner ce champ!";
		$defaultLength = "Le format renseigné est invalide!";
		$errorsTab = [];


		$pseudo = $this->user->getPseudo();
		$mail = $this->user->getMail();
		$mdp = $this->user->getMdp();

		if ($mail == null) {
			if (!$pseudo == '') {
				if ($this->lengthBetween($pseudo)) {
					$suscribed = (int)$this->userDoesNotExist($pseudo);

					if ($suscribed !== 1) {
						$errorsTab['address'] = "L'adresse que vous avez renseigné est inconnu!";
					}
				}
				else{
					$errorsTab['address'] = $defaultLength;
				}
			}
			else{
				$errorsTab['address'] = $defaultEmpty;
			}
		}
		elseif ($pseudo == null) {
			if (!$mail == '') {
				if ($this->lengthBetween($mail)) {
					$suscribed = (int)$this->userDoesNotExist($mail);

					if ($suscribed !== 1) {
						$errorsTab['address'] = "L'adresse mail que vous avez renseignée est inconnue!";
					}
				}
				else{
					$errorsTab['address'] = $defaultLength;
				}
			}
			else{
				$errorsTab['address'] = $defaultEmpty;
			}
		}

		if ($mdp !== '') {
			if ($this->lengthBetween($mdp, 5, 255)) {
				
			}
			else{
				$errorsTab['mdp'] = $defaultLength;
			}
		}
		else{
			$errorsTab['mdp'] = $defaultEmpty;
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


	/**
	 * Use to asset if a user with address email|pseudo is already subscribe
	 * @param  string $value user's email or pseudo
	 * @return int
	 */
	public function userDoesNotExist(string $address):?int
	{
		$regex = preg_match_all('/\.com|\.fr|@gmail\.com$|@yahoo.fr$/', $address);

		if ($regex == 0) {
			$column = 'pseudo';
		}
		elseif ($regex >= 1) {
			$column = 'email';
		}

		$query = "SELECT COUNT($column) FROM users WHERE $column = '$address' ";
		
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