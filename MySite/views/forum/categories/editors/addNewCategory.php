<?php 

use Vincent\Categories\Categories;
use Vincent\Formator\Form;
use Vincent\Validators\CategoriesValidator;
use Vincent\Validators\Validators;

	$title = "Creation de nouvelle catégorie";
	$again = false;
	$errors = '';


	$input = new Form('', 'text', 'catName', '', '');
	$input->setPlaceholder("Veuillez saisir le nom de la catégorie");


	if (!empty($_GET)) {
		$catName = (string)htmlspecialchars($_GET['catName']);
		$input->setValue($catName);
		$newCategory = new Categories();
		$validator = new Validators($input, $newCategory);

		$wasSet = $validator->isAlreadyExist($catName, null, 0);
		$errors = $validator->getAdvancedErrors($wasSet);
		$noErrors = $validator->theyAreNotErrors($wasSet);

		if ($noErrors) {
			$newCategory->setCategory($catName)
						->setSlug($newCategory->getCategory());
			$id = (int)$newCategory->addNewContentToCategories();
			$newCategory->setId($id);
			$noErrors = true;
			$errors = '';	
			
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
