<?php

/* -----------------------------------------------------------------------------------------
   $Id: metatags.php 1140 2005-08-10 10:16:00Z mz $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (metatags.php,v 1.7 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/



$meta_description='';
$meta_keywords='';

$cfg_group_query = xtc_db_query('select id,name,content from metatags');while($cfg = xtc_db_fetch_array($cfg_group_query))
{
    if($cfg['name']=='description')
    {
        $meta_description=$cfg['content'];
    }
    else if($cfg['name']=='keywords')
    {
        $meta_keywords=$cfg['content'];
    }
    else
    {
        $head[]=array('name'=>$cfg['name'],'content'=>$cfg['content']);
    }
}






if (strstr($APP_PATH[1], "products")) 
{
    if ($product->isProduct()) 
    {

        $head[]=array('name'=>"description" ,'content'=>$product->data['products_meta_description']);
        $head[]=array('name'=>"keywords" ,'content'=>$product->data['products_meta_keywords']);

        $smarty->assign("HEAD_TITLE",TITLE.' - '.$product->data['products_meta_title'].' '.$product->data['products_name'].' '.$product->data['products_model'] );
    } 
    else 
    {
        $head[]=array('name'=>"description" ,'content'=>$meta_description);
        $head[]=array('name'=>"keywords" ,'content'=>$meta_keywords);
        $smarty->assign("HEAD_TITLE",TITLE);
    }
} 
else if (strstr($APP_PATH[1], "catalog")) 
{    global $current_category_id;

    $categories_meta_query = xtDBquery("SELECT categories_meta_keywords,
                                                categories_meta_description,
                                                categories_meta_title,
                                                categories_name
                                                FROM " . TABLE_CATEGORIES_DESCRIPTION . "
                                                WHERE categories_id='" .  $current_category_id . "' and
                                                languages_id='" . $_SESSION['languages_id'] . "'");
    $categories_meta = xtc_db_fetch_array($categories_meta_query, true);
    if ($categories_meta['categories_meta_keywords'] == '') 
    {
        $categories_meta['categories_meta_keywords'] = $meta_keywords;
    }
    if ($categories_meta['categories_meta_description'] == '') 
    {
        $categories_meta['categories_meta_description'] = $meta_description;
    }
    if ($categories_meta['categories_meta_title'] == '') 
    {
        $categories_meta['categories_meta_title'] = $categories_meta['categories_name'];
    }


    $head[]=array('name'=>"description" ,'content'=>$categories_meta['categories_meta_description']);
    $head[]=array('name'=>"keywords" ,'content'=>$categories_meta['categories_meta_keywords']);
    $smarty->assign("HEAD_TITLE",TITLE.' - '.$categories_meta['categories_meta_title']);

} 
else 
{
    if ($_GET['coID']) 
    {
        $contents_meta_query = xtDBquery("SELECT content_heading
                                                    FROM " . TABLE_CONTENT_MANAGER . "
                                                    WHERE content_group='" . $_GET['coID'] . "' and
                                                    languages_id='" . $_SESSION['languages_id'] . "'");
        $contents_meta = xtc_db_fetch_array($contents_meta_query, true);

        $head[]=array('name'=>"description" ,'content'=>$meta_description);
        $head[]=array('name'=>"keywords" ,'content'=>$meta_keywords);
        $smarty->assign("HEAD_TITLE",TITLE." - ".$contents_meta['content_heading']);


    } 
    else 
    {

        $head[]=array('name'=>"description" ,'content'=>$meta_description);
        $head[]=array('name'=>"keywords" ,'content'=>$meta_keywords);
        $smarty->assign("HEAD_TITLE",TITLE);

    }
}

$smarty->assign("head_metadata",$head);



?>
