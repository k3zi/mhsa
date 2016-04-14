<?php

require_once(substr(getcwd(), 0, strpos(getcwd(), 'public_html')).'includes/include.php');

function proccessAdminMessage($phone, $message, $name = "Not Registered", $media = null) {
    global $SYSTEM_ADMIN_PHONES;

    $message = trim(substr($message, strpos($message, ':') + 1));
    $media = mediaURLForPhone($phone);

    foreach ($SYSTEM_ADMIN_PHONES as $adminPhone) {
        singleSMS($adminPhone, $phone.' ('.$name.')'.":\n\n".$message, $media);
    }
}

if (!isset($_REQUEST['MessageSid'])) {
    die();
}

$sms = $twilio->account->messages->get($_REQUEST['MessageSid']);
if (!$sms || $sms->from == $sms->to) {
    die();
}

$phone = substr(trim($sms->from), -10);
$message = trim($sms->body);

if ($user = getUserByPhone($phone)) {
    $didStoreMedia = checkAndStoreMedia($phone, $sms, $user);

    if (startsWith(strtoupper($message), 'MSG:')) {
        proccessAdminMessage($phone, $message, $user['name']);
        return singleSMS($phone, SYSTEM_RESPONSE_ADMIN_SENT);
    }

    if ($user['waiting_name']) {
        if(strtoupper($message) == "WITHDRAW") {
            DB::delete('users', "user_id=%d", $user['user_id']);
            return singleSMS($phone, SYSTEM_RESPONSE_WITHDRAW);
        }

        $names = explode(" ", $message);
        if (count($names) < 2) {
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
        $response = SYSTEM_RESPONSE_ALREADY_CONFIRMED;
      break;

      case 'TOP':
        $response = SYSTEM_RESPONSE_COMMAND_NOT_AVAIL;
      break;

      case 'ELIMINATED':
        if (!SYSTEM_STARTED) {
            $response = SYSTEM_RESPONSE_COMMAND_NOT_AVAIL;
        } else if ($user['dead'] || $user['suicide']) {
            $response = SYSTEM_RESPONSE_ALREADY_DEAD;
        } else {
            userTextedDidEliminate($user);
        }
      break;

      case 'RIP':
        if (!SYSTEM_STARTED) {
            $response = SYSTEM_RESPONSE_COMMAND_NOT_AVAIL;
        } else if ($user['dead'] || $user['suicide']) {
            $response = SYSTEM_RESPONSE_ALREADY_DEAD;
        } else {
            userTextedWasAssassinated($user);
        }
      break;

      case 'SUICIDE':
        if (!SYSTEM_STARTED) {
            $response = SYSTEM_RESPONSE_COMMAND_NOT_AVAIL;
        } else if ($user['dead'] || $user['suicide']) {
            $response = SYSTEM_RESPONSE_ALREADY_DEAD;
        } else {
            userTextDidSuicide($user);
        }
      break;

      case 'STATUS':
        $response = '';
        $response .= "\n".'Name: '.$user['name'];
        if (SYSTEM_STARTED) {
            $response .= "\n".'Status: '.formatUserStatus($user);
            $response .= "\n"."Kills: ".$user['num_kills'];
        } else {
            $response .= "\n".'Status: Registered';
        }
      break;

      case 'TARGET':
        if (!SYSTEM_STARTED) {
            $response = SYSTEM_RESPONSE_COMMAND_NOT_AVAIL;
        } else {
            $target = getUser($user['target_id']);
            $response = 'Your target is: '.$target['name'];
        }
      break;

      case 'RANK':
        $response = SYSTEM_RESPONSE_COMMAND_NOT_AVAIL;
      break;

      case 'COMMANDS':
        $response = getTextCommands();
      break;

      case 'WITHDRAW':
        if (!SYSTEM_STARTED) {
          DB::delete('users', "user_id=%d", $user['user_id']);
          $response = SYSTEM_RESPONSE_WITHDRAW;
        } else {
          $response = 'The game has already started. Withdraw has been replaced with suicide #WhatAWasteOfLife';
        }
      break;

      default:
      if (!$didStoreMedia) {
        $response = SYSTEM_RESPONSE_INVALID_COMMAND;
      }
      break;
    }
} else {
    $didStoreMedia = checkAndStoreMedia($phone, $sms);

    if (startsWith(strtoupper($message), 'ALL:')) {
        if (in_array($phone, $SYSTEM_ADMIN_PHONES)) {
            $message = trim(substr($message, strpos($message, ':') + 1));
            foreach (DB::query('SELECT * FROM users WHERE is_blocked = 0 AND waiting_name = 0 AND LENGTH(phone) > 0') as $user) {
                try {
                    singleSMS($user['phone'], $message);
                } catch (Exception $e) {

                }
            }
        }
    } else if (startsWith(strtoupper($message), 'ALIVE:')) {
        if (in_array($phone, $SYSTEM_ADMIN_PHONES)) {
            $message = trim(substr($message, strpos($message, ':') + 1));
            foreach (DB::query("SELECT users.* FROM users ".SYSTEM_SQL_IS_ALIVE." AND ".SYSTEM_SQL_VALID_USER) as $user) {
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
            $response = getTextCommands();
          break;

          default:
          if (!$didStoreMedia) {
            $response = SYSTEM_RESPONSE_NO_ACCOUNT;
          }
          break;
        }
    }
}

if ($response) {
    singleSMS($phone, $response);
}

?>
