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

function endswith($Haystack, $Needle)
{
    return strrpos($Haystack, $Needle) === strlen($Haystack)-strlen($Needle);
}
function beginswith($string, $search)
{
    return (strncmp($string, $search, strlen($search)) == 0);
}



?>
