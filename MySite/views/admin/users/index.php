<?php

use Vincent\SqlRequests\Requestor;
use Vincent\Users\Users;

$title = "Listes des utilisateurs";

if (isset($_SESSION['id']) && $_SESSION['id'] == 1) {

	$r = new Requestor(Users::class);

	$users = $r->getContentsWithoutWhere("users", "pseudo");

	
?>


<div class="m-0 p-0 w-100 admin-users">
	<table class="table-table table-striped w-100">
		<thead class="text-center">
			<th>#ID</th>
			<th>Pseudo</th>
			<th>Email</th>
			<th>Subscribe date</th>
			<th>Action</th>
		</thead>
		<tbody class="text-center">
		<?php foreach ($users as $user) { $user->setFormattedDate()->thisUserWasBlocked(); ?>
			<tr class="">
				<td> <?= $user->getId(); ?></td>
				<td><?= $user->getPseudo(); ?></td>
				<td><?= $user->getEmail(); ?></td>
				<td><?= $user->getFormattedDate(); ?></td>
				<td>

				<?php if($user->getId() !== 1){ ?>
				<?php if($user->getBlockedStatus() == false){ ?>
					<form action="<?= $router->urlPut('UsersConfig', ['userID' => $user->getId(), 'action' => 'b']) ?>" class="d-inline" title= " Bloqué <?= $user->getPseudo(); ?> ?" >
						<button class="btn btn-action-secure">Blocked</button>
					</form>
				<?php } else{ ?>
					<form action="<?= $router->urlPut('UsersConfig', ['userID' => $user->getId(), 'action' => 'u']) ?>" class="d-inline" title= " Débloquer <?= $user->getPseudo(); ?> ?" >
						<button class="btn btn-action-secure">Unblocked</button>
					</form>
				<?php } ?>	
					<form action="<?= $router->urlPut('UsersConfig', ['userID' => $user->getId(), 'action' => 'd']) ?>" class="d-inline" title= " Retirer <?= $user->getPseudo(); ?> ?" >
						<button class="btn btn-action-remove">Remove</button>
					</form>
					<form action="" class="d-inline">
						<button class="btn btn-action-alert">Alert</button>
					</form>
				<?php } ?>	
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<?php }else{ $router->urlPut('Login');} ?>



