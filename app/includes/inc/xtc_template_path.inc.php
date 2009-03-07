<?php

function xtc_template_fs_path($identifier)
{

    $l=split  ( '/'  , $identifier );

    if(count($l)<2)
    {
        die ('no identifier prefix in '.$identifier);    
    }

    if($l[0]=='default')
    {
        return DIR_FS_CATALOG.'/pub/templates/'.$l[1].'/';
    }
    else if($l[0]=='user')
    {
        return DIR_FS_USER.'templates/'.$l[1].'/';
    }
    else
    {
        die ('undefined identifier prefix'.$l[0]);
    }
}

function xtc_template_path($identifier)
{

    $l=split  ( '/'  , $identifier );

    if(count($l)<2)
    {
        die ('no identifier prefix in '.$identifier);    
    }

    if($l[0]=='default')
    {
        return '/pub/templates/'.$l[1].'/';
    }
    else if($l[0]=='user')
    {
        return '/user/templates/'.$l[1].'/';
    }
    else
    {
        die ('undefined identifier prefix'.$l[0]);
    }
}

?>
