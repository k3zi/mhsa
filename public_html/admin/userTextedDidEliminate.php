<?php
require_once('/home/mhsa/includes/admin_include.php');

if(isset($_GET['userID'])) {
    $userID = $_GET['userID'];
    if($user = getUser($userID)) {
        userTextedDidEliminate($user);
        header('Location: /admin/players');
    }
}

?>
