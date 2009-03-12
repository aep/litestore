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
    
	    $products = $_SESSION['cart']->get_products();
	    for ($i = 0, $n = sizeof($products); $i < $n; $i ++) {
		    // Push all attributes information in an array
		    if (isset ($products[$i]['attributes'])) {
			    while (list ($option, $value) = each($products[$i]['attributes'])) {
				    $hidden_options .= xtc_draw_hidden_field('id['.$products[$i]['id'].']['.$option.']', $value);
				    $attributes = xtc_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix,pa.attributes_stock,pa.products_attributes_id,pa.attributes_model
				                                        from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_OPTIONS_VALUES." poval, ".TABLE_PRODUCTS_ATTRIBUTES." pa
				                                        where pa.products_id = '".$products[$i]['id']."'
				                                        and pa.options_id = '".$option."'
				                                        and pa.options_id = popt.products_options_id
				                                        and pa.options_values_id = '".$value."'
				                                        and pa.options_values_id = poval.products_options_values_id
				                                        and popt.languages_id = '".(int) $_SESSION['languages_id']."'
				                                        and poval.languages_id = '".(int) $_SESSION['languages_id']."'");
				    $attributes_values = xtc_db_fetch_array($attributes);
    
				    $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
				    $products[$i][$option]['options_values_id'] = $value;
				    $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
				    $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
				    $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
				    $products[$i][$option]['weight_prefix'] = $attributes_values['weight_prefix'];
				    $products[$i][$option]['options_values_weight'] = $attributes_values['options_values_weight'];
				    $products[$i][$option]['attributes_stock'] = $attributes_values['attributes_stock'];
				    $products[$i][$option]['products_attributes_id'] = $attributes_values['products_attributes_id'];
				    $products[$i][$option]['products_attributes_model'] = $attributes_values['products_attributes_model'];
			    }
		    }
	    }
    
	    $smarty->assign('HIDDEN_OPTIONS', $hidden_options);
	    require (DIR_WS_MODULES.'order_details_cart.php');
    $_SESSION['allow_checkout'] = 'true';
	    if (STOCK_CHECK == 'true') {
		    if ($_SESSION['any_out_of_stock'] == 1) {
			    if (STOCK_ALLOW_CHECKOUT == 'true') {
				    // write permission in session
				    $_SESSION['allow_checkout'] = 'true';
    
				    $smarty->assign('info_message', OUT_OF_STOCK_CAN_CHECKOUT);
    
			    } else {
				    $_SESSION['allow_checkout'] = 'false';
				    $smarty->assign('info_message', OUT_OF_STOCK_CANT_CHECKOUT);
    
			    }
		    } else {
			    $_SESSION['allow_checkout'] = 'true';
		    }
	    }
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

    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = 0;
    return $smarty->fetch('module/shopping_cart.html');
}
?>
