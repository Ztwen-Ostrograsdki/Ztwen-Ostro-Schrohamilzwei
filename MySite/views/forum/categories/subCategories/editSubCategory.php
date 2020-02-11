<?php 

use Vincent\Auth\UrlAuth;
use Vincent\Categories\Categories;
use Vincent\Formator\Form;
use Vincent\Validators\Validators;

	$title = "Edition de la sous-catégorie";
	$again = false;
	$errors = '';
	$id = (int)$params['id'];
	$urlSlug = $params['slug'];

	$auth = (new UrlAuth())->urlAuthenticator($id, $urlSlug, $router);// Verified the url params, if not compatible redirect to the home page of Forum

	$input = new Form('', 'text', 'catName', ucfirst($auth->getCategory()), '');
	$input->setPlaceholder("Veuillez saisir le nouveau nom de la catégorie")
		  ->setId($id);

	if (!empty($_GET)) {
		$catName = (string)htmlspecialchars($_GET['catName']);
		$input->setValue($catName);
		$newCategory = new Categories();
		$newCategory->setId($id);
		$validator = new Validators($input, $newCategory);

		$wasSet = $validator->isAlreadyExist($catName, $id, -1);
		$errors = $validator->getAdvancedErrors($wasSet);
		$noErrors = $validator->theyAreNotErrors($wasSet, true);
		
		if ($noErrors) {
			$newCategory->setCategory($catName)
						->setId($id)
						->setSlug($newCategory->getCategory())
						->editCategory();
			$noErrors = true;
			$errors = '';
			header('Location:'.$router->urlPut('Categories', ['slug' => e($newCategory->getSlug()), 'id' => $id]));
			exit();
		}
		
	}

?>

<div class="m-0 p-0 w-100">
	<form action="" class="form-group addNow" method="get" id="addNow">
		<?php 
			if (isset($noErrors)) {
				if(!$noErrors){$input->classList = "ml-2 form-control is-invalid";}
				elseif($noErrors !== false){$input->setValue('');}
			}
			echo $input->setInput(false, 75) ;
			if (isset($noErrors) && $noErrors == false) {
				echo $input->invalidFeedBack($errors);
			}
		?>
		<button type="submit" class="btn btn-cat mt-2 ml-1 w-25" name="addNow">Sauvegarder</button>
	</form>
</div>
