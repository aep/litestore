<?php

class DB  extends PDO
{
    public function __construct()
    {
        parent::__construct('sqlite:'.DIR_FS_USER.'/db/restore.db');
        $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }

}


global $db;

if(!$db)
    $db= new DB;



function xtc_db_query($expression)
{
    global $db;
    return $db->query($expression);
}


function xtc_db_fetch_array($bla)
{
    return $bla->fetch();
}



?>
