<?php

require_once '/home/mhsa/includes/include.php';

$commandsResponse = array();
foreach ($MHSA_COMMANDS as $command => $info) {
    $commandsResponse[] = $command." - ".$info;
}
$commandsResponse = implode("\n\n", $commandsResponse);

function proccessAdminMessage($phone, $message, $name = "Not Registered") {
    global $MHSA_ADMIN_PHONES;

    $message = trim(substr($message, strpos($message, ':') + 1));
    foreach($MHSA_ADMIN_PHONES as $adminPhone) {
        singleSMS($adminPhone, $phone.' ('.$name.')'.":\n\n".$message);
    }
}

if (!isset($_REQUEST['MessageSid'])) {
    die();
}

$message = $twilio->account->messages->get($_REQUEST['MessageSid']);
if (!$message || $message->from == $message->to) {
    die();
}

$phone = substr(trim($message->from), -10);
$message = trim($message->body);

if ($user = getUserByPhone($phone)) {
    if (startsWith(strtoupper($message), 'MSG:')) {
        proccessAdminMessage($phone, $message, $user['name']);
        return singleSMS($phone, MHSA_RESPONSE_ADMIN_SENT);
    }

    if($user['waiting_name']) {
        if(strtoupper($message) == "WITHDRAW") {
            DB::delete('users', "user_id=%d", $user['user_id']);
            return singleSMS($phone, MHSA_RESPONSE_WITHDRAW);
        }

        $names = explode(" ", $message);
        if(count($names) < 2) {
            return singleSMS($phone, "Please enter a valid name.");
        } else {
            DB::update('users', array(
              'name' => $message,
              'waiting_name' => false
            ), 'user_id=%d', $user['user_id']);

            return singleSMS($phone, "Thanks! We have updated your name.");
        }
    }

    if($user['is_blocked']) {
        return singleSMS($phone, "Commands are disabled for blocked users");
    }

    switch (strtoupper($message)) {
      case 'CONFIRM':
        $response = MHSA_RESPONSE_ALREADY_CONFIRMED;
      break;

      case 'TOP':
        $response = MHSA_RESPONSE_COMMAND_NOT_AVAIL;
      break;

      case 'ELIMINATED':
        if (!MHSA_STARTED) {
            $response = MHSA_RESPONSE_COMMAND_NOT_AVAIL;
        } else if ($user['dead'] || $user['suicide']) {
            $response = MHSA_RESPONSE_ALREADY_DEAD;
        } else {
            userTextedDidEliminate($user);
        }
      break;

      case 'RIP':
        if (!MHSA_STARTED) {
            $response = MHSA_RESPONSE_COMMAND_NOT_AVAIL;
        } else if ($user['dead'] || $user['suicide']) {
            $response = MHSA_RESPONSE_ALREADY_DEAD;
        } else {
            userTextedWasAssassinated($user);
        }
      break;

      case 'SUICIDE':
        if (!MHSA_STARTED) {
            $response = MHSA_RESPONSE_COMMAND_NOT_AVAIL;
        } else if ($user['dead'] || $user['suicide']) {
            $response = MHSA_RESPONSE_ALREADY_DEAD;
        } else {
            userTextDidSuicide($user);
        }
      break;

      case 'STATUS':
        $response = '';
        $response .= "\n".'Name: '.$user['name'];
        if (MHSA_STARTED) {
            $response .= "\n".'Status: '.formatUserStatus($user);
            $response .= "\n"."Kills: ".$user['num_kills'];
        } else {
            $response .= "\n".'Status: Registered';
        }
      break;

      case 'TARGET':
        if (!MHSA_STARTED) {
            $response = MHSA_RESPONSE_COMMAND_NOT_AVAIL;
        } else {
            $target = getUser($user['target_id']);
            $response = 'Your target is: '.$target['name'];
        }
      break;

      case 'RANK':
        $response = MHSA_RESPONSE_COMMAND_NOT_AVAIL;
      break;

      case 'COMMANDS':
        $response = $commandsResponse;
      break;

      case 'WITHDRAW':
        if (!MHSA_STARTED) {
          DB::delete('users', "user_id=%d", $user['user_id']);
          $response = MHSA_RESPONSE_WITHDRAW;
        } else {
          $response = 'The game has already started. Withdraw has been replaced with suicide #WhatAWasteOfLife';
        }
      break;

      default:
        $response = MHSA_RESPONSE_INVALID_COMMAND;
      break;
    }
} else {
    if (startsWith(strtoupper($message), 'ALL:')) {
        if (in_array($phone, $MHSA_ADMIN_PHONES)) {
            $message = trim(substr($message, strpos($message, ':') + 1));
            foreach (DB::query('SELECT * FROM users WHERE is_blocked = 0 AND waiting_name = 0 AND LENGTH(phone) > 0') as $user) {
                try {
                    singleSMS($user['phone'], $message);
                } catch (Exception $e) {

                }
            }
        }
    } else if (startsWith(strtoupper($message), 'ALIVE:')) {
        if (in_array($phone, $MHSA_ADMIN_PHONES)) {
            $message = trim(substr($message, strpos($message, ':') + 1));
            foreach (DB::query("SELECT users.* FROM users ".MHSA_SQL_IS_ALIVE." AND ".MHSA_SQL_VALID_USER) as $user) {
                try {
                    singleSMS($user['phone'], $message);
                } catch (Exception $e) {

                }
            }
        }
    } else if (startsWith(strtoupper($message), 'MSG:')) {
        proccessAdminMessage($phone, $message);
    } else {
        switch (strtoupper($message)) {
          case 'COMMANDS':
            $response = $commandsResponse;
          break;

          default:
            $response = MHSA_RESPONSE_NO_ACCOUNT;
          break;
        }
    }
}

if ($response) {
    singleSMS($phone, $response);
}

?>
