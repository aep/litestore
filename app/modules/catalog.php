<?php
function module()
{

    global $breadcrumb,$cPath_array;
    $breadcrumb->addCategory($cPath_array);


    global $db,$current_category_id; 

    //current category

    $mq = $db->prepare('select
        c.categories_teaser,
        c.products_sorting,
        c.products_sorting_key,
        cd.categories_heading_title,
        cd.categories_description
        from 
        categories as c
        join categories_description as cd on c.categories_id =  cd.categories_id
        where c.categories_id = ?
        and c.categories_status = 1
    ');

    $mq->execute(array($current_category_id));
    $mq=$mq->fetch();

    //no such category
    if(!$mq)
    {
        header("Location: ".SEO_NOTFOUNDPAGE);
        die();
    }


    //sub categories

    $sq = $db->prepare('select
        c.categories_id,
        c.categories_image,
        cd.categories_name,
        cd.categories_description
        from 
        categories as c
        join categories_description as cd on c.categories_id =  cd.categories_id
        where c.parent_id = ?
        and c.categories_status = 1
        order by c.sort_order

    ');

    $sq->execute(array($current_category_id));

    $categories=null;
    while($cat=$sq->fetch())
    {
        $categories[]=array(
            'CATEGORIES_LINK' => '/catalog/'.implode  ('/' ,$cPath_array ).'/'.$cat['categories_id'],
            'CATEGORIES_IMAGE' => $cat['categories_image'],
            'CATEGORIES_NAME' => $cat['categories_name'],
            'CATEGORIES_DESCRIPTION' => $cat['categories_description'],
        );
    }




    //products

    $products_sorting='DESC';
    if ($mq['products_sorting']=0)
    {
        $products_sorting='ASC';
    }

    $pq = $db->prepare('select
        p.*,
        pd.*
        from 
        products as p
        join products_description as pd on p.products_id =  pd.products_id
        join products_to_categories as x  on p.products_id  = x.products_id 
        where x.categories_id=?
        and p.products_status = 1
        order by ? '.$products_sorting.'
    ');

    $pq->execute(array($current_category_id,$mq['products_sorting_key']));


    global $product;
    $products=null;
    while($listing =$pq->fetch())
    {
        $xe=$product->buildDataArray($listing);
        $findimg = xtc_db_fetch_array(xtDBquery("select  url_small,url_middle,url_big  from products_images where products_id=".$listing["products_id"].""),true);
        $xe["url_small"]=$findimg["url_small"];
        $xe["url_middle"]=$findimg["url_middle"];
        $xe["url_big"]=$findimg["url_big"];
        $products[]=$xe;         
    }



    $smarty=new Smarty;
    $smarty->assign('CATEGORIES_HEADING_TITLE',$mq['categories_heading_title']);
    $smarty->assign('CATEGORIES_TEASER',$mq['categories_teaser']);
    $smarty->assign('CATEGORIES_DESCRIPTION',$mq['categories_description']);

    if($categories)
    {
        $smarty->assign('categories',$categories);
    }
    if($products)
    {
        $smarty->assign('products',$products);
    }

    $smarty->assign('session', session_id());    $smarty->assign('language', $_SESSION['language']);    $smarty->assign('module_content', $categories_content);
    $smarty->caching = 0;

    return $smarty->fetch('module/catalog.html');

}
?>
