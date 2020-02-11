<?php

namespace Vincent\Auth;

use Vincent\Connected\Connected;
use Vincent\Registers\Subscribe;
use Vincent\SqlRequests\Requestor;
use \PDO;

class UsersLoginAuth{

	private $id;

	private $pseudo;

	private $mail;

	private $password;

	private $address;

    private $field;





	public function __construct(string $address = null)
	{
		if ($address !== null) {
            
            $regex = preg_match_all('/\.com|\.fr|@gmail\.com$|@yahoo.fr$/', $address);

            if ($regex == 0) {
                $id = (int)Requestor::getContentWithWhere('id', 'users', 'pseudo', $address);
                $this->field = 'pseudo';
            }
            elseif ($regex > 0) {
                $id = (int)Requestor::getContentWithWhere('id', 'users', 'email', $address);
                $this->field = 'email';
            }
            $this->id = $id;
			$this->address = $address;
		}
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
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     *
     * @return self
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function userPasswordAuthenticate(string $password):bool
    {
    	$cbd = (new Connected())->connectedToDataBase();

    	$address = $this->address;
    	
    	$query = "SELECT password FROM users WHERE {$this->field} = '$address'";
    
    	$req = $cbd->query($query);
        $result = $req->fetch();
        
        if(password_verify($password, $result['password'])){
        	return true;
        }

        return false;

    }


    public function thisUserWasBlocked():bool
    {
        if ($this->id !== 0 || $this->id !== null) {
            $cbd = (new Connected())->connectedToDataBase();
            $req = $cbd->query("SELECT COUNT(id) FROM blocked WHERE id_user = {$this->id}");
            $reqCount = (int)$req->fetch(PDO::FETCH_NUM)[0];
            if ($reqCount > 0) {
                return true;
            }
        }
        return false;

    }


}