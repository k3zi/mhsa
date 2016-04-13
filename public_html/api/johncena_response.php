<?php
require_once(substr(getcwd(), 0, strpos(getcwd(), 'public_html')).'includes/config.php');

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>

<Response>
  <Pause length="2"/>
  <Say>An assassin is after you</Say>
  <Play><?php echo SYSTEM_SITE_URL; ?>/api/media/johncena.mp3</Play>
</Response>
