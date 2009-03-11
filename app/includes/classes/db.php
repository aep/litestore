<?php

class DB  extends PDO
{
    public function __construct()
    {
        $file = DIR_FS_USER.'/db/db.ini';
        if (!$settings = parse_ini_file($file, TRUE)) 
            throw new exception('Unable to open ' . $file . '.');
       
        $dns = $settings['database']['driver'] . ':host=' . $settings['database']['host'] . 
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['schema'];
       
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);

        $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }

}



global $db;
global $LitestoreDatabase;

if(!$db)
{
    $db= new DB;
    $LitestoreDatabase=$db;
}


function xtc_db_query($expression)
{
    global $LitestoreDatabase;
    return $LitestoreDatabase->query($expression);
}


function xtc_db_fetch_array($bla,$ignoreme=true)
{

    if(!is_object($bla))
    {
        if(is_array($bla))
        {
            return $bla;
        }
        else
        {
            throw new Exception ("unexpected parameter to xtc_db_fetch_array");
        }
    }
    return $bla->fetch();
}


function xtc_db_insert_id()
{
    global $LitestoreDatabase;
    return $LitestoreDatabase->lastInsertId();
}



?>
