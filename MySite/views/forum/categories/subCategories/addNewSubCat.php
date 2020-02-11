<?php 

use Vincent\Auth\UrlAuth;
use Vincent\Categories\SubCategories;
use Vincent\Formator\Form;
use Vincent\Validators\Validators;


	$title = "Création de nouvelle sous-catégorie";
	$again = false;
	$errors = '';
	$urlSlug = $params['slug'];
	$id = $params['id'];

	$auth = (new UrlAuth())->urlAuthenticator($id, $urlSlug, $router);// Verified the url params, if not compatible redirect to the home page of Forum

	$input = new Form('', 'text', 'subCatName', '', '');
	$input->setPlaceholder("Veuillez saisir le nom de la Sous-catégorie");



	if (!empty($_GET)) {
		$subCatName = (string)htmlspecialchars($_GET['subCatName']);
		$input->setValue($subCatName)
			  ->setId($id);
		$newSubCategory = new SubCategories();
		$validator = new Validators($input, $newSubCategory);
	
		$wasSet = $validator->isAlreadyExist($subCatName, $id, 1);
		$errors = $validator->getAdvancedErrors($wasSet);
		$noErrors = $validator->theyAreNotErrors($wasSet, true);

		if ($noErrors) {
			$newSubCategory->setSubCategory($subCatName)
						   ->setSubSlug($newSubCategory->getSubCategory());
			$subID = (int)$newSubCategory->addNewSubCategory($id);
			$newSubCategory->setId($subID);
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
