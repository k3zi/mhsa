<?php
require_once('/home/mhsa/includes/include.php');

/*

Conditionals

1. If your target is killed by someone else

*/

function runSimulation() {
	while($assassin = getUnavailableAssassin()) {
		$eliminated = getUser($assassin['target_id']);
		echo '<br><br><br>';
		
		echo 'ACTION: '.$assassin['name'].' killed '.$eliminated['name'];
		userTextedWasAssassinated($eliminated);
		userTextedDidEliminate($assassin);
	}
	
	echo '<br><br><br>';
	$user = getAvailableTrget();
	echo 'Simulation Complete'.'<br>';
	echo $user['name'].' Wins!';
}

$spacer = "<br><br><br>";

echo '<h1>Running Tests</h1><br><br>';

echo '1. Test Get Available Target:'.'<br>';
echo("<pre>".print_r(getAvailableTrget(), true)."</pre>");

echo $spacer;

echo '2. Test Get Available Assassin:'.'<br>';
echo("<pre>".print_r(getAvailableAssassin(), true)."</pre>");
/echo '3. Test Call:'.'<br>';
echo("<pre>".print_r(singleCall('8177297784', "https://mhsa.io/api/johncena_response.xml"), true)."</pre>");

echo $spacer;

echo '<h1>Running Simulation</h1><br><br>';

echo '1. Removing All Kills'.'<br>';
echo("<pre>".print_r(DB::delete('kills', "1"), true)."</pre>");

echo '2. Create Matchups:'.'<br>';
createAllMatches();
echo '<pre>';
foreach(DB::query("SELECT users.name, targetUsers.name as target FROM users LEFT JOIN users targetUsers ON users.target_id = targetUsers.user_id WHERE LENGTH(users.phone) > 0") as $user) {
	echo $user['name'].' -----> '.$user['target'].'<br>';
}
echo '</pre>';

runSimulation();
