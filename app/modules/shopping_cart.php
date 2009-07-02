<?php

/* -----------------------------------------------------------------------------------------
   $Id: shopping_cart.php 1299 2005-10-09 18:54:29Z gwinger $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(shopping_cart.php,v 1.71 2003/02/14); www.oscommerce.com 
   (c) 2003	 nextcommerce (shopping_cart.php,v 1.24 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------
   Third Party contributions:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/



function module()
{

    global $breadcrumb;
    $smarty = new Smarty;

    $cart_empty = false;

    require_once (DIR_FS_INC.'xtc_array_to_string.inc.php');
    require_once (DIR_FS_INC.'xtc_recalculate_price.inc.php');
    
    
    $breadcrumb->add(NAVBAR_TITLE_SHOPPING_CART, '/cart');
    
    require (DIR_WS_INCLUDES.'header.php');
    
    if ($_SESSION['cart']->count_contents() > 0) 
    {
    
        $smarty->assign('FORM_ACTION', xtc_draw_form('cart_quantity', FILENAME_SHOPPING_CART, '?action=update_product'));
	    $smarty->assign('FORM_END', '</form>');
	    $hidden_options = xtc_draw_hidden_field('action', 'update_product');

	    $_SESSION['any_out_of_stock'] = 0;
        $_SESSION['allow_checkout'] = 'true';

	    $products = $_SESSION['cart']->get_products();
	    foreach ($products as $p) {
            if(!$p['status']){				    $_SESSION['allow_checkout'] = 'false';
                    break;
            }            
	    }
    
	    $smarty->assign('HIDDEN_OPTIONS', $hidden_options);
	    require (DIR_WS_MODULES.'order_details_cart.php');    
    // minimum/maximum order value
    $checkout = true;
    if ($_SESSION['cart']->show_total() > 0 ) {
    if ($_SESSION['cart']->show_total() < $_SESSION['customers_status']['customers_status_min_order'] ) {
    $_SESSION['allow_checkout'] = 'false';
    $more_to_buy = $_SESSION['customers_status']['customers_status_min_order'] - $_SESSION['cart']->show_total();
    $order_amount=$xtPrice->xtcFormat($more_to_buy, true);
    $min_order=$xtPrice->xtcFormat($_SESSION['customers_status']['customers_status_min_order'], true);
    $smarty->assign('info_message_1', MINIMUM_ORDER_VALUE_NOT_REACHED_1);
    $smarty->assign('info_message_2', MINIMUM_ORDER_VALUE_NOT_REACHED_2);
    $smarty->assign('order_amount', $order_amount);
    $smarty->assign('min_order', $min_order);
    }
    if  ($_SESSION['customers_status']['customers_status_max_order'] != 0) {
    if ($_SESSION['cart']->show_total() > $_SESSION['customers_status']['customers_status_max_order'] ) {
    $_SESSION['allow_checkout'] = 'false';
    $less_to_buy = $_SESSION['cart']->show_total() - $_SESSION['customers_status']['customers_status_max_order'];
    $max_order=$xtPrice->xtcFormat($_SESSION['customers_status']['customers_status_max_order'], true);
    $order_amount=$xtPrice->xtcFormat($less_to_buy, true);
    $smarty->assign('info_message_1', MAXIMUM_ORDER_VALUE_REACHED_1);
    $smarty->assign('info_message_2', MAXIMUM_ORDER_VALUE_REACHED_2);
    $smarty->assign('order_amount', $order_amount);
    $smarty->assign('min_order', $max_order);
    }
    }
    }
	    if ($_GET['info_message'])
		    $smarty->assign('info_message', str_replace('+', ' ', htmlspecialchars($_GET['info_message'])));
    } else {
    
	    // empty cart
	    $cart_empty = true;
	    if ($_GET['info_message'])
		    $smarty->assign('info_message', str_replace('+', ' ', htmlspecialchars($_GET['info_message'])));
	    $smarty->assign('cart_empty', $cart_empty);
    
    }
    $smarty->assign('ALLOW_CHECKOUT', $_SESSION['allow_checkout']);
    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = 0;
    return $smarty->fetch('module/shopping_cart.html');
}
?>
