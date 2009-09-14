<?php
    require ('includes/application_top.php');
    defined('_VALID_XTC') or die('Login required.');

    header ('content-type : text/x-json');

    function nextKey($field,$table,$arg=array()){
        global $db;
        $q=$db->prepare("select `$field` from $table");
        $q->execute($arg);
        $a=array();
        while($x=$q->fetch()){
            $a[$x[$field]]=true;
        }
        $m=1;
        while($a[$m]){
            ++$m;
        }
        return $m;
    }

    function arrayInsert($array,$pos,$val){
        $array2 = array_splice($array,$pos);
        $array[] = $val;
        $array = array_merge($array,$array2);
        return $array;
    }

    $RPC=array();

    require ('rpc/checkRemoteUrl.php');
    require ('rpc/asphyx.php');



    $commands=json_decode(file_get_contents("php://input"),true);
    $return = array();
    foreach ($commands as $cmd){
        $return []=f($cmd);
    }
    echo json_encode($return);

    function f($cmd){
        global $RPC;
        if(!$RPC[$cmd['command']]){
            return array ( 'success'=>false,'error'=>'unknown command');
        }
        try {
            return $RPC[$cmd['command']]['handler']($cmd);
        }
        catch (Exception $e){
            return array('success'=>false,'error'=>array('exception'=>$e->getMessage()));
        }
    }


?>
