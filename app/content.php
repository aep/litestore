<?php

/* -----------------------------------------------------------------------------------------
   $Id: shop_content.php 1303 2005-10-12 16:47:31Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(conditions.php,v 1.21 2003/02/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (shop_content.php,v 1.1 2003/08/19); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


function module()
{
    global $breadcrumb;
    global $APP_PATH;
    global $_GET;

    $coid=(int)$APP_PATH[2];

    $smarty = new Smarty;
    require_once (DIR_FS_INC.'xtc_validate_email.inc.php');

    if (GROUP_CHECK == 'true')
    {
        $group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
    }
    $shop_content_query = xtc_db_query("SELECT
                        content_id,
                        content_title,
                        content_heading,
                        content_text,
                        content_file
                        FROM ".TABLE_CONTENT_MANAGER."
                        WHERE content_group='".$coid."' ".$group_check."
                        AND languages_id='".(int) $_SESSION['languages_id']."'");
    $shop_content_data = xtc_db_fetch_array($shop_content_query);
    
    $breadcrumb->add($shop_content_data['content_title'], $_GET["path"]);

    $smarty->assign('CONTENT_HEADING', $shop_content_data['content_heading']);
    
    if ($shop_content_data['content_file'] != '') {
    
	    ob_start();
    
	    if (strpos($shop_content_data['content_file'], '.txt'))
		    echo '<pre>';
	    include (DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
	    if (strpos($shop_content_data['content_file'], '.txt'))
		    echo '</pre>';
	    $smarty->assign('file', ob_get_contents());
	    ob_end_clean();
    
    } else {
	    $content_body = $shop_content_data['content_text'];
    }
    $smarty->assign('CONTENT_BODY', $content_body);
    $smarty->assign('language', $_SESSION['language']);
    

    return $smarty->fetch(CURRENT_TEMPLATE.'/module/content.html');
}
?>