<?php

/* -----------------------------------------------------------------------------------------
   $Id: account_history.php 1309 2005-10-17 08:01:11Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_history.php,v 1.60 2003/05/27); www.oscommerce.com 
   (c) 2003	 nextcommerce (account_history.php,v 1.13 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


function module()
{
    global $breadcrumb;

    $smarty = new Smarty;

    require_once (DIR_FS_INC.'xtc_count_customer_orders.inc.php');
    require_once (DIR_FS_INC.'xtc_date_long.inc.php');
    require_once (DIR_FS_INC.'xtc_get_all_get_params.inc.php');
    
    if (!isset ($_SESSION['customer_id']))
	    xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
    
    $breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_HISTORY, FILENAME_ACCOUNT);
    $breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_HISTORY, FILENAME_ACCOUNT_HISTORY);
    
    $module_content = array ();
    if (($orders_total = xtc_count_customer_orders()) > 0) 
    {
    
	    $history_query_raw = "select o.orders_id, o.date_purchased, o.delivery_name, o.billing_name, ot.text as order_total, s.orders_status_name from ".TABLE_ORDERS." o, ".TABLE_ORDERS_TOTAL." ot, ".TABLE_ORDERS_STATUS." s where o.customers_id = '".(int) $_SESSION['customer_id']."' and o.orders_id = ot.orders_id and ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.languages_id = '".(int) $_SESSION['languages_id']."' order by orders_id DESC";
    
	    $history_query = xtc_db_query($history_query_raw);
    
	    while ($history = xtc_db_fetch_array($history_query)) {
		    $products_query = xtc_db_query("select count(*) as count from ".TABLE_ORDERS_PRODUCTS." where orders_id = '".$history['orders_id']."'");
		    $products = xtc_db_fetch_array($products_query);
    
		    if (xtc_not_null($history['delivery_name'])) {
			    $order_type = TEXT_ORDER_SHIPPED_TO;
			    $order_name = $history['delivery_name'];
		    } else {
			    $order_type = TEXT_ORDER_BILLED_TO;
			    $order_name = $history['billing_name'];
		    }
		    $module_content[] = array (
                'ORDER_ID' => $history['orders_id'], 
                'ORDER_STATUS' => $history['orders_status_name'], 
                'ORDER_DATE' => xtc_date_long($history['date_purchased']), 
                'ORDER_PRODUCTS' => $products['count'], 
                'ORDER_TOTAL' => strip_tags($history['order_total']), 
                'ORDER_URL' => FILENAME_ACCOUNT_HISTORY_INFO. '/'.$history['orders_id']);
    
	    }
    }

    $smarty->assign('tpl_path','/templates/'.CURRENT_TEMPLATE.'/');
    $smarty->assign('order_content', $module_content);
    $smarty->assign('language', $_SESSION['language']);
    $smarty->assign('BUTTON_BACK', '<a href="'.FILENAME_ACCOUNT.'">'. IMAGE_BUTTON_BACK.'</a>');
    $smarty->caching = 0;
    return $smarty->fetch(CURRENT_TEMPLATE.'/module/account_history.html');

}
?>