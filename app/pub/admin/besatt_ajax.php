<?php
    require ('includes/application_top.php');

    global $db;

    header ('content-type : text/x-json');

    $post=$_POST;
    if(!$post['aclass'])
        $post=json_decode(file_get_contents("php://input"),true);
    

    if($post['command']=='getChildren'){

        $nodes=array();

        if($post['aclass']=='com.handelsweise.litestore.product'){
            $nid=$post['node'];
            $nid=split('/',$nid);

            $q=$db->prepare('select products_id,image_nr,url_small,url_middle,url_big from products_images
                                where products_id=?');
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
        else if($post['aclass']=='com.handelsweise.litestore.category'){
            $nid=$post['node'];
            $nid=split('_',$nid);
            $q=$db->prepare('select c.categories_id, cd.categories_name from 
                    categories as c, 
                    categories_description as cd 
                    where c.categories_id=cd.categories_id
                    and c.parent_id=?
                    ');
            $q->execute(array($nid[1]));

            while($row=$q->fetch())
            {
                $node['text']		= $row['categories_name'];
                $node['id']			= 'category_'.$row['categories_id'];
                $node['data']       = $row;
    //            $node['position']	= $row[''];    
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
            $q->execute(array($nid[1]));

            while($row=$q->fetch())
            {
                $node['text']		= $row['products_name'];
                $node['id']			= 'product_'.$nid[1].'_'.$row['products_id'];
                $node['data']       = $row;
    //            $node['position']	= $row[''];    
                $node['leaf']	    = false;
                $node['cls']	    = 'item_product';
                $node['aclass']	    = 'com.handelsweise.litestore.product';
                $nodes[]=$node;
            }

            if($nid[1]=='0')
            {
                $q=$db->prepare('select p.products_id, pd.products_name from 
                        products as p, 
                        products_description as pd 
                        where p.products_id=pd.products_id
                        and p.products_id not in (select products_id from products_to_categories)
                        ');
                $q->execute();

                while($row=$q->fetch())
                {
                    $node['text']		= $row['products_name'];
                    $node['id']			= 'product_'.$nid[1].'_'.$row['products_id'];
                    $node['data']       = $row;
        //            $node['position']	= $row[''];    
                    $node['leaf']	    = false;
                    $node['cls']	    = 'item_product';
                    $node['aclass']	    = 'com.handelsweise.litestore.product';
                    $nodes[]=$node;
                }
            }
        }        


        echo json_encode($nodes);
    }
    else if($_POST['command']=='move')
    {
        $q=$db->prepare('update `content` set `order`=? , `parent`=? where `id`=?;');
        $q->execute(array($_POST['order'],$_POST['parent'],$_POST['node']));
        echo "ok";
    }
    else if($_POST['command']=='delete')
    {
        $delnodes=array();

        function r($id,&$delnodes )
        {
            global $db;
            $q=$db->prepare('select `id` from `content`  where `parent`=?;');
            $q->execute(array($id));
            while($x=$q->fetch())
            {
                $delnodes[]=$x['id'];
                r($x['id'],$delnodes);
            }
            $delnodes[]=$id;
        }
                
        r($_POST['node'],$delnodes);

        $q=$db->prepare('delete from `content`  where `id`=?;');
        foreach ($delnodes as $delnode)
        {
            $q->execute(array($delnode));
        }
        echo "ok";
    }
    else if($_POST['command']=='create')
    {
        $q=$db->prepare('insert into `content` (parent,uuid,name)  values (?,?,?)');;
        $q->execute(array($_POST['node'],$_POST['type'],$_POST['nodename']));
        echo "ok";
    }

?>
