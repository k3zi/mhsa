<?php
require_once('include.php');

if(!$isLogin && $_SESSION['admin'] != 'system_admin') {
	header('Location: /admin/login');
	die();
} elseif ($isLogin && $_SESSION['admin'] == 'system_admin') {
	header('Location: /admin/');
	die();
}

function getKillsPerDay($days = 15) {
	return DB::query("SELECT FROM_UNIXTIME(`date`, '%D %M, %Y') AS group_date, count(`kill_id`) AS kills FROM kills WHERE date > %d GROUP BY group_date", $days*24*60*60);
}
?>
