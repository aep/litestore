<?php
    require_once (DIR_WS_CLASSES.'azrael.php');

    function module()
    {   
        global $azrael;
        return $azrael->renderPreset('Frontpage');
    }
?>
