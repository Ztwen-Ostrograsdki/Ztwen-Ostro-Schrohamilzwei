<?php


namespace Vincent\Topics\Answers;

use Vincent\Connected\Connected;
use Vincent\SqlRequests\Requestor;
use Vincent\Users\Users;
use \DateTime;

class Answers{

	private $tableName = 'f_topics_answers';

	private $id;

	private $id_user;

	private $user;

	private $id_topic;

	private $answer;

	private $answer_date;

	private $dateFormatted;

	private $liked;

	private $disliked;

	private $subcategory;

	private $is_best;


    /**
     * @return mixed
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param mixed $tableName
     *
     * @return self
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
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
    public function setUser()
    {
    	$user = Requestor::getContentWithWhere('pseudo', 'users', 'id', $this->id_user);
        $this->user = ucfirst($user);

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
     * @return mixed
     */
    public function getAnswerDate()
    {
        return $this->answer_date;
    }

    public function getFormattedDate():?string
    {
    	return $this->dateFormatted;
    }

    
    /**
     * Use to format date in the format day month Name year [01 janvier 2020]
     * @return self the instance
     */
    public function setFormattedDate():self
    {
        $date = mb_substr($this->getAnswerDate(), 0, 10);
        $time = mb_substr($this->getAnswerDate(), 11, 19);

        $m = (int)mb_substr($date, 5,2);
        $month = Requestor::monthOfADate($m);
        $parts = array_reverse(explode('-', $date));
        unset($parts[1]);
        $date = implode(' '.$month.' ', $parts);

        $t = new DateTime($time);
        $h = $t->format('H');
        $m = $t->format('i');
        

        $this->dateFormatted = "Postée le ".$date. " à ".$hour = $h."h ".$m."'"; 

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLiked()
    {
        return $this->liked;
    }

    /**
     * @param mixed $liked
     *
     * @return self
     */
    public function setLiked($liked)
    {
        $this->liked = $liked;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisliked()
    {
        return $this->disliked;
    }

    /**
     * @param mixed $disliked
     *
     * @return self
     */
    public function setDisliked($disliked)
    {
        $this->disliked = $disliked;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * @param mixed $subcategory
     *
     * @return self
     */
    public function setSubcategory($subcategory)
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsBest()
    {
        return $this->is_best;
    }

    /**
     * @param mixed $is_best
     *
     * @return self
     */
    public function setIsBest($is_best)
    {
        $this->is_best = $is_best;

        return $this;
    }
}