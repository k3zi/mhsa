<?php
if (SYSTEM_STARTED) {
    die('The game has already started');
}

require_once(substr(getcwd(), 0, strpos(getcwd(), 'public_html')).'includes/include.php');

DB::delete('kills', "1");
createAllMatches();
