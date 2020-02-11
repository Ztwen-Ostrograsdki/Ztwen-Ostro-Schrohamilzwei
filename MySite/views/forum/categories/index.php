<?php

use Vincent\Categories\Categories;
use Vincent\Categories\SubCategories;
use Vincent\SqlRequests\Requestor;

$iconsPath = "/media/icons/";
$slug = (string)urldecode($params['slug']);
$id = (int)$params['id'];
$title = $slug;
$verify = ((new Requestor(Categories::class))->getContentsWithWhere("f_categories", "id", $id, "category"))[0];


$verify->setSlug($verify->getCategory());

$verified = Requestor::setEquals($verify->getSlug(), $slug);
if ($verified === false) {
	$match = null;
	exit();
}
$slug = $verify->getSlug();
$shows = (new Requestor(SubCategories::class))->getContentsWithWhere("f_sub_categories", "id_category", $id, "sub_category");

if (isset($_GET['newSubCategory'])) {
	header("Location:".$router->urlPut('AddNewSubCategory', ['slug' => e($slug), 'id' => $id]));
	exit();
}

if (isset($_GET['editCategory'])) {
	header("Location:".$router->urlPut('EditCategory', ['slug' => e($slug), 'id' => $id]));
	exit();
}

?>

<div class="form-forum m-0 p-0">
	<form action="<?= $router->urlPut('DeleteCategory', ['slug' => e($slug), 'id' => $id]) ?>" method="post" class="d-inline float-right" title="Supprimer la catégorie" onsubmit="return confirm('Voulez-vous vraiment supprimer cette categorie?')">
		<button class="btn d-inline-block mr-2 mb-2 btn-sub-cat" name="delete" value="new">
			<img src="<?= $iconsPath ?>delete3d.ico" alt="" width="22">
		</button>
	</form>
	<form action="" class="d-inline float-right">
		<button class="btn d-inline-block mr-2 mb-2 btn-sub-cat" name="newSubCategory" value="new">
			Créer une sous-catégorie
		</button>
	</form>
	<form action="" class="d-inline float-right" title="Editer la catégorie">
		<button class="btn d-inline-block mr-2 mb-2 btn-sub-cat" name="editCategory" value="new">
			<img src="<?= $iconsPath?>editor.png" alt="" width="22">
		</button>
	</form>
</div>
<table class="w-100 table-striped forum-table">
	<thead class="w-98 text-center">
		<th class="w-70">Sous-Categories dans <?= $slug ?></th>
		<th>Topics total</th>
		<th>Dernier topic</th>
	</thead>
	<tbody class="w-98">
	<?php foreach($shows as $show) {
		$show->setSubSlug($show->getSubCategory())
			 ->setHisCategory();
	?>
		<tr class="w-100">
			<td class="w-70">
				<div class="p-0 m-0 d-inline-block">
					<span class="px-2 category-forum-title">
						Section
					</span>
				</div>
				<a href="<?= $router->urlPut('Topics', ['category' => $slug, 'slug' => e($show->getSubSlug()), 'id' => $show->getId()])?>" class="link-forum border px-3 py-1 d-inline-block subCat mb-1 ml-1 w-25 text-center">
					<span class="d-inline-block">
						<?= $show->getSubCategory() ?>
					</span>
				</a>
			</td>
			<td style="width: 13%;" align="center">
				<a href="#" class="link-forum info-forum">
					<?= rand(10000, 600000) ?>
				</a>
			</td>
			<td align="center">
				<a href="#" class="link-forum info-forum">
					Publié par <?= Requestor::randomName()?> le
				 	<?= rand(1, 31) ?>/<?= rand(1, 12) ?>/<?= rand(18, 19) ?>
					à <?= rand(10, 24)."h " .rand(10, 59)?>'
				</a>	
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<div class="container mt-2 mb-1 p-2 forum-table last-topic">
	<p class="last-topic-title">
		Le dernier topic de la section <?= $slug ?> (sous-catégorie): 
	</p>
	<div class="container m-0 p-0">
		<p class="p-2 d-inline-block">
			<a href="#" class="last-topic-link">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim ipsa excepturi officiis facere aperiam nobis optio deserunt dolor, eum, voluptatem illo est at vero incidunt atque fugit labore nulla explicabo!
			</a>
		</p>	
		
		<p class="text-right">
			Publié par <?= Requestor::randomName()?>
			Le <?= rand(1, 31) ?>/<?= rand(1, 12) ?>/<?= rand(18, 19) ?>
			à <?= rand(10, 24)."h " .rand(10, 59)?>'
		</p>
	</div>
</div>

