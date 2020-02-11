<?php 

use Vincent\Auth\UrlAuth;
use Vincent\Categories\SubCategories;
use Vincent\SqlRequests\Requestor;
use Vincent\Topics\Topics;

$iconsPath = "/media/icons/";
$category = $params['category'];
$urlSlug = urldecode($params['slug']);
$urlID = (int)$params['id'];
$title = "listing des topics de la sous-catégorie $urlSlug";


$auth = new UrlAuth(SubCategories::class);

$auth->urlAuthenticatorSubCategory($category, $urlSlug, $urlID, $router);
$category = $params['category'];
$slug = $urlSlug;
$id = $urlID;

$r = new Requestor(Topics::class);

$topics = $r->getContentsWithWhere('f_topics', 'id_sub_category', $urlID, 'created_at');



 ?>

<div class="form-forum m-0 p-0">
	<form action="" class="d-inline float-right" title="Supprimer la sous-catégorie">
		<button class="btn d-inline-block mr-2 mb-2 btn-sub-cat" name="delete">
			<img src="<?= $iconsPath ?>delete3d.ico" alt="" width="22">
		</button>
	</form>
	<form action="" class="d-inline float-right" title="Editer la sous-catégorie">
		<button class="btn d-inline-block mr-2 mb-2 btn-sub-cat">
			<img src="<?= $iconsPath?>editor.png" alt="" width="22">
		</button>
	</form>
	<form action="<?= $router->urlPut('Topic_New', ['category' => $category, 'slug' => $slug, 'id' => $id]) ?>" class="d-inline float-right" title="Ajouter un topic">
		<button class="btn d-inline-block mr-2 mb-2 btn-sub-cat">
			<img src="<?= $iconsPath?>addblue.png" alt="" width="22">
		</button>
	</form>
</div>

<div class="m-0 p-0">
<p class="m-0 p-0 d-block">
	
</p>
	<table class="w-100 table-striped forum-table" >
		
		<thead class="w-98 text-center" style="font-size: 15px;">
			<th>No</th>
			<th>Les topics de la sous-catégorie : <?= $params['slug'] ?></th>
			<th style="min-width: 15%">Vues (reponses)</th>
			<th style="min-width: 25%">Infos</th>
		</thead>
		<tbody class="w-98">
		<?php $i = 0; foreach ($topics as $topic) {$topic->setDate()->setUser(); $i++;?>
			<tr class="w-100">
				<td>
					<div class="p-0 m-0 text-center text-white">
						<?= $i; ?>
					</div>
				</td>
				<td class="forum-sub-cat-content">
					<a href="<?= $router->urlPut('Topic_show', ['category' => $category, 'slug' => $slug, 'id' => $id, 'IDtopic' => e($topic->getId())]) ?>">
						<?= $topic->getContent() ?>
					</a>
				</td>
				<td style="width: 13%;" align="center">
					<a href="#" class="link-forum info-forum">
						<?= rand(10000, 600000) ?>
					</a>
				</td>
				<td align="center">
					<a href="#" class="link-forum info-forum">
						Publié par <?= ucfirst($topic->getUser()) ?>
						<br>
						<?= $topic->getDate(); ?>
					</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>

</div>