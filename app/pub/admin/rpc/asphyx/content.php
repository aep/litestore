<?php
function rpc_asphyx_content($cmd){
    global $db;

    if($cmd['action']=='list'){
        $q=$db->prepare('SELECT id, parent, uuid, name, `order` FROM `content` where `parent`=? order by `order` ASC');
        $q->execute(array($cmd['data']['id']));
        $nodes=array();

        while($row=$q->fetch()){
            $node=array();
            $qc=$db->prepare('SELECT COUNT(*)  FROM `content` where `parent`=? ');
            $qc->execute(array($row['id']));
            $qc=$qc->fetch();
            $qc=$qc['COUNT(*)'];

            $node['text']		= $row['name'];
            $node['position']	= $row['order'];    
            $node['leaf']	    = (bool)($qc<1);
            $node['aclass']	    = $row['uuid'];
            $node['data']	    = array('id'=>$row['id']);

            if($node['aclass']	    == 'com.asgaartech.asphyx.preset'){
                $node['caps']       = array (
                    'move'  =>false,
                    'write' =>false,
                    'read'  =>true,
                );
            }

            $nodes[]=$node;
        }
        return array('success'=>true,'value'=>$nodes);
    }
    else if($cmd['action']=='get'){
        $q=$db->prepare('SELECT name, data FROM `content` where `id`=?');
        $q->execute(array($cmd['data']['id']));
        $nodes=array();
        $x=$q->fetchObject();

        if($cmd['aclass']=='com.asgaartech.asphyx.conditional.customergroup'){
            $x->cgroups=array();
            $q=$db->prepare('select customers_status_id,customers_status_name from customers_status');  
            $q->execute();
            while ($g=$q->fetch()){
                $x->cgroups[]=array('cid'=>$g['customers_status_id'],'name'=>$g['customers_status_name']);
            }
        }
        return array('success'=>true,'value'=>$x);
    }
    else if($cmd['action']=='set'){
        if($cmd['data']['id']==1 || $cmd['data']['id']==0 )
            return array('success'=>false,'error'=>'access violation'); 
        $q=$db->prepare('update content set name=?, data=? where `id`=?');
        $q->execute(array(
            $cmd['data']['name'],
            $cmd['data']['data'],
            $cmd['data']['id']
        ));
        return array('success'=>true,'value'=>true);
    }
    else if($cmd['action']=='create'){
        
        $q=$db->prepare('insert into content (`name`,`order`,`uuid`,`parent`) values (?,?,?,?)');
        $okey=nextKey('order','content where `parent`=?',array($cmd['parent']['id']));
        $q->execute(array($cmd['name'],$okey,$cmd['aclass'],$cmd['parent']['id']));
        $liid=$db->lastInsertId();

        $retval=array();
        $retval['text']		= $cmd['name'];
        $retval['id']	    = $liid;
        $retval['data']     = array('id'=>$liid);
        $retval['leaf']	    = false;
        $retval['aclass']	= $cmd['aclass'];

        if($liid)
            return array('success'=>true,'value'=>$retval);
        else
            return array('success'=>false,'error'=>'cannot get inserted id');
    }
    else if($cmd['action']=='delete'){
        if($cmd['data']['id']==1 || $cmd['data']['id']==0 )
            return array('success'=>false,'error'=>'access violation'); 

        function d_p($p){
            global $db;
            $q=$db->prepare('SELECT `id` from `content` where `parent`=?');
            $q->execute(array($p));
            while($row=$q->fetch()){        
                d_p($row['id']);
            }
            $q=$db->prepare('delete from `content` where `id`=?');
            $q->execute(array($p));            
        }
        d_p($cmd['data']['id']);
        return array('success'=>true,'value'=>true);
    }
    else if ($cmd['action']=='move' || $cmd['action']=='copy'){
        if($cmd['subject']['id']==1 || $cmd['subject']['id']==0 )
            return array('success'=>false,'error'=>'access violation'); 

        $db->beginTransaction();
        if ($cmd['action']=='copy'){
            //make a copy of this, with different id
            $q=$db->prepare('select *  from `content` where id=?'); 
            $q->execute(array($cmd['subject']['id']));
            $x=$q->fetchObject();
            
            $keys=array();
            $qvals=array();
            $vals=array();

            foreach($x as $k=>$v){  
                if($k == 'id'){
                    continue;
                }
                $keys[]='`'.$k.'`';
                $qvals[]='?';
                $vals[]=$v;
            }

            $q=$db->prepare('insert into  `content` ('.implode(',',$keys).') values ('.implode(',',$qvals).')');
            $q->execute($vals);                    

            $newcopy=$db->lastInsertId();
            $cmd['subject']['id']=$newcopy;
        }

        //build sorted array of items in the new parent excluding subject

        $q=$db->prepare('select `id` from `content`  where `parent`=? order by `order`'); 
        $q->execute(array($cmd['parentNew']['id']));
        $m=array();
        while($x=$q->fetch()){  
            if($x['id']==$cmd['subject']['id'])
                continue;
            $m[]=$x['id'];
        }

        //stuff it in
        if($cmd['relative']=='append'){
            $m[]=$cmd['subject']['id'];
        }
        else if($cmd['relative']=='below' ){
            $m=arrayInsert($m,array_search($cmd['relativeTo']['id'],$m)+1,$cmd['subject']['id']);
        }
        else if($cmd['relative']=='above'){
            $m=arrayInsert($m,array_search($cmd['relativeTo']['id'],$m),$cmd['subject']['id']);
        }

        $q=$db->prepare('update `content` set `parent`=? where `id`=?'); 
        $q->execute(array(
                $cmd['parentNew']['id'],
                $cmd['subject']['id']
            ));

        //and apply sorting
        $q=$db->prepare('update `content` set `order`=? where `id`=?');
        $i=0;
        foreach($m as $id){
            ++$i;
            $q->execute(array($i,$id));
        }

        return array('success'=>true,'value'=>true);
    }
    return array('success'=>false,'error'=>'Unknown action');
}
$RPC['asphyx']['com.asgaartech.asphyx.domain']=rpc_asphyx_content;
$RPC['asphyx']['com.asgaartech.asphyx.folder']=rpc_asphyx_content;
$RPC['asphyx']['com.asgaartech.asphyx.static']=rpc_asphyx_content;
$RPC['asphyx']['com.asgaartech.asphyx.preset']=rpc_asphyx_content;
$RPC['asphyx']['com.asgaartech.asphyx.conditional.datetime']=rpc_asphyx_content;
$RPC['asphyx']['com.asgaartech.asphyx.conditional.customergroup']=rpc_asphyx_content;
$RPC['asphyx']['com.asgaartech.asphyx.conditional.random']=rpc_asphyx_content;

$RPC['asphyx']['com.handelsweise.litestore.sidebar.adminbox']=rpc_asphyx_content;
$RPC['asphyx']['com.handelsweise.litestore.sidebar.catalog']=rpc_asphyx_content;
$RPC['asphyx']['com.handelsweise.litestore.sidebar.content']=rpc_asphyx_content;
$RPC['asphyx']['com.handelsweise.litestore.gadget.adsense']=rpc_asphyx_content;

?>
