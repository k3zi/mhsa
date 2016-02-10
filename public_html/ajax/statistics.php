<?php
require_once('/home/mhsa/includes/include.php');

 echo json_encode(['registered_users': getTotalNumberOfPlayers(), 'alive_players': getNumberOfPlayersAlive(), 'dead_players': getNumberOfPlayersDead(), 'suicides': getNumberOfPlayersSuicide(), 'assassinations': getNumberOfKills()]);
//{"registered_users":"472","alive_players":"1","dead_players":471,"suicides":"56","assassinations":"427","top10":[["Nyssa Turner","27","1"],["Grant Jones","26","1"],["Josh Watson","20","1"],["Mackensie Bragg","10","1"],["Kyiva Faith","9","1"],["Chase Montgomery","9","1"],["Crystal Kim","9","1"],["Travis Murray","8","1"],["Darrien Murphy","8","1"],["Matt Brinegar","8","1"]]}
?>
