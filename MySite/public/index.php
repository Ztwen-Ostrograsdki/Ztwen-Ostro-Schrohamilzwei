<?php 
session_start();
require_once "../../vendor/autoload.php";
$viewPath = dirname(__DIR__);
use Vincent\Routing\Router;
use Whoops\Run;
$router = new Router($viewPath);

$whoops = new Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


$router
    ->getPath('/', '/public'.DIRECTORY_SEPARATOR.'home', 'Home')
    ->getPath('/register', '/views/register/index', 'Subscribe')
    ->getPath('/admin/usersConfig/[i:userID]-[*:action]', '/views/admin/config/usersConfig', 'UsersConfig')
    ->getPath('/admin', '/views/admin/users/index', 'Admin')
    ->post_getPath('/login', '/views/register/login', 'Login')
    ->getPath('/logout', '/views/register/disconnect', 'LoginOut')
    ->getPath('/forum', '/views/forum/index', 'Forum')
    ->getPath('/forum/category/new', '/views/forum/categories/editors/addNewCategory', 'AddNewCategory')
    ->getPath('/forum/category/[*:slug]-[i:id]/new', '/views/forum/categories/SubCategories/addNewSubCat', 'AddNewSubCategory')
    ->getPath('/forum/category/[*:slug]-[i:id]/edit', '/views/forum/categories/editors/edit', 'EditCategory')
    ->post_getPath('/forum/categories/[*:category]/[*:slug]-[i:id]/topic/new', '/views/forum/categories/topics/addNew', 'Topic_New')
    ->post_getPath('/forum/categories/[*:category]/[*:slug]-[i:id]/topic-[i:IDtopic]', '/views/forum/categories/topics/index', 'Topic_show')
    ->getPath('/forum/categories/[*:category]/[*:slug]-[i:id]', '/views/forum/categories/subcategories', 'Topics')
    ->getPath('/forum/categories/[*:slug]-[i:id]', '/views/forum/categories/index', 'Categories')
    ->postPath('/forum/categories/delete/[*:slug]-[i:id]', '/views/forum/categories/editors/deleteCategory', 'DeleteCategory')

    


    ->run();
