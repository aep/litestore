<?php
function pr($d)
{
	echo "<pre>";
	print_r($d);
	echo "</pre>";
}


function include_all_once ($pattern)
{
    foreach (glob($pattern) as $file) 
    {
        include $file;
    }
}

?>
