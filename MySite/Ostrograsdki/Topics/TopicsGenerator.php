<?php
namespace Vincent\Topics;

use Vincent\Connected\Connected;
use Vincent\SqlRequests\Requestor;



class TopicsGenerator{

	private $tableName = 'f_topics';

	private $column = 'content';

	private $user;

	private $id_category;

	private $id_subCategory;

	private $content;

	private $date;




	public function __construct($content = null, $id_category = null, $id_subcategory = null, $user = null)
	{
		
		$this->id_category = $id_category;
		$this->id_subCategory = $id_subcategory;
		$this->content = $content;
        $this->user = $user;
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
        return $this->id_subCategory;
    }

    /**
     * @param mixed $id_subCategory
     *
     * @return self
     */
    public function setIdSubCategory($id_subCategory)
    {
        $this->id_subCategory = $id_subCategory;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }


    public function insertNewTopic()
    {
        $id_user = (int)Requestor::getContentWithWhere('id', 'users', 'pseudo', $this->user);
        $cbd = (new Connected())->connectedToDataBase();
        $req = $cbd->prepare("INSERT INTO {$this->tableName}(id_category, id_sub_category, id_user, content) VALUES(?, ?, ?, ?)");
        $req->execute([$this->id_category, $this->id_subCategory, $id_user, $this->content]);
        return $cbd->lastInsertId();
    }
}
