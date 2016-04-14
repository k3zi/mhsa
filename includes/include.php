<?php
require_once('db.class.php');
require_once('vendor/autoload.php');
require_once('twilio-php/Twilio.php');
require_once('config.php');

use Abraham\TwitterOAuth\TwitterOAuth;

//Message Config
define('SYSTEM_CONFIRM_MESSAGE', SYSTEM_SITE_NAME.":\n\nPlease text back CONFIRM to verify your registration and agreement to the rules set forth on: ".SYSTEM_SITE_URL);
define('SYSTEM_RESPONSE_NEEDS_CONFIRM', "Text CONFIRM to verify your registration and agreement to the rules set forth on ".SYSTEM_SITE_URL);
define('SYSTEM_RESPONSE_ALREADY_CONFIRMED', "This phone has already been confirmed.");
define('SYSTEM_RESPONSE_COMMAND_NOT_AVAIL', "This command is not yet available.");
define('SYSTEM_RESPONSE_ALREADY_DEAD', "This command is only for active players. There is no resurrecting the dead #sorry");
define('SYSTEM_RESPONSE_INVALID_COMMAND', "Invalid Command\n\nCheck on ".SYSTEM_SITE_URL." for text commands.");
define('SYSTEM_RESPONSE_NO_ACCOUNT', "Martin Assassins\n\nThis phone isn't connected to an account.");
define('SYSTEM_RESPONSE_WITHDRAW', "You have been withdrawn.");
define('SYSTEM_RESPONSE_ADMIN_SENT', "Your message has been routed to an ".SYSTEM_SITE_NAME_SHORT." admin.");

define('SYSTEM_TIME_BETWEEN_COMMANDS', 60*5);
define('SYSTEM_START_DATE_STRING', 'April 4th, 2016 7:00 AM');
define('SYSTEM_STARTED', true);

//Setup Things

$twilio = new Services_Twilio(TWILIO_ACCOUNT_SID, TWILIO_TOKEN);

DB::$user = DB_USERNAME;
DB::$password = DB_PASSWORD;
DB::$dbName = DB_NAME;

$SYSTEM_COMMANDS = array(
	'eliminated' => 'text when you assassinate your enemy',
	'rip' => 'text when you are assassinated',
	'suicide' => 'text to remove yourself after the game has started',
	'msg: [message here]' => 'sends [message here] to the admins',
	'status' => 'text to get your info & stats in the game',
	'withdraw' => 'remove yourself from the game (only usable before the games starts)',
	'commands' => 'brings up the above commands'
);

session_start();

//Fetch Functions
define('SYSTEM_SQL_VALID_USER', 'users.is_blocked = 0 AND users.is_waiting = 0');
define('SYSTEM_SQL_IS_ALIVE', 'LEFT JOIN kills ON users.user_id = kills.eliminated WHERE kills.kill_id IS NULL');
define('SYSTEM_SQL_IS_NOT_ALIVE', 'LEFT JOIN kills ON users.user_id = kills.eliminated WHERE kills.kill_id IS NOT NULL');
define('SYSTEM_SQL_IS_SUICIDE', 'LEFT JOIN kills ON users.user_id = kills.eliminated WHERE kills.killer = kills.eliminated AND kills.kill_id IS NOT NULL');
define('SYSTEM_SQL_STATS_JOIN', 'LEFT JOIN kills k ON (users.user_id = k.killer AND k.eliminated != k.killer) LEFT JOIN kills d ON (users.user_id = d.eliminated AND d.eliminated != d.killer) LEFT JOIN kills s ON (users.user_id = s.eliminated AND s.eliminated = s.killer)');

$SYSTEM_NUM_PLAYERS_ALIVE = getNumberOfPlayersAlive();

function getUnblockedUsers() {
	return getAllPlayers();
}

function getAllPlayers() {
	return DB::query('SELECT * FROM users WHERE '.SYSTEM_SQL_VALID_USER);
}

function getAvailableAssassins() {
	return DB::query("SELECT users.* FROM users ".SYSTEM_SQL_IS_ALIVE." AND ".SYSTEM_SQL_VALID_USER." AND users.target_id = -1 ORDER BY RAND()");
}

function getAvailableAssassin() {
	return DB::queryFirstRow("SELECT users.* FROM users ".SYSTEM_SQL_IS_ALIVE." AND ".SYSTEM_SQL_VALID_USER." AND users.target_id = -1 ORDER BY RAND()");
}

