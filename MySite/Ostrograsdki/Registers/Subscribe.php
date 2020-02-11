<?php

namespace Vincent\Registers;

use Vincent\Connected\Connected;



class Subscribe{

	private $column = 'pseudo';

	private $excerptionID = 'id';

	private $tableName = 'users';

	private $id;

	private $pseudo;

	private $mail;

	private $mailConfirm;

	private $mdp;

	private $mdpConfirm;

    private $subscribe_date;




	public function __construct(string $pseudo = null, string $mdp = null, string $mail = null, string $mailConfirm = null, string $mdpConfirm = null)
	{

		$this->pseudo = $pseudo;

		$this->mail = $mail;

		$this->mailConfirm = $mailConfirm;

		$this->mdp = $mdp;

		$this->mdpConfirm = $mdpConfirm;

	}

	/**
	 * Get the user's ID
	 * @return int|null
	 */
	public function getID():?int
	{
		return $this->id;
	}

	/**
	 * To set the user's ID
	 * @param int the id of the user
	 * @return self the current instance
	 */
	public function setID(int $id):?self
	{
		 $this->id = $id;

        return $this;
	}

    /**
     * @return mixed
     */
    public function getPseudo():?string
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
    public function getMailConfirm()
    {
        return $this->mailConfirm;
    }

    /**
     * @param mixed $mailConfirm
     *
     * @return self
     */
    public function setMailConfirm($mailConfirm)
    {
        $this->mailConfirm = $mailConfirm;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * @param mixed $mdp
     *
     * @return self
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMdpConfirm()
    {
        return $this->mdpConfirm;
    }

    /**
     * @param mixed $mdpConfirm
     *
     * @return self
     */
    public function setMdpConfirm($mdpConfirm)
    {
        $this->mdpConfirm = $mdpConfirm;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param mixed $column
     *
     * @return self
     */
    public function setColumn($column)
    {
        $this->column = $column;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExcerptionID()
    {
        return $this->excerptionID;
    }

    /**
     * @param mixed $excerptionID
     *
     * @return self
     */
    public function setExcerptionID($excerptionID)
    {
        $this->excerptionID = $excerptionID;

        return $this;
    }

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
     * Use to insert a new user into the table of users
     * @return int|null the id of that last user
     */
    public function insertUserIntoUsersTable():?int
    {

    	$cbd = (new Connected())->connectedToDataBase();
    	$req = $cbd->prepare("INSERT INTO {$this->tableName}(pseudo, email, password) VALUES (?, ?, ?)");
    	$req->execute([$this->pseudo, $this->mail, $this->mdp]);
    	return $cbd->lastInsertId();
    }

}