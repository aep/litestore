<?php
function rpc_asphyx_root($cmd){
    global $db;
    if ($cmd['action']=='list'){

        $nodes=array();

        $q=$db->prepare('select c.categories_id, cd.categories_name from 
                categories as c, 
                categories_description as cd 
                where c.categories_id=cd.categories_id
                and c.parent_id=0
                order by sort_order
                ');
        $q->execute(array($nid[1]));

        while($row=$q->fetch())
        {
            $node=array();
            $node['text']		= $row['categories_name'];
            $node['data']       = $row;
            if($row['categories_id']==1)
                $node['caps']['write'] = false;
            $node['leaf']	    = false;
            $node['aclass']	    = 'com.handelsweise.litestore.category';
            $nodes[]=$node;
        }

        $nodes[]=array(
            'text'=>'Content',
            'leaf'=>false,
            'data'=>array('id'=>1),
            'caps' => array('write'=>false),
            'aclass'=>'com.asgaartech.asphyx.preset'
        );


        $q=$db->prepare('select p.products_id, pd.products_name from 
                products as p, 
                products_description as pd 
                where p.products_id=pd.products_id
                and p.products_id not in (select products_id from products_to_categories)

                union

                select p.products_id, pd.products_name from 
                                products as p, 
                                products_description as pd,
                                products_to_categories as p2c
                                where p.products_id=pd.products_id
                                and p2c.products_id=p.products_id
                                and p2c.categories_id=0
                ');
        $q->execute();

        while($row=$q->fetch()){
            $node=array();
            $node['text']		= $row['products_name'];
            $node['data']       = $row;
            $node['leaf']	    = false;
            $node['aclass']	    = 'com.handelsweise.litestore.product';
            $nodes[]=$node;
        }


        return array('success'=>true,'value'=>$nodes);
    }

    return array('success'=>false,'error'=>'Unknown action');
}

$RPC['asphyx']['root']=rpc_asphyx_root;
?>
