<?php

asphyx_regme("com.handelsweise.litestore.product_listing","ProductListing");
class ProductListing extends A2YObject
{
    var $classid= "com.handelsweise.product_listing";
    function __construct()
    {
    }

    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        global $db;
        $q='select
        p.*,
        pd.*
        from
        products as p
        join products_description as pd on p.products_id =  pd.products_id where p.products_status = 1 ';
        if($this->data!=""){
            $q.=' and '.$this->data;
        }
        $pq = $db->prepare($q);
        $pq->execute();

        global $product;
        $products=array();
        while($listing =$pq->fetch()){
            if(CHECK_STOCK_QUANTITY!=0){
                if($listing['products_quantity']<1)
                    continue;
            }
            $xe=$product->buildDataArray($listing);
            $findimg = xtc_db_fetch_array(xtDBquery("select  url_small,url_middle,url_big  from products_images where products_id=".$listing["products_id"].""),true);
            $xe["url_small"]=$findimg["url_small"];
            $xe["url_middle"]=$findimg["url_middle"];
            $xe["url_big"]=$findimg["url_big"];
            $products[]=$xe;
        }


        $smarty = new Smarty;
        $smarty->assign('tpl_path', '/templates/'.CURRENT_TEMPLATE.'/');
        $smarty->assign('language', $_SESSION['language']);
        $smarty->assign('products',$products);
        return $smarty->fetch('module/catalog.html');
    }
}
?>
