<?php
require_once('/home/mhsa/includes/admin_include.php');

if(isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    $user = DB::queryFirstRow('SELECT * FROM users WHERE user_id = %d', $userID);
    DB::update('users', array(
      'is_blocked' => true
    ), 'user_id=%d', $user['user_id']);
    $response = "You have been blocked for providing false information, not being a senior, or attempting to contaminate the game. If you think this has been done in error use 'MSG: ' to contact an admin";
    singleSMS(strlen($user['phone']) > 0 ? $user['phone'] : $user['unconfirmed_phone'], $response);
    header('Location: /admin/users');
}

?>
