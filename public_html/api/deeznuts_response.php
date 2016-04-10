<?php
require_once(substr(getcwd(), 0, strpos(getcwd(), 'public_html')).'includes/config.php');

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
  <Pause length="2"/>
  <Say>Can you guess who your assassin is?</Say>
  <Say>They left a hint</Say>
  <Play><?php echo SYSTEM_SITE_URL; ?>/api/media/deeznuts.mp3</Play>
</Response>
