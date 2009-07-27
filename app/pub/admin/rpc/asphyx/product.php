<?php
function rpc_asphyx_product($cmd){
    global $db;
    if ($cmd['action']=='get'){
        $q=$db->prepare('select products_name  as name,
                                products_price  as price,
                                products_description as  description,
                                products_short_description as  short_description,
                                products_status as status,
                                products_meta_title as meta_title,
                                products_meta_description as meta_description,
                                products_meta_keywords as meta_keywords,
                                products_keywords as keywords,
                                products_ean as ean,
                                products_tax_class_id as tax_class_id,
                                products_shippingtime as shipping_status,
                                products_weight as weight,
                                products_model as model
                        from    products as c, 
                                products_description as cd 
                        where   c.products_id=? 
                        and     c.products_id=cd.products_id');
        $q->execute(array($cmd['products_id']));
        $retval=$q->fetchObject();
        
        if(!$retval){
            return array('success'=>false);
        }

        $q=$db->prepare('select tax_class_id, tax_class_title from tax_class');
        $q->execute(array());
        $retval->taxClasses=array();
        while($x=$q->fetch()){
            $retval->taxClasses[]=array('id'=>$x['tax_class_id'],'name'=>$x['tax_class_title']); 
        }

        $q=$db->prepare('select shipping_status_id, shipping_status_name from shipping_status where languages_id=2');
        $q->execute(array());
        $retval->shippingStati=array();
        while($x=$q->fetch()){
            $retval->shippingStati[]=array('id'=>$x['shipping_status_id'],'name'=>$x['shipping_status_name']); 
        }


        return array('success'=>true,'value'=>$retval);
    }
    else if ($cmd['action']=='set'){
        $db->beginTransaction();
        $q=$db->prepare('update products_description
                                set products_name = ?,
                                products_description =?,
                                products_short_description =?,
                                products_meta_title =?,
                                products_meta_description =?,
                                products_meta_keywords =?,
                                products_keywords =?
                        where   products_id=? ');
        $q->execute(array(
            $cmd['data']['name'],
            $cmd['data']['description'],
            $cmd['data']['short_description'],
            $cmd['data']['meta_title'],
            $cmd['data']['meta_description'],
            $cmd['data']['meta_keywords'],
            $cmd['data']['keywords'],
            $cmd['data']['id']
        ));

        if($cmd['data']['status']=='on')
            $cmd['data']['status']=1;

        $q=$db->prepare('update products
                                set products_status = ?,
                                    products_price =?,
                                    products_ean=?,
                                    products_model=?,
                                    products_weight=?,
                                    products_tax_class_id=?,
                                    products_shippingtime=?
                        where   products_id=? ');
        $q->execute(array(
            $cmd['data']['status'],
            $cmd['data']['price'],
            $cmd['data']['ean'],
            $cmd['data']['model'],
            $cmd['data']['weight'],
            $cmd['data']['tax_class_id'],
            $cmd['data']['shipping_status'],
            $cmd['data']['id']
        ));
        $retok=$db->commit();
        return array('success'=>$retok,'value'=>$retok);
    }
    else if ($mcd['action']=='list'){
        $nid=$cmd['products_id'];
        $nid=split('_',$nid);

        $q=$db->prepare('select products_id,image_nr,url_small,url_middle,url_big from products_images
                            where products_id=? order by image_nr');
        $q->execute(array($nid[2]));
        while($row=$q->fetch()){
            $node['text']		 = 'Image '.$nid[2].'_'.$row['image_nr'];
            $node['id']			 = 'image_'.$nid[1].'_'.$nid[2].'_'.$row['image_nr'];
            $node['data']        = $row;
            $node['position']	 = $row['image_nr'];    
            $node['leaf']	     = true;
            $node['cls']	     = 'item_image';
            $node['aclass']	     = 'com.handelsweise.litestore.product_image';
            $nodes[]=$node;
        }
    }
    else if ($cmd['action']=='create'){


        $q=$db->prepare('insert into products (products_model) values (?)');
        $q->execute(array(nextKey('products_model','products')));
        $liid=$db->lastInsertId();

        $q=$db->prepare('insert into products_to_categories (products_id,categories_id) values (?,?)');
        $q->execute(array($liid,$cmd['parent']));

        $q=$db->prepare('insert into products_description (products_id,products_name,languages_id) values (?,?,2)');
        $q->execute(array($liid,$cmd['name']));

        $retval['text']		= $cmd['name'];
        $retval['id']	    = 'product_'.$cmd['parent'].'_'.$liid;
        $retval['data']     = array('products_id'=>$liid);
        $retval['leaf']	    = true;
        $retval['cls']	    = 'item_product';
        $retval['aclass']	= 'com.handelsweise.litestore.product';

        if($liid)
            return array('success'=>true,'value'=>$retval);
        else
            return array('success'=>false,'error'=>'cannot get inserted id');
    }
    else if ($cmd['action']=='delete'){
        $q=$db->prepare('delete from products_to_categories where products_id=? and categories_id=?');
        $retok=($q->execute(array($cmd['product'],$cmd['category']))!=false);

        $q=$db->prepare('select COUNT(*) from products_to_categories where products_id=?');
        $retok=($q->execute(array($cmd['product']))!=false);
        $x=$q->fetch();
        $x=$x['COUNT(*)'];
        if($x==0){
            $q=$db->prepare('delete from products where products_id=?');
            $q->execute(array($cmd['product']));
            $q=$db->prepare('delete from products_description where products_id=?');
            $q->execute(array($cmd['product']));
            $q=$db->prepare('delete from products_images where products_id=?');
            $q->execute(array($cmd['product']));
            $q=$db->prepare('delete from prices where products_id=?');
            $q->execute(array($cmd['product']));
        }
        return array('success'=>true);
    }
    else if ($cmd['action']=='list'){

        $nodes=array();

        $q=$db->prepare('select products_id,image_nr,url_small,url_middle,url_big from products_images
                            where products_id=? order by image_nr');
        $q->execute(array($cmd['data']['products_id']));
        while($row=$q->fetch()){
            $node['text']		 = 'Image '.$nid[2].'_'.$row['image_nr'];
            $node['data']        = $row;
            $node['position']	 = $row['image_nr'];    
            $node['leaf']	     = true;
            $node['cls']	     = 'item_image';
            $node['aclass']	     = 'com.handelsweise.litestore.product_image';
            $nodes[]=$node;
        }
        return array('success'=>true,'value'=>$nodes);

    }
    else if ($cmd['action']=='move' || $cmd['action']=='link' || $cmd['action']=='copy'){


        if ($cmd['action']=='copy'){
            //make a copy of this, with different products_model and products_id
            $q=$db->prepare('select *  from products where products_id=?'); 
            $q->execute(array($cmd['product']));
            $x=$q->fetchObject();
            
            $keys=array();
            $qvals=array();
            $vals=array();

            foreach($x as $k=>$v){  
                if($k == 'products_id'){
                    continue;
                }
                if($k == 'products_model'){
                    $v=nextKey('products_model','products');
                }
                $keys[]=$k;
                $qvals[]='?';
                $vals[]=$v;
            }

            $q=$db->prepare('insert into  products ('.implode(',',$keys).') values ('.implode(',',$qvals).')');
            $q->execute($vals);                    

            $newcopy=$db->lastInsertId();


            //copy products_description as well
            $q=$db->prepare('select *  from products_description where products_id=?');
            $q->execute(array($cmd['product']));
        
            while(true){
                try{$x=$q->fetch(PDO::FETCH_ASSOC);}catch(Exception $e){break;};
                
                $keys=array();
                $qvals=array();
                $vals=array();

                foreach($x as $k=>$v){  
                    if($k == 'products_id'){
                        $v=$newcopy;
                    }
                    $keys[]=$k;
                    $qvals[]='?';
                    $vals[]=$v;
                }

                $q=$db->prepare('insert into  products_description ('.implode(',',$keys).') values ('.implode(',',$qvals).')');
                $q->execute($vals);       
            }
            $cmd['product']=$newcopy;
        }


        $db->beginTransaction();

        //build sorted array of categories in the new parent excluding subject

        $q=$db->prepare('select p.products_id from products as p, products_to_categories as c 
                         where p.products_id=c.products_id and c.categories_id=? order by `products_sort`'); 
        $q->execute(array($cmd['parentNew']));
        $m=array();
        while($x=$q->fetch()){  
            if($x['products_id']==$cmd['product'])
                continue;
            $m[]=$x['products_id'];
        }

        //stuff it in
        if($cmd['relative']=='append'){
            $m[]=$cmd['product'];
        }
        else if($cmd['relative']=='below' ){
            $m=arrayInsert($m,array_search($cmd['relativeTo'],$m)+1,$cmd['product']);
        }
        else if($cmd['relative']=='above'){
            $m=arrayInsert($m,array_search($cmd['relativeTo'],$m),$cmd['product']);
        }

        if($cmd['action']=='move' ){
            $q=$db->prepare('delete from products_to_categories where products_id=? and categories_id=?'); 
            $q->execute(array(
                    $cmd['product'],
                    $cmd['parentOld']
                ));
        }

        $q=$db->prepare('insert into products_to_categories (products_id,categories_id) values (?,?)'); 
        $q->execute(array(
                $cmd['product'],
                $cmd['parentNew']
            ));

        //and apply sorting
        $q=$db->prepare('update products set `products_sort`=? where products_id=?');
        $i=0;
        foreach($m as $id){
            ++$i;
            $q->execute(array($i,$id));
        }
    }
    return array('success'=>true);
}

$RPC['asphyx']['com.handelsweise.litestore.product']=rpc_asphyx_product;

?>
