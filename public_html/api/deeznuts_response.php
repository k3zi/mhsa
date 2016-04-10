<?php header("content-type: text/xml"); ?>
<?xml version="1.0" encoding="utf-8"?>
<Response>
  <Pause length="2"/>
  <Say>Can you guess who your assassin is?</Say>
  <Say>They left a hint</Say>
  <Play><?php echo SYSTEM_SITE_URL; ?>/api/media/deeznuts.mp3</Play>
</Response>
