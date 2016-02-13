<?php
require_once('include.php');

if(!$isLogin && $_SESSION['admin'] != 'mhsa_admin') {
	header('Location: /');
	die();
} elseif ($isLogin && $_SESSION['admin'] == 'mhsa_admin') {
	header('Location: /admin/');
	die();
}

?>
