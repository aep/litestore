<?php

class TemplateFsException extends Exception
{
}


function xtc_template_fs_path($identifier)
{

    $l=split  ( '/'  , $identifier );

    if(count($l)<2)
    {
        throw new TemplateFsException  ('no identifier prefix in identifier "'.$identifier.'"');    
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
              throw  new TemplateFsException  ('undefined identifier prefix'.$l[0]);
    }
}

function xtc_template_path($identifier)
{

    $l=split  ( '/'  , $identifier );

    if(count($l)<2)
    {
        throw new TemplateFsException  ('no identifier prefix in identifier "'.$identifier.'"');    
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
        throw new TemplateFsException ('undefined identifier prefix'.$l[0]);
    }
}

?>
