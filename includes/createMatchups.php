<?php
require_once('/home/mhsa/includes/include.php');

DB::delete('kills', "1");
createAllMatches();
