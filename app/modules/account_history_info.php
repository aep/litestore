<?php

/* -----------------------------------------------------------------------------------------
   $Id: account_history_info.php 1309 2005-10-17 08:01:11Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_history_info.php,v 1.97 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (account_history_info.php,v 1.17 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function module()
{
    $smarty = new Smarty;
    global $breadcrumb,$APP_PATH;

    $_GET['order_id']=$APP_PATH[4];

    require_once (DIR_FS_INC.'xtc_date_short.inc.php');
    require_once (DIR_FS_INC.'xtc_get_all_get_params.inc.php');
    require_once (DIR_FS_INC.'xtc_display_tax_value.inc.php');
    require_once (DIR_FS_INC.'xtc_format_price_order.inc.php');
    
    //security checks
    if (!isset ($_SESSION['customer_id'])) { xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL')); }
    if (!isset ($_GET['order_id']) || (isset ($_GET['order_id']) && !is_numeric($_GET['order_id']))) { 
    xtc_redirect(FILENAME_ACCOUNT_HISTORY);
    }
    $customer_info_query = xtc_db_query("select customers_id from ".TABLE_ORDERS." where orders_id = '".(int) $_GET['order_id']."'");
    $customer_info = xtc_db_fetch_array($customer_info_query);
    if ($customer_info['customers_id'] != $_SESSION['customer_id']) { xtc_redirect(FILENAME_ACCOUNT_HISTORY); }
    
    $breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO, FILENAME_ACCOUNT);
    $breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO, FILENAME_ACCOUNT_HISTORY);
    $breadcrumb->add(sprintf(NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO, (int)$_GET['order_id']), FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.(int)$_GET['order_id']);
    
    require (DIR_WS_CLASSES.'order.php');
    $order = new order((int)$_GET['order_id']);
    
    // Delivery Info
    if ($order->delivery != false) {
	    $smarty->assign('DELIVERY_LABEL', xtc_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'));
	    if ($order->info['shipping_method']) { $smarty->assign('SHIPPING_METHOD', $order->info['shipping_method']); }
    }
    
    $order_total = $order->getTotalData((int)$_GET['order_id']); 
    
    $smarty->assign('order_data', $order->getOrderData((int)$_GET['order_id']));
    $smarty->assign('order_total', $order_total['data']);
    
    // Payment Method
    if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
	    include (DIR_WS_LANGUAGES.'/'.$_SESSION['language'].'/modules/payment/'.$order->info['payment_method'].'.php');
	    $smarty->assign('PAYMENT_METHOD', constant(MODULE_PAYMENT_.strtoupper($order->info['payment_method'])._TEXT_TITLE));
    }
    
    
    
    // Order History
    $history_block = '<table summary="order history">';
    $statuses_query = xtc_db_query("select os.orders_status_name, osh.date_added, osh.comments from ".TABLE_ORDERS_STATUS." os, ".TABLE_ORDERS_STATUS_HISTORY." osh where osh.orders_id = '".(int) $_GET['order_id']."' and osh.orders_status_id = os.orders_status_id and os.languages_id = '".(int) $_SESSION['languages_id']."' order by osh.date_added");
    while ($statuses = xtc_db_fetch_array($statuses_query)) {
	    $history_block .= '              <tr>'."\n".'                <td style="vertical-align:top;">'.xtc_date_short($statuses['date_added']).'</td>'."\n".'                <td style="vertical-align:top;">'.$statuses['orders_status_name'].'</td>'."\n".'                <td style="vertical-align:top;">'. (empty ($statuses['comments']) ? '&nbsp;' : nl2br(htmlspecialchars($statuses['comments']))).'</td>'."\n".'              </tr>'."\n";
    }
    $history_block .= '</table>';
    $smarty->assign('HISTORY_BLOCK', $history_block);
    
    // Download-Products
    if (DOWNLOAD_ENABLED == 'true') include (DIR_WS_MODULES.'downloads.php');
    
    // Stuff
    $smarty->assign('ORDER_NUMBER', (int)$_GET['order_id']);
    $smarty->assign('ORDER_DATE', xtc_date_long($order->info['date_purchased']));
    $smarty->assign('ORDER_STATUS', $order->info['orders_status']);
    $smarty->assign('BILLING_LABEL', xtc_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'));
    $smarty->assign('PRODUCTS_EDIT', FILENAME_SHOPPING_CART);
    $smarty->assign('SHIPPING_ADDRESS_EDIT', FILENAME_CHECKOUT_SHIPPING_ADDRESS);
    $smarty->assign('BILLING_ADDRESS_EDIT', FILENAME_CHECKOUT_PAYMENT_ADDRESS);
    $smarty->assign('BUTTON_PRINT', '<a style="cursor:pointer" onclick="javascript:window.open(\''.FILENAME_PRINT_ORDER.'?oID='.(int)$_GET['order_id'].'\', \'popup\', \'toolbar=0, width=640, height=600\')"><img src="'.'templates/'.CURRENT_TEMPLATE.'/buttons/'.$_SESSION['language'].'/button_print.gif"/></a>');
    
    $from_history = eregi("page=", xtc_get_all_get_params()); // referer from account_history yes/no
    $back_to = $from_history ? FILENAME_ACCOUNT_HISTORY : FILENAME_ACCOUNT; // if from account_history => return to account_history
    $smarty->assign('BUTTON_BACK','<a href="' . $back_to,xtc_get_all_get_params(array ('order_id')) . '">' .IMAGE_BUTTON_BACK. '</a>');
    

    $smarty->assign('tpl_path','/templates/'.CURRENT_TEMPLATE.'/');

    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = 0;
    return $smarty->fetch('module/account_history_info.html');
}
?>
