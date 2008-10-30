<?php
/* -----------------------------------------------------------------------------------------
   $Id: product_listing.php 1286 2005-10-07 10:10:18Z mz $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_listing.php,v 1.42 2003/05/27); www.oscommerce.com 
   (c) 2003	 nextcommerce (product_listing.php,v 1.19 2003/08/1); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', '/templates/'.CURRENT_TEMPLATE.'/');
$result = true;

require_once (DIR_FS_INC.'xtc_get_all_get_params.inc.php');
require_once (DIR_FS_INC.'xtc_get_vpe_name.inc.php');

$listing_split = new splitPageResults($listing_sql, (int)$_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');

$module_content = array ();

if ($listing_split->number_of_rows > 0) 
{
    $module_smarty->assign('TEXT_NUMBER_OF_PRODUCTS',$listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS));
    $module_smarty->assign('TEXT_RESULT_PAGE',TEXT_RESULT_PAGE);
    $module_smarty->assign('PAGINATION',$listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array ('page', 'info', 'x', 'y'))));


	if (GROUP_CHECK == 'true') 
	{
		$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
	}
		$category_query = xtDBquery("select
			cd.categories_description,
			cd.categories_name,
			cd.categories_heading_title,
			c.listing_template,
			c.categories_teaser 
            from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
			where c.categories_id = '".$current_category_id."'
			and cd.categories_id = '".$current_category_id."'
			".$group_check."
			and cd.languages_id = '".$_SESSION['languages_id']."'");

		$category = xtc_db_fetch_array($category_query,true);
		$image = '';
		if ($category['categories_teaser'] != '')
        {
			$image = $category['categories_teaser'];
        }
		$module_smarty->assign('CATEGORIES_NAME', $category['categories_name']);
		$module_smarty->assign('CATEGORIES_HEADING_TITLE', $category['categories_heading_title']);

		$module_smarty->assign('CATEGORIES_TEASER', $image);
		$module_smarty->assign('CATEGORIES_DESCRIPTION', $category['categories_description']);

		$rows = 0;
		$listing_query = xtDBquery($listing_split->sql_query);
		while ($listing = xtc_db_fetch_array($listing_query, true))
        {
            $rows ++;
            $xe=$product->buildDataArray($listing);
            $findimg = xtc_db_fetch_array(xtDBquery("select  url_small,url_middle,url_big  from products_images where products_id=".$listing["products_id"].""),true);
            $xe["url_small"]=$findimg["url_small"];
            $xe["url_middle"]=$findimg["url_middle"];
            $xe["url_big"]=$findimg["url_big"];
            $module_content[]=$xe; 
        }
} 
else 
{
	// no product found
	$result = false;
}


if ($result != false) 
{

    $module_smarty->assign('MANUFACTURER_DROPDOWN', $manufacturer_dropdown);
    $module_smarty->assign('language', $_SESSION['language']);
    $module_smarty->assign('module_content', $module_content);
    $module_smarty->caching = 0;
    $module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/product_listing.html');
    $smarty->assign('main_content', $module);
} 
else 
{
    $error = TEXT_PRODUCT_NOT_FOUND;
    include (DIR_WS_MODULES.FILENAME_ERROR_HANDLER);
}
?>
