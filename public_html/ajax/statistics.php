<?php
require_once('/home/mhsa/includes/include.php');

$top10 = array();
foreach(getTop10Players() as $user) {
  $top10[] = array($user['name'].(strlen($user['twitter_name']) > 0 ? ' (<a target="_blank" href="https://twitter.com/'.$user['twitter_name'].'">@'.$user['twitter_name'].'</a>)' : ''), $user['num_kills'], $user['dead']);
}

 echo json_encode(array('registered_users' => getTotalNumberOfPlayers(), 'alive_players' => getNumberOfPlayersAlive(), 'dead_players' => getNumberOfPlayersDead(), 'suicides' => getNumberOfPlayersSuicide(), 'assassinations' => getNumberOfKills(), 'top10' => $top10));
?>
