<?php header("content-type: text/xml"); ?>
<?xml version="1.0" encoding="utf-8"?>
<Response>
  <Pause length="2"/>
  <Say>An assassin is after you</Say>
  <Play><?php echo SYSTEM_SITE_URL; ?>/api/media/johncena.mp3</Play>
</Response>