function getUnavailableAssassin($user_id = -1) {
	return DB::queryFirstRow("SELECT users.* FROM users ".SYSTEM_SQL_IS_ALIVE." AND ".SYSTEM_SQL_VALID_USER." AND users.target_id != -1 AND users.target_id != %d AND users.user_id != %d ORDER BY RAND()", $user_id, $user_id);
}

function getAvailableTrget($user_id = 0) {
	if(getNumberOfPlayersAlive() == 2) {
		//DEATH MATCH: They can be each other's targets
		return DB::queryFirstRow("SELECT users.* FROM users ".SYSTEM_SQL_IS_ALIVE." AND ".SYSTEM_SQL_VALID_USER." AND user_id NOT IN (SELECT target_id FROM users ".SYSTEM_SQL_IS_ALIVE." AND ".SYSTEM_SQL_VALID_USER.") AND users.user_id != %d", $user_id);
	}

	return DB::queryFirstRow("SELECT users.* FROM users ".SYSTEM_SQL_IS_ALIVE." AND ".SYSTEM_SQL_VALID_USER." AND user_id NOT IN (SELECT target_id FROM users ".SYSTEM_SQL_IS_ALIVE." AND ".SYSTEM_SQL_VALID_USER.") AND users.user_id != %d AND users.target_id != %d ORDER BY RAND()", $user_id, $user_id);
}

function getWaitlistUser() {
	return DB::queryFirstRow("SELECT users.* FROM users WHERE users.is_waiting = 1");
}

function getAssassinForUserID($user_id) {
	return DB::queryFirstRow("SELECT users.* FROM users WHERE users.target_id = %d", $user_id);
}

function getUserByPhone($phone) {
	return DB::queryFirstRow('SELECT users.*, COUNT(k.kill_id) AS num_kills, (d.kill_id IS NOT NULL) AS dead, (s.kill_id IS NOT NULL) AS suicide FROM users '.SYSTEM_SQL_STATS_JOIN.' WHERE users.phone = %s GROUP BY users.phone', $phone);
}

function getUser($user_id) {
	return DB::queryFirstRow('SELECT users.*, COUNT(k.kill_id) AS num_kills, (d.kill_id IS NOT NULL) AS dead, (s.kill_id IS NOT NULL) AS suicide FROM users '.SYSTEM_SQL_STATS_JOIN.' WHERE users.user_id = %d GROUP BY users.phone', $user_id);
}

//Stats Function

function getNumberOfPlayersDead() {
	return DB::queryFirstField("SELECT COUNT(users.user_id) FROM users ".SYSTEM_SQL_IS_NOT_ALIVE." AND ".SYSTEM_SQL_VALID_USER);
}

function getNumberOfPlayersAlive() {
	return DB::queryFirstField("SELECT COUNT(users.user_id) FROM users ".SYSTEM_SQL_IS_ALIVE." AND ".SYSTEM_SQL_VALID_USER);
}

function getNumberOfPlayersSuicide() {
	return DB::queryFirstField("SELECT COUNT(users.user_id) FROM users ".SYSTEM_SQL_IS_SUICIDE." AND ".SYSTEM_SQL_VALID_USER);
}

function getNumberOfKills() {
	return DB::queryFirstField("SELECT COUNT(kill_id) FROM kills WHERE killer != eliminated AND eliminated != -1");
}

function getTotalNumberOfPlayers() {
	return DB::queryFirstField("SELECT COUNT(users.user_id) FROM users WHERE ".SYSTEM_SQL_VALID_USER);
}

function getTop10Players($limit = 10) {
	$limit = $limit > 0 ? ' LIMIT '.$limit : '';
	return DB::query('SELECT users.name, users.twitter_name, COUNT(k.kill_id) AS num_kills, (d.kill_id IS NOT NULL) AS dead, (s.kill_id IS NOT NULL) AS suicide FROM users '.SYSTEM_SQL_STATS_JOIN.' WHERE '.SYSTEM_SQL_VALID_USER.' GROUP BY users.phone ORDER BY dead ASC, suicide ASC, num_kills DESC'.$limit);
}

//Handle Text Response

