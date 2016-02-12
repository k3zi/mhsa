<?php
require_once('db.class.php');
require_once('vendor/autoload.php');
require_once('twilio-php/Twilio.php');

//DB Config
DB::$user = 'mhsa_admin';
DB::$password = 'y{KI(2Au8*HD;ai-p_';
DB::$dbName = 'mhsa_main';

//Twitter Config
use Abraham\TwitterOAuth\TwitterOAuth;
define('TWITTER_CONSUMER_KEY', '3l6iRylQn8FmrEnyeCC71Iz5B');
define('TWITTER_CONSUMER_SECRET', 'MCvESuOGmL2XqZnRhhD2F30gHp4uoAfp5XVY3BFPnW1eywXxZf');
define('TWITTER_ACCESS_TOKEN', '4755885121-9Y1MfzdMuhOBbxDICRuiHa8GrON5gAq2DUve6zj');
define('TWITTER_ACCESS_TOKEN_SECRET', 'kZlkhpPjN8pz3AOlzsChKKuZZRjsIHiOCGTsKYi4Cz7oM');
define('TWITTER_OAUTH_CALLBACK', 'https://mhsa.io/api/twitter_callback.php');
define('TWITTER_ID', 4755885121);

//Plivo Config
$twilio = new Services_Twilio('ACc1dce955d005655fe823e933ee1e75c7', '1c10c40f0b4a558232d8481205413411');
define('TWILIO_PHONE_NUMBER', '18172007256');

//Message Config
define('MHSA_CONFIRM_MESSAGE', "Martin Assassins:\n\nPlease text back CONFIRM to verify your registration and agreement to the rules set forth on: https://mhsa.io");
define('MHSA_RESPONSE_NEEDS_CONFIRM', "Text CONFIRM to verify your registration and agreement to the rules set forth on https://mhsa.io");
define('MHSA_RESPONSE_ALREADY_CONFIRMED', "This phone has already been confirmed.");
define('MHSA_RESPONSE_INVALID_COMMAND', "Invalid Command\n\nCheck on https://mhsa.io for text commands");
define('MHSA_RESPONSE_NO_ACCOUNT', "Martin Assassins\n\nThis phone isn't connected to an account.");

//Settings
define('MHSA_TIME_BETWEEN_COMMANDS', 60*5);

session_start();

//Fetch Functions
define('MHSA_SQL_VALID_USER', 'LENGTH(users.phone) > 0');
define('MHSA_SQL_IS_ALIVE', 'LEFT JOIN kills ON users.user_id = kills.eliminated WHERE kills.kill_id IS NULL');
define('MHSA_SQL_IS_NOT_ALIVE', 'LEFT JOIN kills ON users.user_id = kills.eliminated WHERE kills.kill_id IS NOT NULL');
define('MHSA_SQL_IS_SUICIDE', 'LEFT JOIN kills ON users.user_id = kills.eliminated WHERE kills.killer = kills.eliminated AND kills.kill_id IS NOT NULL');

function getAvailableAssassins() {
	return DB::query("SELECT users.* FROM users ".MHSA_SQL_IS_ALIVE." AND ".MHSA_SQL_VALID_USER." AND users.target_id = -1 ORDER BY RAND()");
}

function getAvailableAssassin() {
	return DB::queryFirstRow("SELECT users.* FROM users ".MHSA_SQL_IS_ALIVE." AND ".MHSA_SQL_VALID_USER." AND users.target_id = -1 ORDER BY RAND()");
}

function getUnavailableAssassin($user_id = -1) {
	return DB::queryFirstRow("SELECT users.* FROM users ".MHSA_SQL_IS_ALIVE." AND ".MHSA_SQL_VALID_USER." AND users.target_id != -1 AND users.target_id != %d AND users.user_id != %d ORDER BY RAND()", $user_id, $user_id);
}

function getAvailableTrget($user_id = 0) {
	if(getNumberOfPlayersAlive() == 2) {
		//DEATH MATCH: They can be each other's targets
		return DB::queryFirstRow("SELECT users.* FROM users ".MHSA_SQL_IS_ALIVE." AND ".MHSA_SQL_VALID_USER." AND user_id NOT IN (SELECT target_id FROM users ".MHSA_SQL_IS_ALIVE." AND ".MHSA_SQL_VALID_USER.") AND users.user_id != %d", $user_id);
	}

	return DB::queryFirstRow("SELECT users.* FROM users ".MHSA_SQL_IS_ALIVE." AND ".MHSA_SQL_VALID_USER." AND user_id NOT IN (SELECT target_id FROM users ".MHSA_SQL_IS_ALIVE." AND ".MHSA_SQL_VALID_USER.") AND users.user_id != %d AND users.target_id != %d ORDER BY RAND()", $user_id, $user_id);
}

