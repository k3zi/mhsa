<?php
require_once('/home/mhsa/includes/include.php');

$top10 = array();
foreach($user in getTop10Players()) {
  $top10[] = array($user['name'].(strlen($user['twitter_name']) > 0 ? ' '.$user['twitter_name'] : ''), $user['num_kills'], $user['dead']);
}

 echo json_encode(array('registered_users' => getTotalNumberOfPlayers(), 'alive_players' => getNumberOfPlayersAlive(), 'dead_players' => getNumberOfPlayersDead(), 'suicides' => getNumberOfPlayersSuicide(), 'assassinations' => getNumberOfKills(), 'top10' => $top10));
?>