function userTextDidSuicide($user) {
	log_text('ACTION --> '.$user['name'].' texted: suicide');
	$time = time();
	$target = getAssassinForUserID($user['user_id']);
	$assassin = getUser($user['target_id']);

	DB::update('users', array(
		'text_rip' => -1,
		'target_id' => -1,
		'text_eliminated' => -1
	), "user_id=%d", $user['user_id']);

	DB::insert('kills', array(
		'eliminated' => $user['user_id'],
		'killer' => $user['user_id'],
		'date' => $time
	));

	$message = formatUsername($user).' has commited suicide #'.getRandomDeathTag();
	log_text('TWEET --> '.$message);
	if (SYSTEM_STARTED) {
		postToTwitter($message);
	}

	if ($waitlist = getWaitlistUser()) {
		DB::update('users', array(
		  'target_id' => $waitlist['user_id']
	  ), "user_id=%d", $target['user_id']);

	   DB::update('users', array(
		  'target_id' => $user['target_id'],
		  'is_waiting' => false
	  ), "user_id=%d", $waitlist['user_id']);

		sendUserMatch($target, $waitlist);
		sendUserMatch($waitlist, $assassin);
	} else if ($match = performMatch($target)) {
		sendUserMatch($target, $match);
	} else {
		handleVictory($target);
	}
}

function userForceWithdraw($user) {
	log_text('ACTION --> '.$user['name'].' was withdrawn');
	$time = time();
	$target = getAssassinForUserID($user['user_id']);
	$assassin = getUser($user['target_id']);

	DB::update('users', array(
		'text_rip' => -1,
		'target_id' => -1,
		'text_eliminated' => -1
	), "user_id=%d", $user['user_id']);

	DB::insert('kills', array(
		'eliminated' => $user['user_id'],
		'killer' => $user['user_id'],
		'date' => $time
	));

	if ($waitlist = getWaitlistUser()) {
		DB::update('users', array(
		  'target_id' => $waitlist['user_id']
	  ), "user_id=%d", $target['user_id']);

	   DB::update('users', array(
		  'target_id' => $user['target_id'],
		  'is_waiting' => false
	  ), "user_id=%d", $waitlist['user_id']);

		sendUserMatch($target, $waitlist);
		sendUserMatch($waitlist, $assassin);
	} else if ($match = performMatch($target)) {
		sendUserMatch($target, $match);
	} else {
		handleVictory($target);
	}
}

function userTextedWasAssassinated($user) {
	log_text('ACTION --> '.$user['name'].' texted: rip');
	$time = time();
	DB::update('users', array(
	  'text_rip' => $time
	), "user_id=%d", $user['user_id']);

	checkUserDeathTexts(false, $user['user_id']);
}

function userTextedDidEliminate($user) {
	log_text('ACTION --> '.$user['name'].' texted: eliminated');
	$time = time();
	DB::update('users', array(
	  'text_eliminated' => $time
	), "user_id=%d", $user['user_id']);

	checkUserDeathTexts(true, $user['user_id']);
}