function getAssassinForUser($user_id) {
	return DB::queryFirstRow("SELECT users.* FROM users WHERE users.target_id = %d", $user_id);
}

function getUser($user_id) {
	return DB::queryFirstRow("SELECT users.* FROM users WHERE users.user_id = %d", $user_id);
}

//Stats Function

function getNumberOfPlayersDead() {
	return DB::queryFirstField("SELECT COUNT(users.user_id) FROM users ".MHSA_SQL_IS_NOT_ALIVE." AND ".MHSA_SQL_VALID_USER);
}

function getNumberOfPlayersAlive() {
	return DB::queryFirstField("SELECT COUNT(users.user_id) FROM users ".MHSA_SQL_IS_ALIVE." AND ".MHSA_SQL_VALID_USER);
}

function getNumberOfPlayersSuicide() {
	return DB::queryFirstField("SELECT COUNT(users.user_id) FROM users ".MHSA_SQL_IS_SUICIDE." AND ".MHSA_SQL_VALID_USER);
}

function getNumberOfKills() {
	return DB::queryFirstField("SELECT COUNT(kill_id) FROM kills WHERE killer != eliminated");
}

function getTotalNumberOfPlayers() {
	return DB::queryFirstField("SELECT COUNT(users.user_id) FROM users WHERE phone != ''");
}

function getTop10Players($limit = 10) {
	$limit = $limit > 0 ? ' LIMIT '.$limit : '';
	return DB::query("SELECT users.name, users.twitter_name, COUNT(k.kill_id) AS num_kills, (d.kill_id IS NOT NULL) AS dead FROM users LEFT JOIN kills k ON users.user_id = k.killer LEFT JOIN kills d ON users.user_id = d.eliminated WHERE LENGTH(users.phone) > 0 GROUP BY users.phone ORDER BY num_kills DESC".$limit);
}

//Handle Text Respone

function userTextedWasAssassinated($user) {
	$time = time();
	DB::update('users', array(
	  'text_rip' => $time
	), "user_id=%d", $user['user_id']);
	$user['text_rip'] = $time;

	checkIfBothTexted();
}

function userTextedDidEliminate($user) {
	$time = time();
	DB::update('users', array(
	  'text_eliminated' => $time
	), "user_id=%d", $user['user_id']);
	$user['text_eliminated'] = $time;

	checkIfBothTexted();
}

function checkIfBothTexted() {
	$eliminatedUsers = DB::query("SELECT users.* FROM users WHERE users.text_rip != -1");

	for($i = 0; $i < count($eliminatedUsers); $i++) {
		$eliminated = $eliminatedUsers[$i];

		if($assassin = getAssassinForUser($eliminated['user_id'])) {
			if($assassin['text_eliminated'] > 0) {
				if(abs($eliminated['text_rip'] - $assassin['text_eliminated']) < MHSA_TIME_BETWEEN_COMMANDS) {
					DB::update('users', array(
					  'text_rip' => -1,
					  'target_id' => -1
					), "user_id=%d", $eliminated['user_id']);

					DB::update('users', array(
					  'text_eliminated' => -1,
					  'target_id' => -1
					), "user_id=%d", $assassin['user_id']);

					DB::insert('kills', array(
					  'eliminated' => $eliminated['user_id'],
					  'killer' => $assassin['user_id'],
						'time' => time()
					));

					if($match = performMatch($assassin)) {
						sendUserMatch($assassin, $match);
					}
				} else {
					DB::update('users', array(
					  'text_rip' => -1,
					), "user_id=%d", $eliminated['user_id']);

					DB::update('users', array(
					  'text_eliminated' => -1
					), "user_id=%d", $assassin['user_id']);

					echo '<br>'.'SEND --> '.$eliminated['name'].': Time Between Texts Was Too Long';
					echo '<br>'.'SEND --> '.$assasin['name'].': Time Between Texts Was Too Long';
				}
			} else if(abs(time() - $eliminated['text_rip']) > MHSA_TIME_BETWEEN_COMMANDS) {
				DB::update('users', array(
				  'text_rip' => -1
				), "user_id=%d", $eliminated['user_id']);

				echo '<br>'.'SEND --> '.$eliminated['name'].': Assassin Has Taken To Long';
			}
		}
	}

	$assassinUsers = DB::query("SELECT users.* FROM users WHERE users.text_eliminated != -1");

	for($i = 0; $i < count($assassinUsers); $i++) {
		$assassin = $assassinUsers[$i];
		if(abs(time() - $assassin['text_eliminated']) > MHSA_TIME_BETWEEN_COMMANDS) {
			DB::update('users', array(
			  'text_eliminated' => -1
			), "user_id=%d", $assassin['user_id']);

			echo '<br>'.'SEND --> '.$assassin['name'].': RIP Has Taken To Long';
		}
	}
}

