<?php

require_once('asphyx/category.php');
require_once('asphyx/product.php');
require_once('asphyx/product_image.php');




function  rpc_checkRemoteUrl ($cmd){
    $ch=curl_init($cmd['url']);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);
    $retval=(curl_getinfo($ch,CURLINFO_HTTP_CODE)=='200');
    $reterr=curl_error($ch);
    return array('success'=>true,'value'=>$retval,'error'=>$reterr);
}


$RPC['checkRemoteUrl']['handler'] = rpc_checkRemoteUrl;

?>
