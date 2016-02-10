<?php
// Copyright 2014 Peter Beverloo. All rights reserved.
// Use of this source code is governed by the MIT license, a copy of which can
// be found in the LICENSE file.

// -------------------------------------------------------------------------------------------------
// (1) This must be a GitHub PUSH message, indicating that a repository changed.
if (!isset ($_SERVER['HTTP_X_GITHUB_EVENT']))
    die('-1');
if ($_SERVER['HTTP_X_GITHUB_EVENT'] != 'push')
    die('-2');
// (2) This must be a GitHub request, with the entire contents signed.
if (!isset ($_SERVER['HTTP_X_HUB_SIGNATURE']))
    die('-3');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
if (strpos($signature, '=') == false)
    die('-4');
list($algorithm, $hash) = explode('=', $signature, 2);
$payload = file_get_contents('php://input');
if (hash_hmac($algorithm, $payload, "AH>3m<&f^d\2+/MP") != $hash)
    die('-5');
// -------------------------------------------------------------------------------------------------
$commands = [
    // Updates the local copy of the repository with the most recent remote changes.
    'git -C "/home/mhsa/" fetch --all',
    // Resets the repository to the state the remote currently is in.
    'git -C "/home/mhsa/" reset --hard origin/master',
];

foreach ($commands as $command)
    echo shell_exec($command);

echo "\ncomplete";
?>
