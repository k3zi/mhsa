<?php
require_once('/home/mhsa/includes/include.php');

if(isset($_REQUEST['From'])){
  $phone = substr(trim($_REQUEST['From']), -10);
  $message = trim($_REQUEST['Body']);

  if($user = DB::queryFirstRow("SELECT * FROM users WHERE unconfirmed_phone = %s", $phone)) {
    if(strtoupper($message) == 'CONFIRM') {
      $dupUser = DB::queryFirstRow("SELECT * FROM users WHERE phone = %s", $phone);
      if($dupUser) {
        $response = "A user has already been confirmed with this phone number";
      } else {
        $response = "Martin Assassins | Confirmation\nHi ".$user['name']."! You are now signed up for Martin Assassins 2016. May the odds be ever in your favor!\n\nhttps://mhsa.io";
          DB::update('users', array(
            'phone' => $user['unconfirmed_phone'],
            'unconfirmed_phone' => ''
          ), "user_id=%d", $user['user_id']);
        }
      } else {
        $response = MHSA_RESPONSE_NEEDS_CONFIRM;
        }
      } else if($user = DB::queryFirstRow("SELECT * FROM users WHERE phone = %s", $phone)) {
        switch(strtoupper($message)) {
          case "CONFIRM":
          $response = MHSA_RESPONSE_ALREADY_CONFIRMED;
          break;

          default:
          $response = MHSA_RESPONSE_INVALID_COMMAND;
          break;
        }
      } else {
        $response = MHSA_RESPONSE_NO_ACCOUNT;
      }
    }

    if($response){
      singleSMS($phone, $response);
    }
