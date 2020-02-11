<?php
namespace Vincent\Auth;

use Vincent\Categories\Categories;
use Vincent\Routing\Router;
use Vincent\SqlRequests\Requestor;
use Vincent\Topics\Topics;


class UrlAuth{

	private $classMappingSelf;

	public function __construct($classMappingSelf = Categories::class)
	{
		$this->classMappingSelf = $classMappingSelf;
	}

	public function urlAuthenticator(int $id, string $urlKey, Router $router)
	{
		$r = (new Requestor($this->classMappingSelf))->getContentsWithWhere('f_categories', 'id', $id, 'category')[0];
		$r->setSlug($r->getCategory());
		$verified = Requestor::setEquals($urlKey, $r->getSlug());
		if (!$verified) {
			header('Location:'.$router->urlPut('Forum'));
			exit();
		}
		if ($verified) {
			return $r;
		}
	}

	public function urlAuthenticatorSubCategory(string $category, string $urlSlug, int $urlKey, Router $router)
	{
		$url = str_replace('-', ' ', $urlSlug);
		if ($urlSlug === "C-plus-plus") {
			$url = "C++";
		}
		$reqOnCategory = (int)((new Requestor(Categories::class))->getContentWithWhere('id', 'f_categories', 'category', $category)[0]);

		if ($reqOnCategory !== null) {
			$id_category = $reqOnCategory;
			$reqOnSubCategory = (new Requestor($this->classMappingSelf))->getContentsWith2Where('f_sub_categories', 'id_category', $id_category, 'sub_category', $url);
			if ($reqOnSubCategory) {
				if (is_array($reqOnSubCategory)) {
					$idSubCat = (int)$reqOnSubCategory['id'];
				}
				else{
					$idSubCat = (int)$reqOnSubCategory->getId();
				}
				$verified = Requestor::setEquals($urlKey, $idSubCat);
			}
			if (!$verified) {
				header('Location:'.$router->urlPut('Forum'));
				exit();
			}
			else{
				if (is_object($reqOnSubCategory)) {
					$reqOnSubCategory->setHisCategory()
								     ->getCategoryLied()
								     ->addSubCategories();
					return $reqOnSubCategory;
				}
				else{
					return null;
				}

				
			}
		}
		else{
			header('Location:'.$router->urlPut('Forum'));
			exit();
		}
	}


	public function urlAuthenticatorTopics(int $IDtopic, string $category, string $sub_category, int $IDsubCat, Router $router)
	{
		$reqOnTopic = (new Requestor(Topics::class))->getContentWithWhere('id', 'f_topics', 'id', $IDtopic);

		if ($reqOnTopic !== null) {
			return true;
		}
		else{
			header('Location:'.$router->urlPut('Topics', ['category' => $category, 'slug' => $sub_category, 'id' => $IDsubCat]));
			exit();
		}
		
	}
}