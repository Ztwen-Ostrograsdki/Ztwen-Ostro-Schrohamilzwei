<?php 


use Vincent\Categories\Categories;
use Vincent\Categories\SubCategories;
use Vincent\SqlRequests\Requestor;


if (isset($_GET['newCategory'])) {
	header("Location:".$router->urlPut('AddNewCategory'));
	exit();
}
$r = new Requestor(Categories::class);

$categories = $r->getContentsWithoutWhere("f_categories", "category");

$title = "Forum";
if (isset($_SESSION['id'])) {

?>
<form action="" class="d-inline float-right">
	<button class="btn d-inline-block mr-2 mb-2 btn-cat" name="newCategory" value="new">
		Créer une nouvelle catégory
	</button>
</form>
<?php } ?>
<table class="w-100 table-striped forum-table">
	<thead class="w-98 text-center">
		<th class="w-50">Categories</th>
		<th>Totals vues</th>
		<th>Dernier topic</th>
	</thead>
	<tbody class="w-98">
	<?php foreach($categories as $cat) {
		$subCategories = (new Requestor(SubCategories::class))->getContentsWithWhere("f_sub_categories", "id_category", $cat->getId(), "sub_category");
			$cat->setSlug($cat->getCategory())
				->addSubCategories();
	?>
		<tr class="w-100">
			<td class="w-70">
				<div class="p-0 m-0">
					<a href="<?= $router->urlPut('Categories', ['slug' => e($cat->getSlug()), 'id' => e($cat->getId())]) ?>" class="px-2 category-forum-title">
						<?= strtoupper($cat->getCategory())?>
					</a>
				</div>
				<?php foreach($subCategories as $subCat){ 
					$subCat->setSubSlug($subCat->getSubCategory())
						   ->setHisCategory();

						   $subSlug = $subCat->getSubSlug();
				?>
					<a href="<?= $router->urlPut('Topics', ['category' => e($subCat->getHisCategory()), 'slug' => $subSlug, 'id' => $subCat->getId()]) ?>" class="link-forum border px-2 py-1 d-inline-block subCat mb-1 ml-1">
						<span class="d-inline-block">
							<?= $subCat->getSubCategory() ?>
						</span>
					</a>
				<?php } ?>
			</td>
			<td style="width: 13%;" align="center">
				<a href="#" class="link-forum info-forum">
					<?= rand(10000, 600000) ?>
				</a>
			</td>
			<td align="center">
				<a href="#" class="link-forum info-forum">
					Publié par <?= Requestor::randomName()?> le
				 	<?= rand(1, 31) ?>/<?= rand(1, 12) ?>/<?= rand(18, 19) ?> <br>
					à <?= rand(10, 24)."h " .rand(10, 59)?>'
				</a>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
