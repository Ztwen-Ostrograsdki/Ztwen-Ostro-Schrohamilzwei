<?php
namespace Vincent\Topics;

use Vincent\SqlRequests\Requestor;
use \DateTime;


class Topics{


	private $id;

	private $id_user;

	private $user;

	private $id_category;

	private $id_sub_category;

	private $content;

	private $created_at;

	private $date;

	private $views;

	private $notif;

	private $best_answer;

	private $resolved;

	private $edited;




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
        return ucfirst($this->user);
    }

    /**
     * 
     * @return self
     */
    public function setUser()
    {
    	$pseudo = (string)Requestor::getContentWithWhere('pseudo', 'users', 'id', $this->getIdUser());
        $this->user = $pseudo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdCategory()
    {
        return $this->id_category;
    }

    /**
     * @param mixed $id_category
     *
     * @return self
     */
    public function setIdCategory($id_category)
    {
        $this->id_category = $id_category;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdSubCategory()
    {
        return $this->id_sub_category;
    }

    /**
     * @param mixed $id_sub_category
     *
     * @return self
     */
    public function setIdSubCategory($id_sub_category)
    {
        $this->id_sub_category = $id_sub_category;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return "\" ".nl2br(ucfirst(e($this->content)))." \"";
    }

    /**
     * @param mixed $content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     *
     * @return self
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     *
     * @return self
    */

	public function setDate():self
    {
        $date = mb_substr($this->getCreatedAt(), 0, 10);
        $time = mb_substr($this->getCreatedAt(), 11, 19);

        $m = (int)mb_substr($date, 5,2);
        $month = Requestor::monthOfADate($m);
        $parts = array_reverse(explode('-', $date));
        unset($parts[1]);
        $date = implode(' '.$month.' ', $parts);

        $t = new DateTime($time);
        $h = $t->format('H');
        $m = $t->format('i');
        

        $this->date = $date. " à ".$hour = $h."h ".$m."'"; 

        return $this;
    }


    /**
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param mixed $views
     *
     * @return self
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotif()
    {
        return $this->notif;
    }

    /**
     * @param mixed $notif
     *
     * @return self
     */
    public function setNotif($notif)
    {
        $this->notif = $notif;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBestAnswer()
    {
        return $this->best_answer;
    }

    /**
     * @param mixed $best_answer
     *
     * @return self
     */
    public function setBestAnswer($best_answer)
    {
        $this->best_answer = $best_answer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResolved()
    {
        return $this->resolved;
    }

    /**
     * @param mixed $resolved
     *
     * @return self
     */
    public function setResolved($resolved)
    {
        $this->resolved = $resolved;

        return $this;
    }

    public static function excerpt (string $content, int $limit = 60) 
    {
        $strLengh = mb_strlen($content);
        if($strLengh <= $limit) {
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $lastSpace).' ...';
    }



}