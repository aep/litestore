<?php
/* -----------------------------------------------------------------------------------------
   $Id: admin.php 1262 2005-09-30 10:00:32Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (admin.php,v 1.12 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

// reset var


class BoxAdmin extends AbstractVCBox
{
    var $classid= "{1784e3c3-0000-4000-824f-76b767236602}";
    function __construct()
    {
    }

    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        if ($_SESSION['customers_status']['customers_status_id'] != 0)
            return;

        global $product;
        $box_smarty = new smarty;
        $box_smarty->assign('tpl_path','/templates/'.CURRENT_TEMPLATE.'/');
        
        $orders_contents = '';
        $orders_status_validating = xtc_db_num_rows(xtc_db_query("select orders_status from " . TABLE_ORDERS ." where orders_status ='0'"));
        $orders_contents .='<a href="/admin/' .FILENAME_ORDERS. '?selected_box=customers&status=0' . '">' . TEXT_VALIDATING . '</a>: ' . $orders_status_validating . '<br />'; 
        
        $orders_status_query = xtc_db_query("select orders_status_name, orders_status_id from " . TABLE_ORDERS_STATUS . " where languages_id = '" . (int)$_SESSION['languages_id'] . "'");
        
        while ($orders_status = xtc_db_fetch_array($orders_status_query)) 
        {
            $orders_pending_query = xtc_db_query("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . $orders_status['orders_status_id'] . "'");
            $orders_pending = xtc_db_fetch_array($orders_pending_query);
            $orders_contents .= '<a href="' . FILENAME_ORDERS. '?selected_box=customers&status=' . $orders_status['orders_status_id'] . '">' . $orders_status['orders_status_name'] . '</a>: ' . $orders_pending['count'] . '<br />';
        }
        
        $orders_contents = substr($orders_contents, 0, -6);
        
        $customers_query = xtc_db_query("select count(*) as count from " . TABLE_CUSTOMERS);
        $customers = xtc_db_fetch_array($customers_query);
        $products_query = xtc_db_query("select count(*) as count from " . TABLE_PRODUCTS . " where products_status = '1'");
        $products = xtc_db_fetch_array($products_query);
        $reviews_query = xtc_db_query("select count(*) as count from " . TABLE_REVIEWS);
        $reviews = xtc_db_fetch_array($reviews_query);
        if ($product->isProduct()) 
        {
            $admin_link='<a href="' . FILENAME_EDIT_PRODUCTS. '?cPath=' . $cPath . '&pID=' . $product->data['products_id'] . '&action=new_product' . '" onclick="window.open(this.href); return false;"> edit product</a>';
        }
        
        $box_content= '<b>' . BOX_TITLE_STATISTICS . '</b><br />' . $orders_contents . '<br />' .
                                                BOX_ENTRY_CUSTOMERS . ' ' . $customers['count'] . '<br />' .
                                                BOX_ENTRY_PRODUCTS . ' ' . $products['count'] . '<br />' .
                                                BOX_ENTRY_REVIEWS . ' ' . $reviews['count'] .'<br />' .
                                                $admin_image . '<br />' .$admin_link;
        
            if ($flag==true) define('SEARCH_ENGINE_FRIENDLY_URLS',true);
            $box_smarty->assign('BOX_CONTENT', $box_content);
        
            $box_smarty->caching = 0;
            $box_smarty->assign('language', $_SESSION['language']);
            return $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_admin.html');
    }
    function metatype()
    {
        return "restore/box";
    }
}
?>