function checkUserDeathTexts($isAssassin, $userID) {
	if ($isAssassin) {
		$assassin = getUser($userID);
		$target = getUser($assassin['target_id']);
	} else {
		$target = getUser($userID);
		$assassin = getAssassinForUserID($userID);
	}

	$targetOfKilled = getUser($target['target_id']);

	$assassinTexted = false;
	$assassinTextedInTime = false;
	$targetTexted = false;
	$targetTextedInTime = false;

	$assassinTexted = $assassin['text_eliminated'] > 0;
	$assassinTextedInTime = $assassinTexted && (time() - $assassin['text_eliminated']) <= SYSTEM_TIME_BETWEEN_COMMANDS;
	$targetTexted = $target['text_rip'] > 0;
	$targetTextedInTime = $targetTexted && (time() - $target['text_rip']) <= SYSTEM_TIME_BETWEEN_COMMANDS;

	if ($assassinTextedInTime && $targetTextedInTime) {
		DB::update('users', array(
		  'text_rip' => -1,
		  'target_id' => -1
		), "user_id=%d", $target['user_id']);

		DB::update('users', array(
		  'text_eliminated' => -1,
		  'target_id' => -1
		), "user_id=%d", $assassin['user_id']);

		DB::insert('kills', array(
			'eliminated' => $target['user_id'],
			'killer' => $assassin['user_id'],
			'date' => time()
		));

		$message = formatUsername($assassin).' has assassinated '.formatUsername($target);
		log_text('TWEET --> '.$message);
		if (SYSTEM_STARTED) {
			postToTwitter($message, mediaURLForPhone($assassin['phone']));
		}

		if ($waitlist = getWaitlistUser()) {
			DB::update('users', array(
			  'target_id' => $waitlist['user_id']
		  ), "user_id=%d", $assassin['user_id']);

		   DB::update('users', array(
			  'target_id' => $targetOfKilled['user_id'],
			  'is_waiting' => false
		  ), "user_id=%d", $waitlist['user_id']);

			sendUserMatch($assassin, $waitlist);
			sendUserMatch($waitlist, $targetOfKilled);
		} else if ($match = performMatch($assassin)) {
			sendUserMatch($assassin, $match);
		} else {
			handleVictory($assassin);
		}
	} else if ($assassinTexted && $targetTexted) {
		DB::update('users', array(
		  'text_rip' => -1
		), "user_id=%d", $target['user_id']);

		DB::update('users', array(
		  'text_eliminated' => -1
		), "user_id=%d", $assassin['user_id']);

		$message = 'Time Between Texts Was Too Long';
		log_text('SEND --> '.$target['name'].': '.$message);
		log_text('SEND --> '.$assassin['name'].': '.$message);
		if (SYSTEM_STARTED) {
			singleSMS($target['phone'], $message);
			singleSMS($assassin['phone'], $message);
		}
	} else if ($assassinTexted && !$assassinTextedInTime) {
		DB::update('users', array(
		  'text_rip' => -1
		), "user_id=%d", $target['user_id']);

		DB::update('users', array(
		  'text_eliminated' => -1
		), "user_id=%d", $assassin['user_id']);

		$message = 'Your target did not text in time';
		log_text('SEND --> '.$assassin['name'].': '.$message);
	    if (SYSTEM_STARTED) {
	        singleSMS($assassin['phone'], $message);
	    }
	} else if ($targetTexted && !$targetTextedInTime) {
		DB::update('users', array(
		  'text_rip' => -1
		), "user_id=%d", $target['user_id']);

		DB::update('users', array(
		  'text_eliminated' => -1
		), "user_id=%d", $assassin['user_id']);

		$message = 'Your assassin did not text in time';
		log_text('SEND --> '.$target['name'].': '.$message);
		if (SYSTEM_STARTED) {
	        singleSMS($target['phone'], $message);
	    }
	}
}

function sendUserMatch($assassin, $match, $skipCall = false) {
	$randomUser = getUnavailableAssassin($match);
	$callLink = getPrankCallForUser($randomUser);

	log_text('SEND --> '.$assassin['name'].': You have been assigned: '.$match['name']);
	if (SYSTEM_STARTED) {
		singleSMS($assassin['phone'], 'You have been assigned: '.$match['name']);
		if (!$skipCall && $callLink && $randomUser) {
			singleCall($randomUser['phone'], $callLink);
		}
	}

	if (!$skipCall && $callLink && $randomUser) {
		log_text('CALL --> '.$randomUser['phone'].':'.$callLink);
	}
}

function handleVictory($user) {
	$message = 'Congratulations on winning '.SYSTEM_SITE_NAME.' '.SYSTEM_YEAR.'!';
	$twitterMessage = 'Congratulations '.formatUsername($user).' on winning '.SYSTEM_SITE_NAME.' '.SYSTEM_YEAR.'!';

	log_text('SEND --> '.$user['name'].': '.$twitterMessage);
	log_text('TWEET --> '.$twitterMessage);
	if (SYSTEM_STARTED) {
		singleSMS($user['phone'], $message);
		postToTwitter($twitterMessage);
	}
}

//Execute Functions

function createAllMatches() {
	DB::update('users', array('target_id' => -1), "1");
	$assassins = getAvailableAssassins();

	$results = array();

	for($i = 0; $i < count($assassins); $i++) {
		$assassin = $assassins[$i];

		if($i == count($assassins) - 1) {
			$results[] = setUserDarget($assassin, $assassins[0], true);
		} else {
			$results[] = setUserDarget($assassin, $assassins[$i+1], true);
		}
	}

	return $results;
}

