<?php
 namespace Vincent\Users;

use Vincent\Connected\Connected;
use Vincent\SqlRequests\Requestor;
use \PDO;


 class Users{

	private $id;

	private $pseudo;

	private $email;

    private $password;

	private $subscribe_date;

    private $dateFormatted;

    private $blockedStatus;



    /**
     * @return mixed
     */
    public function getId()
    {
        return (int)$this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = (int)$id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     *
     * @return self
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubscribe_date()
    {
        return $this->subscribe_date;
    }

    public function getBlockedStatus():?bool
    {
        return $this->blockedStatus;
    }

    /**
     * Use to format date in the format day month Name year [01 janvier 2020]
     * @return self the instance
     */
    public function setFormattedDate():self
    {
        $date = mb_substr($this->getSubscribe_date(), 0, 10);
        $m = (int)mb_substr($date, 5,2);
        $month = Requestor::monthOfADate($m);
        $parts = array_reverse(explode('-', $date));
        unset($parts[1]);
        $date = implode(' '.$month.' ', $parts);
        $this->dateFormatted = $date; 

        return $this;
    }


    public function thisUserWasBlocked():self
    {
        $isBlocked = (int)Requestor::getContentWithWhere('id', 'blocked', 'id_user', $this->id);
        if ($isBlocked !== 0 && $isBlocked !== null) {
            $this->blockedStatus = true;
        }
        else{
            $this->blockedStatus = false;
        }    

        return $this;

    }

    /**
     * To get the formatted date
     * @return string|null the date formatted
     */
    public function getFormattedDate():?string
    {
       return $this->dateFormatted;
    }



    public static function getUserVerified(string $address)
    {
        $cbd = (new Connected())->connectedToDataBase();

        $regex = preg_match_all('/\.com|\.fr|@gmail\.com$|@yahoo.fr$/', $address);

        if ($regex == 0) {
            $query = "SELECT * FROM users WHERE pseudo = '$address'";
        }
        elseif ($regex >= 1) {
            $query = "SELECT * FROM users WHERE email = '$address'";
        }

        $req = $cbd->query($query);
        $user = $req->fetchAll(PDO::FETCH_CLASS, self::class)[0];

        return $user;
        
    }
}