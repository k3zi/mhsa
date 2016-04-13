<?php
require_once('/home/mhsa/includes/admin_include.php');

if(isset($_GET['userID'])) {
    $userID = $_GET['userID'];
    $user = DB::queryFirstRow('SELECT * FROM users WHERE user_id = %d', $userID);

    DB::update('users', array(
      'waiting_name' => true
    ), "user_id=%d", $user['user_id']);

    $message = "Hello ".$user['name']."! It seems you haven't entered your full name. For you to play Assassins, and for us to verify if your a senior, it is imperative that we have this.\n\nPlease respond with your first and last name. Otherwise respond with 'withdraw' to remove yourself from the game.";
    singleSMS($user['phone'], $message);
    header('Location: /admin/users');
}

?>
