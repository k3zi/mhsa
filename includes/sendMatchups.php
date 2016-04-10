<?php
set_time_limit(0);
require_once(substr(getcwd(), 0, strpos(getcwd(), 'public_html')).'includes/include.php');
$users = DB::query('SELECT users.*, targetUsers.name as target, COUNT(k.kill_id) AS num_kills, (d.kill_id IS NOT NULL) AS dead, (s.kill_id IS NOT NULL) AS suicide FROM users '.SYSTEM_SQL_STATS_JOIN.' LEFT JOIN users targetUsers ON users.target_id = targetUsers.user_id WHERE '.SYSTEM_SQL_VALID_USER.' GROUP BY users.phone');

foreach ($users as $user) {
    $assassin = getAssassinForUserID($user['user_id']);
    echo $assassin['phone'].PHP_EOL;
    echo $user['phone'].PHP_EOL;
    try {
        sendUserMatch($assassin, $user);
    } catch (Exception $e) {
        print_r($e);
    }
}


?>
