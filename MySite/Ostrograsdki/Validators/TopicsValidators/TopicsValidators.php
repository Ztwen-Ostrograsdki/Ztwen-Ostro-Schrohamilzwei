<?php

namespace Vincent\Validators\TopicsValidators;

use Vincent\Connected\Connected;
use Vincent\SqlRequests\Requestor;
use Vincent\Topics\TopicsGenerator;
use \PDO;


class TopicsValidators{

	private $topic;


	public function __construct(TopicsGenerator $topic)
	{
		$this->topic = $topic;

	}


	public function getErrors():?array
	{
		$erorrsTab = [];

		if (empty($this->topic->getContent()) || $this->topic->getContent() == '' || $this->topic->getContent() == null) {
			$erorrsTab['content'] = "Vous renseignez votre topic svp!";
		}
		elseif (!$this->lengthBetween($this->topic->getContent())) {
			$erorrsTab['content'] = "La longueur de votre topic est invalide!";
		}
		else{
			if ($this->thisTopicWasAlreadyExisted()) {
				$erorrsTab['content'] = "Le topic que vous essayez de soumettre est déjà existant!";
			}
		}

		return $erorrsTab;

	}


	public function theyAreNoErrors():?bool
	{
		return empty($this->thisTopicWasAlreadyExisted());
	}

	/**
	 * use to assert that if a content of a topic was already set in the database
	 * @return bool true|false
	 */
	public function thisTopicWasAlreadyExisted():bool
    {
    	$column = $this->topic->getColumn();
		$tableName = $this->topic->getTableName();
		$columIdSubCat = 'id_sub_category';

		$is_exist = (int)(new Requestor())->getContentWith2Where('id', 'f_topics', 'content', $this->topic->getContent(), 'id_sub_category', $this->topic->getIdSubCategory());

		if ($is_exist > 0) {
			return true;
		}
		return false;

    }


	/**
	 * Use to assert if the lenght of a string is between min and max
	 * @param  string  $string The target
	 * @param  integer $min    The minimal lenght
	 * @param  integer $max    The max lenght
	 * @return bool         true|false
	 */
	public function lengthBetween(string $string, $min = 20, $max = 3000):bool
	{
		$lenght = strlen($string);
		if ($lenght >= $min && $lenght < $max) {
			return true;
		}
		return false;
	}






}