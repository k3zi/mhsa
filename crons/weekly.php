<?php
require_once('/home/mhsa/includes/include.php');

//**************************************
//* Begin Cron
//**************************************

$users = getUnblockedUsers();
foreach($users as $user) {
    $fullName = trim($user['name']);
    $names = explode(" ", $fullName);

    $isValidUser = strlen($user['phone']) > 0;

    if($isValidUser) {
        if(count($names) < 2) {
            DB::update('users', array(
              'waiting_name' => true
            ), "user_id=%d", $user['user_id']);

            $message = "Hello ".$user['name']."! It seems you haven't entered your full name. This is your last chance. Respond within the next hour. For you to play Assassins, and for us to verify if your a senior, it is imperative that we have this.\n\nPlease respond with your first and last name. Otherwise respond with 'withdraw' to remove yourself from the game.";
            try {
                singleSMS($user['phone'], $message);
            } catch (Exception $e) {

            }
        }
    } else {
        $message = "Hello ".$user['name']."! It seems you haven't verrified your phone number. This is your last chance. Respond within the next hour. For you to play Assassins it is imperative that you confirm you phone number.\n\nPlease respond with CONFIRM to verify your phone number. Otherwise respond with 'withdraw' to remove yourself from the game.";
        try {
            singleSMS($user['unconfirmed_phone'], $message);
        } catch (Exception $e) {

        }
    }
}

?>
