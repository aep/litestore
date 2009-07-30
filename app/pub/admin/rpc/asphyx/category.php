<?php
function rpc_asphyx_category($cmd){
    global $db;
    if ($cmd['action']=='get'){
        $q=$db->prepare('select categories_name  as name,
                                categories_description as  description,
                                categories_status as status,
                                categories_heading_title as heading_title,
                                categories_meta_title as meta_title,
                                categories_meta_description as meta_description,
                                categories_meta_keywords as meta_keywords,
                                categories_image as image,
                                categories_teaser as teaser,
                                products_sorting,
                                products_sorting_key
                        from    categories as c, 
                                categories_description as cd 
                        where   c.categories_id=? 
                        and     c.categories_id=cd.categories_id');
        $q->execute(array($cmd['categories_id']));
        $retval=$q->fetchObject();

        return array('success'=>(bool)$retval,'value'=>$retval);
    }
    else if ($cmd['action']=='set'){
        $db->beginTransaction();
        $q=$db->prepare('update categories_description
                                set categories_name = ?,
                                categories_description = ?,
                                categories_heading_title = ?,
                                categories_meta_title = ?,
                                categories_meta_description = ?,
                                categories_meta_keywords = ?
                        where   categories_id=? ');
        $q->execute(array(
            $cmd['data']['name'],
            $cmd['data']['description'],
            $cmd['data']['heading_title'],
            $cmd['data']['meta_title'],
            $cmd['data']['meta_description'],
            $cmd['data']['meta_keywords'],
            $cmd['data']['id']
        ));

        if($cmd['data']['status']=='on')
            $cmd['data']['status']=1;

        $q=$db->prepare('update categories
                                set categories_status = ?,
                                    categories_image = ?,
                                    categories_teaser = ?,
                                    products_sorting = ?,
                                    products_sorting_key =?
                        where   categories_id=? ');
        $q->execute(array(
            $cmd['data']['status'],
            $cmd['data']['image'],
            $cmd['data']['teaser'],
            $cmd['data']['products_sorting'],
            $cmd['data']['products_sorting_key'],
            $cmd['data']['id']
        ));
        $retok=$db->commit();
        return array('success'=>$retok,'value'=>$retok);
    }
    else if ($cmd['action']=='create'){

        $q=$db->prepare('insert into categories (parent_id,sort_order) values (?,?)');
        $q->execute(array($cmd['parent'],nextKey('sort_order','categories')));
        $liid=$db->lastInsertId();


        $q=$db->prepare('insert into categories_description (categories_id,categories_name,languages_id) values (?,?,2)');
        $q->execute(array($liid,$cmd['name']));

        $retval['text']		= $cmd['name'];
        $retval['id']	    = 'category_'.$liid;
        $retval['data']     = array('categories_id'=>$liid);
        $retval['leaf']	    = true;
        $retval['cls']	    = 'item_category';
        $retval['aclass']	= 'com.handelsweise.litestore.category';

        if($liid)
            return array('success'=>true,'value'=>$liid);
        else
            return array('success'=>false,'error'=>'cannot get inserted id');

    }
    else if ($cmd['action']=='delete'){
        if($cmd['category']<2){
            return array('success'=>'false','value'=>null,'error'=>'Cannot delete root');
        }
        $q=$db->prepare('select products_id from products_to_categories where categories_id=?');
        $q->execute(array($cmd['category']));
        while($x=$q->fetch()){
            $a=array();
            $a['command']='asphyx';
            $a['category']=$cmd['category'];
            $a['product']=$x['products_id'];
            $a['aclass']='com.handelsweise.litestore.product';
            $a['action']='delete';
            $c=f($a);
            if(!$c['success'])
                return array('success'=>'false','value'=>null,'error'=>$c['error']);
        }
        $q=$db->prepare('delete from categories where categories_id=?');
        $q->execute(array($cmd['category']));
        $q=$db->prepare('delete from categories_description where categories_id=?');
        $q->execute(array($cmd['category']));
        return array('success'=>true);
    }
    else if ($cmd['action']=='move'){
        $db->beginTransaction();

        //build sorted array of categories in the new parent excluding subject
        $q=$db->prepare('select categories_id from categories where parent_id=? order by `sort_order`'); 
        $q->execute(array($cmd['parentNew']));
        $m=array();
        while($x=$q->fetch()){  
            if($x['categories_id']==$cmd['category'])
                continue;
            $m[]=$x['categories_id'];
        }

        //stuff it in
        if($cmd['relative']=='append'){
            $m[]=$cmd['category'];
        }
        else if($cmd['relative']=='below' ){
            $m=arrayInsert($m,array_search($cmd['relativeTo'],$m)+1,$cmd['category']);
        }
        else if($cmd['relative']=='above'){
            $m=arrayInsert($m,array_search($cmd['relativeTo'],$m),$cmd['category']);
        }

        //move the subject below the new parent
        $q=$db->prepare('update categories set  parent_id=? where categories_id=?'); 
        $q->execute(array(
                $cmd['parentNew'],
                $cmd['category']
            ));

        //and apply sorting
        $q=$db->prepare('update categories set sort_order=? where categories_id=?');
        $i=0;
        foreach($m as $id){
            ++$i;
            $q->execute(array($i,$id));
        }
        return array('success'=>true);
    }
    else if ($cmd['action']=='list'){

        $nodes=array();


        $q=$db->prepare('select c.categories_id, cd.categories_name from 
                categories as c, 
                categories_description as cd 
                where c.categories_id=cd.categories_id
                and c.parent_id=?
                order by sort_order
                ');
        $q->execute(array($cmd['data']['categories_id']));

        while($row=$q->fetch())
        {
            $node['text']		= $row['categories_name'];
            $node['data']       = $row;
            $node['leaf']	    = false;
            $node['cls']	    = 'item_category';
            $node['aclass']	    = 'com.handelsweise.litestore.category';
            $nodes[]=$node;
        }

        $q=$db->prepare('select p.products_id, pd.products_name from 
                products as p, 
                products_description as pd,
                products_to_categories as p2c
                where p.products_id=pd.products_id
                and p2c.products_id=p.products_id
                and p2c.categories_id=?
                ');
        $q->execute(array($cmd['data']['categories_id']));

        while($row=$q->fetch())
        {
            $node['text']		= $row['products_name'];
            $node['data']       = $row;
            $node['leaf']	    = false;
            $node['cls']	    = 'item_product';
            $node['aclass']	    = 'com.handelsweise.litestore.product';
            $nodes[]=$node;
        }

        return array('success'=>true,'value'=>$nodes);
    }

}

$RPC['asphyx']['com.handelsweise.litestore.category']=rpc_asphyx_category;
?>
