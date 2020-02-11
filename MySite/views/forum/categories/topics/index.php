<?php 

use Vincent\Auth\UrlAuth;
use Vincent\Categories\SubCategories;
use Vincent\Formator\Form;
use Vincent\SqlRequests\Requestor;
use Vincent\Topics\Answers\Answers;
use Vincent\Topics\Answers\AnswersGenerator;
use Vincent\Topics\Topics;

$title = "Lecture des reponses au topic et post de reponses";
$IDtopic = (int)$params['IDtopic'];
$IDsubCat = (int)$params['id'];
$subcategory = urldecode($params['slug']);
$category = urldecode($params['category']);

$auth = new UrlAuth(SubCategories::class);
$auth1 = $auth->urlAuthenticatorSubCategory($category, $subcategory, $IDsubCat, $router);

if (is_object($auth1)) {
	$auth2 = (new UrlAuth(Topics::class))->urlAuthenticatorTopics($IDtopic, $category, $subcategory, $IDsubCat, $router);
}

$r = new Requestor(Topics::class);
$topic = $r->getContentsWithWhere('f_topics', 'id', $IDtopic, 'id')[0];
$topic->setUser()->setDate();

$the_answers = (new Requestor(Answers::class))->getContentsWithWhere('f_topics_answers', 'id_topic', $IDtopic, 'answer_date');
 // INITIALISATION DU CHAMP DE REPONSES 
 // [*:category]/[*:slug]-[i:id]/topic-[i:IDtopic]
 
 if (isset($_POST['answer'])) {
 	if (isset($_SESSION['id'])) {
 		$answer = trim(htmlspecialchars($_POST['answer']));
	 	if (!empty($answer)) {
	 		$id_user = $_SESSION['id'];
	 		$answer = new AnswersGenerator($id_user, $IDtopic, $answer);
	 		$IDanswer = (int)$answer->addNewAnswer();
	 		$answer->setid($IDanswer);
	 		unset($_SESSION['existed_topic']);
	 		header('Location:'.$router->urlPut('Topic_show', ['category' => $category, 'slug' => $subcategory, 'id' => $IDsubCat, 'IDtopic' => $IDtopic]));
	 		exit();
	 	}
	 	else{
	 		$eror = "Veuillez renseillez votre réponse!";
	 	}
 	}
 	else{
 		if ($_POST['answer'] !== null || $_POST['answer'] !== '') {
 			$_SESSION['existed_topic'] = $_POST['answer'];
 		}
 		$eror = "Veuillez vous connecter <a href='".$router->urlPut('Login')."'> ici</a> d'abord avant d'effectuer cette requête!";
 	}
 	
}


?>

<div class="m-0 p-0 w-100 topics-container">
	<table class="w-100 table-striped forum-table" >
	<thead class="w-98 text-center" style="font-size: 15px;">
		<th>Ce topic est de la sous-catégorie : <?= $subcategory ." (".$category.")" ?></th>
	</thead>
		<tbody class="w-98">
			<tr class="">

				<td>
					<div class="w-100 forum-topic-content">
						<?= $topic->getContent() ?>
					</div>
					<div class="forum-topic-info-user">
						<span>Posté par : <?= $topic->getUser() ?>,</span>
						<span> Le <?= $topic->getDate() ?> </span>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	
	<div class="w-100 forum-topic-answers">
	<?php foreach ($the_answers as $the_answer) { $the_answer->setUser()->setFormattedDate(); ?>
		<div class="topic-answer">
			<div class="answer-user">
				<a href="#">
					<span id="profil">
						<img src="/media/users/default.jpg" alt="profil">
					</span>
					<span id="pseudo">
						<?= $the_answer->getUser(); ?>
					</span>
				</a>
				
			</div>
			<div class="answer-content">
				<?= $the_answer->getAnswer(); ?>
			</div>
			<div class="answer-date">
				<?= $the_answer->getFormattedDate(); ?>
			</div>
		</div>
		<?php } ?>
	</div>

	<div class="m-0 p-0 topics-textarea">
		<form action="" class="form-group addNow mt-2" method="post">
			<textarea name="answer" id="answer-topics" class=" <?php if(isset($eror) && !empty($eror)){ echo 'alert-erors'; } ?> " placeholder="Proposer une reponse..."><?php if(isset($_SESSION['existed_topic']) && $_SESSION['existed_topic'] !== '') { echo $_SESSION['existed_topic'];}?></textarea>
			<?php if (isset($eror)) {
				echo "<p class='p-0 m-0 alert-eror ml-2'>".$eror."</p>";
			} ?>
			<button type="submit" id="answer-btn" class="btn btn-cat mt-1 ml-1 w-25">Soumettre</button>
		</form>
	</div>
</div>


