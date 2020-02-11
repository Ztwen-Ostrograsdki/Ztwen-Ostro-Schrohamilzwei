<?php 

use Vincent\Formator\Form;
use Vincent\Registers\Subscribe;
use Vincent\Validators\UsersValidator\SubscribeValidator;


$inputPseudo = new Form('Votre pseudo', 'text', 'pseudo', '','');
$inputPseudo->setPlaceholder('Veuillez choisir un pseudo');

$inputMail = new Form('Votre adresse E-mail', 'email', 'mail', '','');
$inputMail->setPlaceholder('Veuillez renseigner votre adresse mail ici');

$inputMailConfirm = new Form('Confirmation E-mail', 'email', 'mailConfirm', '','');
$inputMailConfirm->setPlaceholder('Veuillez confirmer votre adresse mail ici');

$inputPassWord = new Form('Votre mot de passe', 'password', 'mdp', '','');
$inputPassWord->setPlaceholder('Veuillez renseigner votre mot de passe ici');

$inputPassWordConfirm = new Form('Confirmation mot de passe', 'password', 'mdpConfirm', '','');
$inputPassWordConfirm->setPlaceholder('Veuillez confirmer votre mot de passe ici');


$title = "Inscription";
	$errors = [];
	$noErrors = true;
	$ok = 0;

	if (!empty($_GET)) {
		
		$pseudo = htmlspecialchars($_GET['pseudo']);
		$mail = htmlspecialchars($_GET['mail']);
		$mailConfirm = htmlspecialchars($_GET['mailConfirm']);
		$mdp = htmlspecialchars($_GET['mdp']);
		$mdpConfirm = htmlspecialchars($_GET['mdpConfirm']);

		$user = new Subscribe($pseudo, $mdp, $mail, $mailConfirm, $mdpConfirm);

		$validator = new SubscribeValidator($user);
		$errors = $validator->getUsersErrors();
		$noErrors = $validator->theyAreNotErrors();

		if ($noErrors) {
			$passwordHash = password_hash($mdp, PASSWORD_DEFAULT);
			$user->setMdp($passwordHash)
				 ->setMdpConfirm($passwordHash)
				 ->setID($user->insertUserIntoUsersTable());
				header('Location:'.$router->urlPut('Login'));
				exit();
			
		}
		
		
	}

?>
<div class="register-container">
	<h3 class="register-title">Inscription</h3>
	<form action="" class="w-100" method="">

		<?php 

			//GESTION DU PSEUDO
			$inputPseudo->errors = $errors['pseudo'] ?? '';
            if(isset($errors['pseudo']) AND $errors['pseudo'] !== null) {
                $inputPseudo->classListAdvanced = 'form-control border-danger is-invalid';
            }
            if(isset($pseudo) AND $errors !== []) {
                $inputPseudo->setValue($pseudo);
            }
            echo $inputPseudo->advancedSetInput();

            echo $inputPseudo->invalidCustomFeedBack($inputPseudo->errors);

            //GESTION DU MAIL
			$inputMail->errors = $errors['mail'] ?? '';
            if(isset($errors['mail']) AND $errors['mail'] !== null) {
                $inputMail->classListAdvanced = 'form-control border-danger is-invalid';
            }
            if(isset($mail) AND $errors !== []) {
                $inputMail->setValue($mail);
            }
            echo $inputMail->advancedSetInput();

            echo $inputMail->invalidCustomFeedBack($inputMail->errors);

            //GESTION DU MAIL_CONFIRM
			$inputMailConfirm->errors = $errors['mailConfirm'] ?? '';
            if(isset($errors['mailConfirm']) AND $errors['mailConfirm'] !== null) {
                $inputMailConfirm->classListAdvanced = 'form-control border-danger is-invalid';
            }
            if(isset($mail) AND $errors !== []) {
                $inputMailConfirm->setValue($mailConfirm);
            }
            echo $inputMailConfirm->advancedSetInput();

            echo $inputMailConfirm->invalidCustomFeedBack($inputMailConfirm->errors);


            //GESTION DU MOT DE PASSE
			$inputPassWord->errors = $errors['mdp'] ?? '';
            if(isset($errors['mdp']) AND $errors['mdp'] !== null) {
                $inputPassWord->classListAdvanced = 'form-control border-danger is-invalid';
            }
            if(isset($mdp) AND $errors !== []) {
                $inputPassWord->setValue($mdp);
            }
            echo $inputPassWord->advancedSetInput();

            echo $inputPassWord->invalidCustomFeedBack($inputPassWord->errors);



            //GESTION DU MOT DE PASSE CONFIRMATION
			$inputPassWordConfirm->errors = $errors['mdpConfirm'] ?? '';
            if(isset($errors['mdpConfirm']) AND $errors['mdpConfirm'] !== null) {
                $inputPassWordConfirm->classListAdvanced = 'form-control border-danger is-invalid';
            }
            if(isset($mdpConfirm) AND $errors !== []) {
                $inputPassWordConfirm->setValue($mdpConfirm);
            }
            echo $inputPassWordConfirm->advancedSetInput();

            echo $inputPassWordConfirm->invalidCustomFeedBack($inputPassWordConfirm->errors);
	
		?>
	<div class="subscribe-div">
		<button class="btn subscribe btn-register w-100">Valider</button>
	</div>
	</form>
	<p class="text-center m-auto login-linker">
		<a href="<?= $router->urlPut('Login') ?>" class="text-white" title="Se connecter">Je me suis déjà inscris</a>
	</p>
</div>
