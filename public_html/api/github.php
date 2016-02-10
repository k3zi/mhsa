<?php
// Copyright 2014 Peter Beverloo. All rights reserved.
// Use of this source code is governed by the MIT license, a copy of which can
// be found in the LICENSE file.

if (!isset ($_SERVER['HTTP_X_GITHUB_EVENT']))
    die('-1');
if ($_SERVER['HTTP_X_GITHUB_EVENT'] != 'push')
    die('-2');
if (!isset ($_SERVER['HTTP_X_HUB_SIGNATURE']))
    die('-3');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
if (strpos($signature, '=') == false)
    die('-4');
list($algorithm, $hash) = explode('=', $signature, 2);
$payload = file_get_contents('php://input');
if (hash_hmac($algorithm, $payload, '8b21ebc436b7c5c7fe54953c0553ab9a') != $hash)
    die('Algo: '.$algorithm."\n\n".hash_hmac($algorithm, $payload, '8b21ebc436b7c5c7fe54953c0553ab9a').'   !=   '.$hash);
// -------------------------------------------------------------------------------------------------

echo shell_exec("/usr/bin/git --git-dir '/home/mhsa/.git/' --work-tree '/home/mhsa/' fetch --all 2>&1");
echo shell_exec("/usr/bin/git --git-dir '/home/mhsa/.git/' --work-tree '/home/mhsa/' reset --hard origin/master 2>&1");
?>
