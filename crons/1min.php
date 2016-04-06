<?php

require_once('/home/mhsa/includes/include.php');

foreach(DB::query("SELECT users.* FROM users ".MHSA_SQL_IS_ALIVE." AND ".MHSA_SQL_VALID_USER." AND users.text_eliminated > 0") as $user) {
    checkUserDeathTexts(true, $user['user_id']);
}

foreach(DB::query("SELECT users.* FROM users ".MHSA_SQL_IS_ALIVE." AND ".MHSA_SQL_VALID_USER." AND users.text_rip > 0") as $user) {
    checkUserDeathTexts(false, $user['user_id']);
}
