<?php
function rpc_asphyx_product_image($cmd){
    global $db;
    if ($cmd['action']=='set'){
         $q=$db->prepare('update products_images
                             set url_small = :url_small,
                                 url_middle = :url_middle,
                                 url_big = :url_big
                           where products_id= :products_id 
                             and image_nr= :image_nr ');
            $retok=$q->execute($cmd['data']);
            return array('success'=>$retok,'value'=>$retok);
            
    }
    else if ($cmd['action']=='create'){
        $q=$db->prepare('insert into products_images (image_nr,products_id) values (?,?)');
        $nr=nextKey('image_nr','products_images where products_id=?',array($cmd['product']));
        $q->execute(array($nr,$cmd['product']));
        $liid=$db->lastInsertId();

        $retval['text']		= 'Image '.$cmd['product'].'_'.$nr;
        $retval['data']     = array('image_nr'=>$liid,'products_id'=>$cmd['product']);
        $retval['leaf']	    = true;
        $retval['cls']	    = 'item_image';
        $retval['aclass']	= 'com.handelsweise.litestore.product_image';

        if(!$liid){
            return array('success'=>false,'error'=>'cannot get inserted id');
        }
        return array('success'=>true,'value'=>$retval);
    }
    else if ($cmd['action']=='get'){
        $q=$db->prepare('select url_small, url_middle,url_big 
                        from    products_images 
                        where   products_id=? 
                        and     image_nr=?');
        $q->execute(array($cmd['product'],$cmd['image_nr']));
        $retval=$q->fetchObject();
        return array('success'=>(bool)$retval,'value'=>$retval);
    }
    else if ($cmd['action']=='delete'){

        $q=$db->prepare('delete from products_images where products_id=? and image_nr=?');
        $retok=($q->execute(array($cmd['product'],$cmd['nr']))!=false);
        $q=$db->prepare('update products_images set image_nr=image_nr-1 where products_id=? and image_nr > ? '); 
        $q->execute(array($cmd['product'],$cmd['nr']));
        return array('success'=>true,'value'=>true);
    }
    else if ($cmd['action']=='move'){
        $q=$db->prepare('select image_nr from products_images where products_id=?'); 
        $q->execute(array($cmd['productNew']));
        $m=array();
        while($x=$q->fetch()){  
            $m[]=$x['image_nr'];
        }
        sort($m);
        $m=array_reverse($m);

        if($cmd['relative']=='append'){
            $q=$db->prepare('update products_images set image_nr=?, products_id=? where image_nr=? and products_id=?'); 
            $q->execute(array(
                ($m[sizeof($m)-2])+1,
                $cmd['productNew'],
                $cmd['nrOld'],
                $cmd['productOld']
            ));
        }
        else if($cmd['relative']=='below' || $cmd['relative']=='above'){
            $db->beginTransaction();
            
            //mysql fails at batch, so we do it manualy..
            //first move the current row away so it doesnt get hit by the next step

            $tmpprod=nextKey('products_id','products_images');
            $q=$db->prepare('update products_images set  products_id=? where image_nr=? and products_id=?'); 
            $q->execute(array(
                $tmpprod,
                $cmd['nrOld'],
                $cmd['productOld']
            ));
            
            //move all one down
            foreach($m as $x){
                if(($x > $cmd['relativeTo'])  ||  (($cmd['relative']=='above') && ($x == $cmd['relativeTo']))){
                    $q=$db->prepare('update products_images set image_nr=? where image_nr = ? and products_id=?');
                    $q->execute(array(
                        $x+1,
                        $x,
                        $cmd['productNew']
                    ));
                }
            }
            //finally get the node into position
            $q=$db->prepare('update products_images set image_nr=?, products_id=? where image_nr=? and products_id=?'); 
            $q->execute(array(
                ($cmd['relative']=='below')?($cmd['relativeTo']+1):$cmd['relativeTo'],
                $cmd['productNew'],
                $cmd['nrOld'],
                $tmpprod
            ));
            $db->commit();
        }
        return array('success'=>true,'value'=>true);
    }
}


$RPC['asphyx']['com.handelsweise.litestore.product_image']=rpc_asphyx_product_image;
?>
