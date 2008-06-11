<?php

/* -----------------------------------------------------------------------------------------
   $Id: account.php 1124 2005-07-28 08:50:04Z mz $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (account.php,v 1.59 2003/05/19); www.oscommerce.com
   (c) 2003      nextcommerce (account.php,v 1.12 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/



function module()
{
    global $breadcrumb, $messageStack,$product;
    $smarty = new Smarty;

    
    require_once (DIR_FS_INC.'xtc_count_customer_orders.inc.php');
    require_once (DIR_FS_INC.'xtc_date_short.inc.php');
    require_once (DIR_FS_INC.'xtc_get_path.inc.php');
    require_once (DIR_FS_INC.'xtc_get_product_path.inc.php');
    require_once (DIR_FS_INC.'xtc_get_products_name.inc.php');
    
    $breadcrumb->add(NAVBAR_TITLE_ACCOUNT, FILENAME_ACCOUNT);
    
    require (DIR_WS_INCLUDES.'header.php');
    
    if ($messageStack->size('account') > 0)
	    $smarty->assign('error_message', $messageStack->output('account'));
    
    $i = 0;
    $max = count($_SESSION['tracking']['products_history']);
    
    while ($i < $max) {
    
	    
	    $product_history_query = xtDBquery("select * from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_id=pd.products_id and pd.language_id='".(int) $_SESSION['languages_id']."' and p.products_status = '1' and p.products_id = '".$_SESSION['tracking']['products_history'][$i]."'");
	    $history_product = xtc_db_fetch_array($product_history_query, true);
    $cpath = xtc_get_product_path($_SESSION['tracking']['products_history'][$i]);
	    if ($history_product['products_status'] != 0) {
    
		    $history_product = array_merge($history_product,array('cat_url' => FILENAME_DEFAULT.'?cPath='.$cpath));
		    $products_history[] = $product->buildDataArray($history_product);
	    }
	    $i ++;
    }
    
    $order_content = '';
    if (xtc_count_customer_orders() > 0) {
    
	    $orders_query = xtc_db_query("select
	                                    o.orders_id,
	                                    o.date_purchased,
                                        o.orders_date_finished,
	                                    o.delivery_name,
	                                    o.delivery_country,
	                                    o.billing_name,
	                                    o.billing_country,
	                                    ot.text as order_total,
	                                    s.orders_status_name
	                                    from ".TABLE_ORDERS." o, ".TABLE_ORDERS_TOTAL."
	                                    ot, ".TABLE_ORDERS_STATUS." s
	                                    where o.customers_id = '".(int) $_SESSION['customer_id']."'
	                                    and o.orders_id = ot.orders_id
	                                    and ot.class = 'ot_total'
	                                    and o.orders_status = s.orders_status_id
	                                    and s.language_id = '".(int) $_SESSION['languages_id']."'
	                                    order by orders_id desc limit 3");
    
	    while ($orders = xtc_db_fetch_array($orders_query)) {
		    if (xtc_not_null($orders['delivery_name'])) {
			    $order_name = $orders['delivery_name'];
			    $order_country = $orders['delivery_country'];
		    } else {
			    $order_name = $orders['billing_name'];
			    $order_country = $orders['billing_country'];
		    }
		    $order_content[] = array 
            (
                'ORDER_ID' => $orders['orders_id'], 
                'ORDER_DATE' => xtc_date_short($orders['date_purchased']), 
                'ORDER_STATUS' => $orders['orders_status_name'], 
                'ORDER_TOTAL' => $orders['order_total'], 
                'ORDER_LINK' => FILENAME_ACCOUNT_HISTORY_INFO.'/'.$orders['orders_id'], 
                'ORDER_BUTTON' => '<a href="'.FILENAME_ACCOUNT_HISTORY_INFO. '/'.$orders['orders_id'].'">'. SMALL_IMAGE_BUTTON_VIEW.'</a>',
                'ORDER_FINISHED' => $orders['orders_date_finished']
    
            );
	    }
    
    }


    $smarty->assign('tpl_path','/templates/'.CURRENT_TEMPLATE.'/');
    $smarty->assign('LINK_EDIT', FILENAME_ACCOUNT_EDIT);
    $smarty->assign('LINK_ADDRESS', FILENAME_ADDRESS_BOOK);
    $smarty->assign('LINK_PASSWORD', FILENAME_ACCOUNT_PASSWORD);
    if (!isset ($_SESSION['customer_id']))
	    $smarty->assign('LINK_LOGIN',FILENAME_LOGIN);
    $smarty->assign('LINK_ORDERS', FILENAME_ACCOUNT_HISTORY);
    $smarty->assign('LINK_NEWSLETTER', FILENAME_NEWSLETTER);
    $smarty->assign('LINK_ALL', FILENAME_ACCOUNT_HISTORY);
    $smarty->assign('order_content', $order_content);
    $smarty->assign('products_history', $products_history);
    $smarty->assign('also_purchased_history', $also_purchased_history);
    $smarty->assign('language', $_SESSION['language']);
    
    $smarty->caching = 0;
    return $smarty->fetch(CURRENT_TEMPLATE.'/module/account.html');
}
?>