function createNeededMatches() {
	$assassins = getAvailableAssassins();
	$results = array();

	for($i = 0; $i < count($assassins); $i++) {
		$assassin = $assassins[$i];

		if($match = performMatch($assassin)) {
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
	$otherPersonsAssassins = getAssassinForUserID($otherUser['user_id']);

	DB::update('users', array(
	  'target_id' => $user['user_id']
	), "user_id=%d", $otherPersonsAssassins['user_id']);

	DB::update('users', array(
	  'target_id' => $otherUser['user_id']
	), "user_id=%d", $user['user_id']);

	return array('SWITCH: '.$otherPersonsAssassins['name'].' ----> '.$user['name'], 'SWITCH: '.$user['name'].' ----> ('.$otherUser['name'].')');
}

//Plivo Functions

function singleSMS($to, $message, $mediaURL = null) {
  global $twilio;
  if($to == TWILIO_PHONE_NUMBER || $to == substr(TWILIO_PHONE_NUMBER, 0, -10)) return;

  if ($mediaURL) {
	  return $twilio->account->messages->sendMessage(TWILIO_PHONE_NUMBER, $to, $message, array($mediaURL));
  }

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

function getPrankCallForUser($user) {
	$responses = [SYSTEM_SITE_URL.'/api/johncena_response.php', SYSTEM_SITE_URL.'/api/taken_response.php', SYSTEM_SITE_URL.'/api/deeznuts_response.php'];
	$userPrankCallIndex = (int)$user['prank_call_index'];
	if ($userPrankCallIndex < count($responses)) {
		DB::update('users', array(
		  'prank_call_index' => ($userPrankCallIndex + 1)
		), "user_id=%d", $user['user_id']);

		return $responses[$userPrankCallIndex];
	}

	return false;
}

function getRandomDeathTag() {
	$responses = ['MaybeNextYear', 'WhatAWasteOfLife', 'KeepCalmAndKeepPlaying', 'YouBroughtThisOnYourself'];
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

function postToTwitter($message, $mediaURL = null) {
	$tag = str_replace(' ', '', SYSTEM_SITE_NAME.SYSTEM_YEAR);
	$message = $message.' #'.$tag;
	if (strlen($message) > 140) {
		return false;
	}

	$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_ACCESS_TOKEN, TWITTER_ACCESS_TOKEN_SECRET);
	$params = ['status' => $message];

	if ($mediaURL) {
		$media = $connection->upload('media/upload', ['media' => $mediaURL]);

		if ($media) {
			$params['media_ids'] = $media->media_id_string;
		}
	}

	return $connection->post("statuses/update", $params);
}

function checkAndStoreMedia($phone, $message, $user = null) {
	foreach ($message->media as $media) {
		$_SESSION['twilio_media'][$phone] = serialize($media);
		log_text('MEDIA: '.($user ? $user['name'] : $phone).' --> '.twilioURLForMedia($media));
    }
}

function mediaURLForPhone($phone) {
	if ($media = $_SESSION['twilio_media'][$phone]) {
		unset($_SESSION['twilio_media'][$phone]);
		if ($media = unserialize($media)) {
			return twilioURLForMedia($media);
		}
	}

	return false;
}

function twilioURLForMedia($media) {
	return 'https://api.twilio.com'.$media->uri;
}

//Helper Functions
function startsWith($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function formatUserStatus($user) {
	global $SYSTEM_NUM_PLAYERS_ALIVE;

	if ($user['dead']) {
		return 'Dead';
	}

	if ($user['suicide']) {
		return 'Suicide';
	}

	if ($SYSTEM_NUM_PLAYERS_ALIVE == 1) {
		return 'Winner';
	}

	return 'Alive';
}

function formatUsername($user) {
	$name = $user['name'];

	if (strlen($user['twitter_name']) > 0) {
		$name = '@'.$user['twitter_name'];
	}

	return $name;
}

function formatUsernameHTML($user) {
	$name = $user['name'];

	if (strlen($user['twitter_name']) > 0) {
		$name = $name.' (<a target="_blank" href="https://twitter.com/'.$user['twitter_name'].'">@'.$user['twitter_name'].'</a>)';
	}

	return $name;
}

function log_text($text) {
	$text = date('F j, Y @ G:i:s A').'  -  '.$text.PHP_EOL;
	file_put_contents(SYSTEM_LOG_FILE, $text , FILE_APPEND);
}
