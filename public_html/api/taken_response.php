<?php header("content-type: text/xml"); ?>
<?xml version="1.0" encoding="utf-8"?>
<Response>
  <Pause length="2"/>
  <Say>Someone has been assigned to assassinate you</Say>
  <Say>They left a message</Say>
  <Play><?php echo SYSTEM_SITE_URL; ?>/api/media/taken.mp3</Play>
</Response>
