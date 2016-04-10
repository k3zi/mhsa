<?php

require_once(substr(getcwd(), 0, strpos(getcwd(), 'public_html')).'includes/include.php');

foreach(DB::query("SELECT users.* FROM users ".SYSTEM_SQL_IS_ALIVE." AND ".SYSTEM_SQL_VALID_USER." AND users.text_eliminated > 0") as $user) {
    checkUserDeathTexts(true, $user['user_id']);
}

foreach(DB::query("SELECT users.* FROM users ".SYSTEM_SQL_IS_ALIVE." AND ".SYSTEM_SQL_VALID_USER." AND users.text_rip > 0") as $user) {
    checkUserDeathTexts(false, $user['user_id']);
}
