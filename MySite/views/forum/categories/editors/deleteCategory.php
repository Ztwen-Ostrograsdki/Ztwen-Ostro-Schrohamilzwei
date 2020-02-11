<?php

use Vincent\Auth\UrlAuth;
use Vincent\Categories\Categories;
use Vincent\SqlRequests\Requestor;

$id = $params['id'];
$urlSlug = $params['slug'];

if (isset($_POST['delete'])) {
	$auth = (new UrlAuth())->urlAuthenticator($id, $urlSlug, $router);
	$auth->deleteCategory($router);
}