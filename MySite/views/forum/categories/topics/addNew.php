<?php
use Vincent\Auth\UrlAuth;
use Vincent\Categories\SubCategories;
use Vincent\Formator\Form;
use Vincent\SqlRequests\Requestor;
use Vincent\Topics\TopicsGenerator;
use Vincent\Validators\TopicsValidators\TopicsValidators;
use Vincent\Validators\Validators;
if(isset($_SESSION['id'])){ 

	$title = "Création de nouvelle topics";
	$again = false;
	$errors = '';
	$category = $params['category'];
	$urlSlug = $params['slug'];
	$urlID = (int)$params['id'];

	$auth = $auth = new UrlAuth(SubCategories::class);
	$r = $auth->urlAuthenticatorSubCategory($category, $urlSlug, $urlID, $router);
	
	$category = $params['category'];
	$id_category = (int)Requestor::getContentWithWhere('id', 'f_categories', 'category', $category);
	$slug = $urlSlug;
	$id_subcategory = $urlID;

	$input = new Form('Votre Sujet', 'text', 'topic', '', '');
	$input->setPlaceholder("Veuillez saisir le nom de la Sous-catégorie");

	$noErrors = true;

	if (!empty($_POST)) {
		
		$content = urlencode(htmlspecialchars($_POST['topic']));
		$user = $_SESSION['pseudo'];
		$topic = new TopicsGenerator($content, $id_category, $id_subcategory, $user);

		$validator = new TopicsValidators($topic);

		$errorsTab = $validator->getErrors();
		$noErrors = empty($errorsTab);

		if ($noErrors) {
			$topic->setContent(urldecode($content))->insertNewTopic();
			header('Location:'.$router->urlPut('Topics', ['category' => $category, 'slug' => $slug, 'id' => $urlID]));
		}
	}

?>

<div class="m-0 p-3 w-100">
	<div class="m-0 p-0 topics-textarea">
			<form action="" class="form-group addNow" method="POST">
			<?php 
				if (isset($content, $noErrors)) {
					if(!$noErrors){$input->classListTextArea = "ml-2 input-danger"; $input->setValue($content);}
					elseif($noErrors){$input->setValue('');}
				}
				echo $input->setTextArea() ;
				if (isset($noErrors, $content) && $noErrors == false) {
					$errors = $errorsTab['content'];
					echo $input->invalidCustomFeedBack($errors, true);
				}

			?>
			<button type="submit" class="btn btn-cat mt-2 ml-1 w-25">Soumettre</button>
		</form>
	</div>
</div>
<?php }else{ header('Location:'.$router->urlPut('Login'));} ?>