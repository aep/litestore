<?php require('includes/application_top.php'); ?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<h1>Datei Manager</h1>
<?php

    $startDir = DIR_FS_CATALOG."../";
    include(DIR_WS_INCLUDES . 'fm/filemanager.inc.php'); 
?>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>