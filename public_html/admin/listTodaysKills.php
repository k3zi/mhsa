<?php

require_once('/home/mhsa/includes/admin_include.php');

$timestamp = time();
$beginOfDay = strtotime("midnight", $timestamp);
$endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;

foreach (DB::query('SELECT * FROM users LEFT JOIN kills ON users.user_id = kills.eliminated WHERE kills.kill_id IS NOT NULL AND kills.date >= %d AND kills.date <= %d AND '.SYSTEM_SQL_VALID_USER, $beginOfDay, $endOfDay) as $user) {
    echo $user['name'].'<br><br>';
}

?>
