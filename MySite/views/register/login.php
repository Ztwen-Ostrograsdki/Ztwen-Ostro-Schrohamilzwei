<?php 

use Vincent\Auth\UsersLoginAuth;
use Vincent\Formator\Form;
use Vincent\Registers\Subscribe;
use Vincent\Security\Security;
use Vincent\Users\Users;
use Vincent\Validators\UsersValidator\LoginValidator;


$inputAddress = new Form('Votre pseudo ou E-mail', 'text', 'address', '','');
$inputAddress->setPlaceholder('Veuillez renseigner votre adresse pour vous connecter');

$inputPassWord = new Form('Votre mot de passe', 'password', 'mdp', '','');
$inputPassWord->setPlaceholder('Veuillez renseigner votre mot de passe ');

$title = "Connexion";
	$errors = [];
	$noErrors = true;
	$ok = 0;
	$noInput = false;


	if (!empty($_POST)) {

		
		
		$address = htmlspecialchars($_POST['address']);
		$mdp = htmlspecialchars($_POST['mdp']);

		$user = new Subscribe($address, $mdp);

		// The object of the security key//
		$b = new Security($address);    

		$validator = new LoginValidator($user);
		$errors = $validator->getUsersErrors();
		$noErrors = $validator->theyAreNotErrors();

		$auth = (new UsersLoginAuth($address));
		$authUser = $auth->userPasswordAuthenticate($mdp);
		$userWasBlocked = $auth->thisUserWasBlocked();
		

		if ($authUser === true && $userWasBlocked === false) {

			$b->deleteOverTriying();
			$userInfos = Users::getUserVerified($address);

			$_SESSION['id'] = $userInfos->getId();
			$_SESSION['pseudo'] = $userInfos->getPseudo();
			$_SESSION['email'] = $userInfos->getEmail();

			header('Location:'.$router->urlPut('Forum'));
			exit();
		}
		elseif($authUser === false && $userWasBlocked === false){
			$block = $b->blockedThisUser();
			$b->reduceTryingPassWord();// Incremente la valeur de tentative de connexion avec password incorrect dans la base de données!
			$errors['mdp'] = "Mot de passe incorrect!";
		}
		elseif ($userWasBlocked === true) {
			$noInput = true;
		}
	}


?>

<div class="register-container">
	<h3 class="register-title">Connexion</h3>
	<form action="" class="w-100" method="post">

		<?php 

			//GESTION DU ADDRESSE
			$inputAddress->errors = $errors['address'] ?? '';
            if(isset($errors['address']) AND $errors['address'] !== null) {
                $inputAddress->classListAdvanced = 'form-control border-danger is-invalid';
            }
            if(isset($address) AND $errors !== []) {
                $inputAddress->setValue($address);
            }
            if ($noInput) {
            	$inputAddress->classListAdvanced = 'form-control border-danger';
            	$inputAddress->disabled = 'disabled';
            }
            echo $inputAddress->advancedSetInput();

            echo $inputAddress->invalidCustomFeedBack($inputAddress->errors);


			//GESTION DU MOT DE PASSE
			$inputPassWord->errors = $errors['mdp'] ?? '';
            if(isset($errors['mdp']) AND $errors['mdp'] !== null) {
                $inputPassWord->classListAdvanced = 'form-control border-danger is-invalid';
            }
            if ($noInput) {
            	$inputPassWord->setPlaceholder('Trop de tentatives erronées du mot de passe');
            	$inputPassWord->errors = "Votre compte a été blocké. <br> Vous ne pouvez plus vous connecter sans l'avoir débloqué!";
            	$inputPassWord->classListAdvanced = 'form-control border-danger';
            	$inputPassWord->disabled = 'disabled';
            }

            echo $inputPassWord->advancedSetInput();

            echo $inputPassWord->invalidCustomFeedBack($inputPassWord->errors);
		?>
	<div class="subscribe-div">
		<?php if(!$noInput) {?> <button class="btn subscribe btn-register w-100">Connecter</button> <?php } ?>
	</div>
	</form>
	<p class="text-center m-auto login-linker">
		<a href="<?= $router->urlPut('Subscribe') ?>" class="text-white" title="S'inscrire">Je n'me suis pas encore inscris</a>
	</p>
</div>
