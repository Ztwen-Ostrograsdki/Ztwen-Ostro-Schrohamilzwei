<?php

namespace Vincent\Validators;

use \PDO;
use Vincent\Connected\Connected;
use Vincent\Formator\Form;
use Vincent\SqlRequests\Requestor;


class Validators{


	/**
	 * An instance of Form
	 * @var Form
	 */
	private $input;

	private $validatorClassMapping;


	public function __construct (Form $input, $validatorClassMapping)
	{
		$this->input = $input;
		$this->validatorClassMapping = $validatorClassMapping;
	}



	/**
	 * Use to get errors the an excerption
	 * @return array the errors
	 */
	public function getAdvancedErrors($aleadyExist)
	{
		$errorsTab = [];

		if (!$this->lengthBetween($this->input->getValue())) {
			return $errorsTab['lenght'] = "La longueur du nom est invalide!";
		}
		if ($aleadyExist >= 1) {
			return $errorsTab['isExist'] = "La Valeur que vous tenter d'enregistrer est déjà existante dans la base de données!";
		}
		return $errorsTab;
	}

	/**
	 * Use to if an array is empty
	 * @return bool true for is_empty false for not
	 */
	public function theyAreNotErrors(bool $aleadyExist, bool $excerption = true):bool
	{
		if ($excerption === true) {
			return empty($this->getAdvancedErrors($aleadyExist));
		}
	}


	public function isAlreadyExist($value, $id, $np)
	{
		$column = $this->validatorClassMapping->getColumn();
		$tableName = $this->validatorClassMapping->getTableName();
		$excerptionID = $this->validatorClassMapping->excerptionID;

		$query = "SELECT COUNT($column) FROM $tableName WHERE $column = '$value' ";

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