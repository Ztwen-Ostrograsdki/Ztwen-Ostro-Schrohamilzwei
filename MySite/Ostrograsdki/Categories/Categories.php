<?php
namespace Vincent\Categories;

use Vincent\Categories\SubCategories;
use Vincent\Connected\Connected;
use Vincent\Routing\Router;
use Vincent\SqlRequests\Requestor;


/**
 * This class is use to make the representation of a category
 */
class Categories{

    /**
     * the name of the category
     * @var string
     */
    private $category;


    /**
     * The key of request with excerption
     * @var string
     */
    public $excerptionID = 'id';

    /**
     * The name of the table in the database
     * @var string
     */
    private $tableName = 'f_categories';

    /**
     * The current column where we can get the name of a category if the table of the categories
     * @var string
     */
    private $column = 'category';

    /**
     * The id of the category in the database
     * @var int
     */
    private $id;

    /**
     * The slug of the category
     * @var string
     */
    private $slug;

    /**
     * The list of the subCategories joined to the category
     * @var array
     */
    private $subCategories = [];

    /**
     * Use to get the name of the current table
     * @return string|null
     */
    public function getTableName():?string
    {
        return $this->tableName;
    }

    /**
     * use to get the name of the current table 
     * @return string|null
     */
    public function getColumn():?string
    {
        return $this->column;
    }

    /**
     * @return string|null
     */
    public function getCategory():?string
    {
        return $this->category;
    }

    /**
     * @param string $category
     *
     * @return self
     */
    public function setCategory(string $category):self
    {
        $this->category = $category;

        return $this;
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
    public function setId(int $id):self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug():?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return self
     */
    public function setSlug(string $category):self
    {
        $s = explode(' ', ucwords($category));
        $slug = implode('-', $s);
        $this->slug = $slug;

        return $this;
    }

    public function addSubCategories()
    {
        $subCat = [];
        $items = (new Requestor(SubCategories::class))->getContentsWithWhere('f_sub_categories', 'id_category', $this->getId(), 'sub_category');
        foreach ($items as $item) {
            $subCat[] = $item;
        }

        return $this->subCategories = $subCat;
    }


    public function getSubCategories():?array
    {
        
    }



    /**
     * Use to insert a new category into categories table
     * @return int The id of the last insert
     */
    public function addNewContentToCategories():?int
    {
        $cbd = (new Connected())->connectedToDataBase();
        $req = $cbd->prepare("INSERT INTO {$this->tableName}(category) VALUES(?)");
        $req->execute([$this->category]);
        return $cbd->lastInsertId();
    }


    /**
     * Use to edit a category
     * @return void
     */
    public function editCategory():void
    {
        $cbd = (new Connected())->connectedToDataBase();
        $req = $cbd->prepare("UPDATE {$this->tableName} SET {$this->column} = ? WHERE id = ?");
        $req->execute([$this->getCategory(), $this->getId()]);
    }


    /**
     * Use to delete a category and make redirection if succed
     * @param  Router  $router  an instance of Router to make redirection
     * @param  boolean $deleteSubCatAssociated
     * @return void
     */
    public function deleteCategory(Router $router, $deleteSubCatAssociated = false)
    {
        $cbd = (new Connected())->connectedToDataBase();

        if ($deleteSubCatAssociated === true) {
            $cbd->beginTransaction();
            $cbd->exec("DELETE FROM {$this->tableName} WHERE id = {$this->getId()}");
            $cbd->exec("DELETE FROM f_sub_categories WHERE id_category = {$this->getId()}");
            $cbd->commit();
            header('Location:'.$router->urlPut('Forum'));
            exit();
        }
        $req = $cbd->exec("DELETE FROM {$this->tableName} WHERE id = {$this->getId()}");
    }
}