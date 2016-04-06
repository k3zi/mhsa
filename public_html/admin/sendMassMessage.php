<?php
set_time_limit(0);
require_once('/home/mhsa/includes/admin_include.php');

if (isset($_POST['text'])) {
    $message = $_POST['text'];
    foreach (DB::query('SELECT * FROM users WHERE is_blocked = 0 AND waiting_name = 0 AND LENGTH(phone) > 0') as $user) {
        try {
            singleSMS($user['phone'], $message);
        } catch (Exception $e) {
            print_r($e);
        }
    }
    header('Location: /admin/');
}

?>
