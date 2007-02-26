<?php
/*
   (c) 2007 IB C SOLUTIONS LTD
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(default.php,v 1.84 2003/05/07); www.oscommerce.com
   (c) 2003  nextcommerce (default.php,v 1.13 2003/08/17); www.nextcommerce.org
   (c) 2003 XT Commerce http://www.xt-commerce.com

   Released under the GNU General Public License
*/

function module()
{

    $default_smarty = new smarty;
    $default_smarty->assign('tpl_path',xtc_template_path(CURRENT_TEMPLATE));
    $default_smarty->assign('session', session_id());
    // default page
    if (GROUP_CHECK == 'true') 
    {
        $group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
    }
    $shop_content_query = xtDBquery("SELECT
                        content_title,
                        content_heading,
                        content_text,
                        content_file
                        FROM ".TABLE_CONTENT_MANAGER."
                        WHERE content_group='5'
                        ".$group_check."
                        AND languages_id='".$_SESSION['languages_id']."'");
    $shop_content_data = xtc_db_fetch_array($shop_content_query,true);
    
    $default_smarty->assign('title', $shop_content_data['content_heading']);
    
    include (DIR_WS_INCLUDES.FILENAME_CENTER_MODULES);
    
    if ($shop_content_data['content_file'] != '') 
    {
        ob_start();
        if (strpos($shop_content_data['content_file'], '.txt'))
        echo '<pre>';
        include (DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
        if (strpos($shop_content_data['content_file'], '.txt'))
        echo '</pre>';
        $shop_content_data['content_text'] = ob_get_contents();
        ob_end_clean();
    }
    
    $default_smarty->assign('text',  $shop_content_data['content_text']);
    $default_smarty->assign('language', $_SESSION['language']);
    
    $default_smarty->caching = 0;
    return  $default_smarty->fetch('module/main_content.html');
}
?>
