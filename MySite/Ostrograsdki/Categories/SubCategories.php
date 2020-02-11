<?php
namespace Vincent\Categories;
use Vincent\Categories\Categories;
use Vincent\Connected\Connected;
use Vincent\SqlRequests\Requestor;

/**
 * This class is use to make the representation of a Subcategory
 */
class SubCategories{


    private $tableName = 'f_sub_categories';

    private $column = 'sub_category';

    public $excerptionID = 'id_category';

    public $typeOfExcerption = 1;

	/**
	 * The Subcategory id in the database
	 * @var int
	 */
	private $id;

	/**
	 * The id of the Category joined to this Subcategory
	 * @var int
	 */
	private $id_category;

	/**
	 * The name of the current category joined to this one
	 * @var string
	 */
	private $hisCategory;

    private $categoryLied;

    /**
     * The slug made with the name of the subcategory
     * @var string
     */
    private $subSlug;

	/**
	 * The name of the Subcategory
	 * @var string
	 */
	private $sub_category;

    public function getTableName():?string
    {
        return $this->tableName;
    }

    public function getColumn():?string
    {
        return $this->column;
    }

    /**
     * @return int|null
     */
    public function getId():?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId($id):self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getIdCategory():?int
    {
        return $this->id_category;
    }

    /**
     * @param int $id_category
     *
     * @return self
     */
    public function setIdCategory($id_category):self
    {
        $this->id_category = $id_category;

        return $this;
    }


    /**
     * Set the category
     * @return Category an instance of Category::class
     * @param int|null $id_category [description]
     */
    public function setHisCategory(int $id_category = null):self
    {

        if ($id_category === null) {
           $key = $this->id_category;
        }
        else{
            $key = $id_category;
        }

        $item = (new Requestor(Categories::class))->getContentsWithWhere('f_categories', 'id', $key, 'category')[0];
        $this->hisCategory = $item;
        return $this;
    }

    public function getCategoryLied():Categories
    {
        return $this->hisCategory;
    }

    /**
     * Return the name of the category which this one is derivated
     * @return string|null the name of the category
     */
    public function getHisCategory():?string
    {
        return $this->hisCategory->getCategory();
    }

    /**
     * @return string|null
     */
    public function getSubCategory():?string
    {
        return $this->sub_category;
    }

    /**
     * @param string $sub_category
     *
     * @return self
     */
    public function setSubCategory($sub_category):self
    {
        $this->sub_category = $sub_category;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubSlug()
    {
        return urldecode($this->subSlug);
    }

    /**
     * @param string $subSlug
     *
     * @return self
     */
    public function setSubSlug(string $subSlug):self
    {
        if ($subSlug === 'C++') {
            $subSlug = "C-plus-plus";
        }
        else{
            $s = explode(' ', ucwords($subSlug));
            $subSlug = implode('-', $s);
            $subSlug = $subSlug;
        }

        $this->subSlug = $subSlug;   
        return $this;
    }

    public function addNewSubCategory(int $id_category):?int
    {
        $cbd = (new Connected())->connectedToDataBase();
        $req = $cbd->prepare("INSERT INTO {$this->tableName}(id_category, sub_category) VALUES(?, ?)");
        $req->execute([$id_category, $this->sub_category]);
        return $cbd->lastInsertId();
    }
}