function sendUserMatch($assassin, $match) {
	echo '<br>'.'SEND --> '.$assassin['name'].': You have been assigned: '.$match['name'];
	echo '<br>'.'CALL --> '.$match['phone'].':'.getRandomPrankCall();
}

//Execute Functions

function createAllMatches() {
	DB::update('users', array('target_id' => -1), "1");
	$assasins = getAvailableAssassins();

	$results = array();

	for($i = 0; $i < count($assasins); $i++) {
		$assasin = $assasins[$i];

		if($i == count($assasins) - 1) {
			$results[] = setUserDarget($assasin, $assasins[0], true);
		} else {
			$results[] = setUserDarget($assasin, $assasins[$i+1], true);
		}
	}

	return $results;
}

function createNeededMatches() {
	$assasins = getAvailableAssassins();
	$results = array();

	for($i = 0; $i < count($assasins); $i++) {
		$assasin = $assasins[$i];

		if($match = performMatch($assasin)) {
			$resuls[] = $match;
		}
	}

	return $resuls;
}

function setUserDarget($user, $match, $debug = false) {
	  DB::update('users', array(
		'target_id' => $match['user_id']
	  ), "user_id=%d", $user['user_id']);
	  return $debug ? ($user['name'].' ----> '.$match['name']) : $match;
}

function performMatch($user, $debug = false) {
	if($match = getAvailableTrget($user['user_id'])) {
		DB::update('users', array(
		  'target_id' => $match['user_id']
		), "user_id=%d", $user['user_id']);
		return $debug ? ($user['name'].' ----> '.$match['name']) : $match;
	}

	return false;
}

function performSwitchMatch($user) {
	$otherUser = getUnavailableAssassin($user['user_id']);
	$otherPersonsAssassins = getAssassinForUser($otherUser['user_id']);

	DB::update('users', array(
	  'target_id' => $user['user_id']
	), "user_id=%d", $otherPersonsAssassins['user_id']);

	DB::update('users', array(
	  'target_id' => $otherUser['user_id']
	), "user_id=%d", $user['user_id']);

	return array('SWITCH: '.$otherPersonsAssassins['name'].' ----> '.$user['name'], 'SWITCH: '.$user['name'].' ----> ('.$otherUser['name'].')');
}

//Plivo Functions

function singleSMS($to, $message) {
  global $twilio;

	return $twilio->account->messages->sendMessage(TWILIO_PHONE_NUMBER, $to, $message);
}

function massSMS($toArray, $message){
	foreach ($toArray as $to) {
		singleSMS($to, $message);
	}
}

function singleCall($to, $url) {
	global $twilio;

	return $twilio->account->calls->create(TWILIO_PHONE_NUMBER, $to, $url);
}

function getRandomPrankCall() {
	$responses = ['https://mhsa.io/api/johncena_response.xml', 'https://mhsa.io/api/taken_response.xml', 'https://mhsa.io/api/deeznuts_response.xml'];
	return $responses[array_rand($responses)];
}

//Social Functions
function autoFollow($oauth_token, $oauth_token_secret) {
	$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
    $friends = $connection->get('friends/ids', array('cursor' => -1));
	if (empty($friends->ids) or !in_array(TWITTER_ID, $friends->ids)) {
		return $connection->post('friendships/create', array('user_id' => TWITTER_ID, 'follow' => true));
	}

	return false;
}

function postToTwitter($message) {
	if(strlen($message) > 140) {
		return false;
	}

	$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_ACCESS_TOKEN, TWITTER_ACCESS_TOKEN_SECRET);
	return $connection->post("statuses/update", ['status' => $message]);
}
