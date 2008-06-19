<?php

/* -----------------------------------------------------------------------------------------
   $Id: shopping_cart.php 1281 2005-10-03 09:30:17Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce 
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


class BoxShoppingCart extends AbstractVCBox
{
    var $classid= "{1784e3c3-0000-4000-824f-76b767236621}";
    function __construct()
    {
    }

    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        if ($_SESSION['customers_status']['customers_status_show_price'] != 1)
            return;
        global $xtPrice;
        $box_smarty = new smarty;
        $box_smarty->assign('tpl_path', '/templates/'.CURRENT_TEMPLATE.'/');
        $box_content = '';
        $box_price_string = '';
        // include needed files
        require_once (DIR_FS_INC.'xtc_recalculate_price.inc.php');
        
        if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT) or strstr($PHP_SELF, FILENAME_CHECKOUT_CONFIRMATION) or strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING))
	        $box_smarty->assign('deny_cart', 'true');
        
        if ($_SESSION['cart']->count_contents() > 0) {
        
	        $products = $_SESSION['cart']->get_products();
        
	        $products_in_cart = array ();
	        $qty = 0;
	        for ($i = 0, $n = sizeof($products); $i < $n; $i ++) {
		        $qty += $products[$i]['quantity'];
		        $products_in_cart[] = array ('QTY' => $products[$i]['quantity'], 
									        'LINK' => "/products/".$products[$i]['id']."/".rawurlencode($products[$i]['name']), 
									        'NAME' => $products[$i]['name']);
        
	        }
	        $box_smarty->assign('PRODUCTS', $qty);
	        $box_smarty->assign('empty', 'false');
        } else {
	        // cart empty
	        $box_smarty->assign('empty', 'true');
        }
        
        if ($_SESSION['cart']->count_contents() > 0) {
	        
	        $total =$_SESSION['cart']->show_total();
        if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1' && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00') {
	        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		        $price = $total-$_SESSION['cart']->show_tax(false);
	        } else {
		        $price = $total;
	        }
	        $discount = $xtPrice->xtcGetDC($price, $_SESSION['customers_status']['customers_status_ot_discount']);
	        $box_smarty->assign('DISCOUNT', $xtPrice->xtcFormat(($discount * (-1)), $price_special = 1, $calculate_currencies = false));
	        
        }
        
        
        if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
	        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) $total-=$discount;
	        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) $total-=$discount;
	        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) $total-=$discount;
	        $box_smarty->assign('TOTAL', $xtPrice->xtcFormat($total, true));
        } 
	        
        
	        $box_smarty->assign('UST', $_SESSION['cart']->show_tax());
	        
	        if (SHOW_SHIPPING=='true') { 
			        $box_smarty->assign('SHIPPING_INFO',' '.SHIPPING_EXCL.'<a href="javascript:newWin=void(window.open(\''.FILENAME_POPUP_CONTENT. '/'.SHIPPING_INFOS.'\', \'popup\', \'toolbar=0, width=640, height=600\'))"> '.SHIPPING_COSTS.'</a>');	
	        }
        }
        if (ACTIVATE_GIFT_SYSTEM == 'true') {
	        $box_smarty->assign('ACTIVATE_GIFT', 'true');
        }
        

        // GV Code End
        $box_smarty->assign('LINK_CART', FILENAME_SHOPPING_CART);
        $box_smarty->assign('products', $products_in_cart);
        
        $box_smarty->caching = 0;
        $box_smarty->assign('language', $_SESSION['language']);
        $box_shopping_cart = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_cart.html');
        return $box_shopping_cart;
    }
}

?>