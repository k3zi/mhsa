<?php
require_once('/home/mhsa/includes/admin_include.php');

if(isset($_GET['userID'])) {
    $userID = $_GET['userID'];
    $message = $_POST['text'];
    if($user = DB::queryFirstRow('SELECT * FROM users WHERE user_id = %d', $userID)) {
        singleSMS(strlen($user['phone']) > 0 ? $user['phone'] : $user['unconfirmed_phone'], $message);
    }
    header('Location: /admin/players');
}

?>
