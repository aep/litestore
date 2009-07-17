<?php

require_once('asphyx/category.php');
require_once('asphyx/product.php');
require_once('asphyx/product_image.php');
require_once('asphyx/root.php');
require_once('asphyx/content.php');

function rpc_asphyx ($cmd){
    global $RPC;
    if(!$RPC['asphyx'][$cmd['aclass']]){
        return array('success'=>false,'error'=>'Unknown entity');
    }
    return $RPC['asphyx'][$cmd['aclass']]($cmd);
}

$RPC['asphyx']['handler']=rpc_asphyx;


?>
