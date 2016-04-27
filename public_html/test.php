<?php
require_once(substr(getcwd(), 0, strpos(getcwd(), 'public_html')).'includes/include.php');

echo unshorten_url('https://api.twilio.com/2010-04-01/Accounts/ACc1dce955d005655fe823e933ee1e75c7/Messages/MMfd5edbd031f225b7e03cae4b65dd3887/Media/MEef83b508c5fbb0c0ec28632dee5fb75b');
?>
