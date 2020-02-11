<?php

namespace Vincent\Topics\Answers;

use Vincent\Connected\Connected;
use Vincent\SqlRequests\Requestor;
use Vincent\Users\Users;

class AnswersGenerator{

	private $tableName = 'f_topics_answers';

	private $id;

	private $id_user;

	private $user;

	private $id_topic;

	private $answer;



	public function __construct(int $id_user, int $id_topic, string $answer)
	{

		$this->user = (new Requestor(Users::class))->getContentsWithWhere('users', 'id', $id_user, 'id')[0];
		$this->id_user = $id_user;
		$this->id_topic = $id_topic;
		$this->answer = $answer;
	}





    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     *
     * @return self
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     *
     * @return self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdTopic()
    {
        return $this->id_topic;
    }

    /**
     * @param mixed $id_topic
     *
     * @return self
     */
    public function setIdTopic($id_topic)
    {
        $this->id_topic = $id_topic;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param mixed $answer
     *
     * @return self
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

   

    /**
     * Use to insert a new answer into the table of answers
     * @return int|null the id of the last answer
     */
    public function addNewAnswer():?int
    {
    	$cbd = (new Connected())->connectedToDataBase();
    	$req = $cbd->prepare("INSERT INTO {$this->tableName}(id_topic, id_user, answer) VALUES (?, ?, ?)");
    	$req->execute([$this->id_topic, $this->id_user, $this->answer]);
    	return $cbd->lastInsertId();
    }
}