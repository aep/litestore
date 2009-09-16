<?php
	require_once (DIR_WS_INCLUDES.'/asphyx/core.php');

    function module()
    {   
        global $azrael;
        return $azrael->renderPreset('Wellcome');
    }
?>
