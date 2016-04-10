<?php
require_once('/home/mhsa/includes/config.php');

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

$hashAnswer = hash_hmac($algorithm, $payload, SYSTEM_GITHUB_HOOK_PASS);

if ($hashAnswer != $hash) {
    die('Algo: '.$algorithm."\n\n".$hashAnswer.'   !=   '.$hash);
}

// -------------------------------------------------------------------------------------------------

echo shell_exec("/usr/bin/git --git-dir '/home/mhsa/.git/' --work-tree '/home/mhsa/' fetch --all 2>&1");
echo shell_exec("/usr/bin/git --git-dir '/home/mhsa/.git/' --work-tree '/home/mhsa/' reset --hard origin/master 2>&1");
?>
