<?php

use Vincent\Security\Security;
use Vincent\SqlRequests\Requestor;
	
if (isset($_SESSION['id']) && $_SESSION['id'] == 1) {
	dump($params);
	if (isset($params['userID'], $params['action']) && ($params['userID'] !== null && $params['action'] !== null)){
		$id = (int)$params['userID'];
		$action = $params['action'];

		$userTargetedID = (int)Requestor::getContentWithWhere('id', 'users', 'id', $id);
		if ($userTargetedID !== 0 && $userTargetedID !== null) {
			$address = Requestor::getContentWithWhere('email', 'users', 'id', $id);
			if ($action === 'b') {
				$b = Security::forcedBlocked($id, $address);
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			elseif ($action === 'u') {
				$b = Security::unBlockedThisUser($id, $address);
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			elseif ($action === 'd') {
				$b = Security::removeThisUser($id, $address);
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
		}
		else{
			$params = [];
		}
	}else{
		header('Location:'.$_SERVER['HTTP_REFERER']);
	}

}else{
	header('Location:'.$router->urlPut('Login'));
		
}	