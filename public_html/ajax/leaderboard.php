<?php
require_once('/home/mhsa/includes/include.php');

$leaderbaord = array();
foreach(getTop10Players(-1) as $user) {
  $leaderbaord[] = array($user['name'].(strlen($user['twitter_name']) > 0 ? ' (<a target="_blank" href="https://twitter.com/'.$user['twitter_name'].'">@'.$user['twitter_name'].'</a>)' : ''), $user['num_kills'], $user['dead']);
}

 echo json_encode(array('all' => $leaderbaord));
?>
