<?php

class DB  extends PDO
{
    public function __construct($confcategory='database')
    {
        $file = DIR_FS_USER.'/db/db.ini';
        if (!$settings = parse_ini_file($file, TRUE)){ 
            throw new exception('Unable to open ' . $file . '.');
        }

        $dns='';       
        if($settings[$confcategory]['driver']=='sqlite')
        {
            if($settings[$confcategory]['file'][0]!='/')
            {
                $settings[$confcategory]['file']=DIR_FS_USER.'/db/'.$settings['database']['file'];
            }
            $dns = $settings[$confcategory]['driver'] . ':' . $settings['database']['file'];
        }
        else
        {
            $dns = $settings[$confcategory]['driver'] . ':host=' . $settings['database']['host'] . 
            ((!empty($settings[$confcategory]['port'])) ? (';port=' . $settings['database']['port']) : '') .
            ';dbname=' . $settings[$confcategory]['schema'];
        }
        
       
        parent::__construct($dns, $settings[$confcategory]['username'], $settings[$confcategory]['password']);

        $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }

}




global $db;
global $providerDb;
global $LitestoreDatabase;

if(!$db)
{
    $db= new DB;
    $LitestoreDatabase=$db;
}

if(!$providerDb)
{
    $file = DIR_FS_USER.'/db/db.ini';
    if (!$settings = parse_ini_file($file, TRUE)){ 
        throw new exception('Unable to open ' . $file . '.');
    }
    if($settings['provider']['driver']){
        $providerDb= new DB('provider');
    }
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
