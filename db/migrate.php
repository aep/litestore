<?php


class DB  extends PDO
{
    public function __construct()
    {
        $file = $_SERVER['argv'][1];
        if (!$settings = parse_ini_file($file, TRUE))
            throw new exception('Unable to open ' . $file . '.');
       
        $dns = $settings['database']['driver'] . ':host=' . $settings['database']['host'] . 
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['schema'];
       
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);

        $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }

}


$db=new DB;

$current=0;

try
{
    $e=$db->query('select `db_version` from `system_meta`')->fetch();
    $current=$e['db_version'];
}
catch(PDOException $e)
{
}

echo 'database version detected as: '.$current."\n";



//using the opendir function
$dir_handle = @opendir('.') or die("Unable to open .");


$files=array();
//running the while loop
while ($file = readdir($dir_handle)) 
{
    $p = split('\\.',$file);
    if(array_key_exists(1,$p) && $p[1]=='sql')
    {
        $files[]=$file;
    }
}

sort($files);

foreach ($files as $file)
{
    $p = split('\\.',$file);

    if($p[0] <= $current)
        continue;

    echo "migrate ".$file."\n";
    $db->query(file_get_contents($file));

    $db->prepare("update `system_meta` set `db_version`=?")->execute(array($p[0]));
}

//closing the directory
closedir($dir_handle);





?>
