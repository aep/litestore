<?php

/* -----------------------------------------------------------------------------------------
   $Id: order_details_cart.php 1281 2005-10-03 09:30:17Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(order_details.php,v 1.8 2003/05/03); www.oscommerce.com 
   (c) 2003	 nextcommerce (order_details.php,v 1.16 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

global $xtPrice;

$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
require_once (DIR_FS_INC . 'xtc_draw_input_field.inc.php');
require_once (DIR_FS_INC.'xtc_check_stock.inc.php');
require_once (DIR_FS_INC.'xtc_get_products_stock.inc.php');
require_once (DIR_FS_INC.'xtc_remove_non_numeric.inc.php');
require_once (DIR_FS_INC.'xtc_get_short_description.inc.php');
require_once (DIR_FS_INC.'xtc_format_price.inc.php');
require_once (DIR_FS_INC.'xtc_get_attributes_model.inc.php');

$module_content = array ();
$any_out_of_stock = false;
$mark_stock = '';

for ($i = 0, $n = sizeof($products); $i < $n; $i ++) 
{

    //stock and active check
    $product_active=1;
    global $db,$providerDb;
    $q=null;
    if ($providerDb) {
        $q = $providerDb->prepare("select products_quantity,products_status from products where products_model = ?");
        $q->execute(array($products[$i]['model']));
        $q=$q->fetch();
    }
    else {
        $q = $db->prepare("select products_quantity,products_status from products where products_id = ?");
        $q->execute(array($products[$i]['id']));
        $q=$q->fetch();
    }

    if(!$q['products_status']){
        $product_active=0;
        $any_out_of_stock =true;
        $_SESSION['allow_checkout'] = 'false';
    }

    if (CHECK_STOCK_QUANTITY != '0') {        if(($q['products_quantity']-$products[$i]['quantity'])<0){
	        $product_active=0;
            $any_out_of_stock =true;
	         $_SESSION['allow_checkout'] = 'false';
        }
    }




    $image = '';
    if ($products[$i]['image'] != '') 
    {
        $image = DIR_WS_THUMBNAIL_IMAGES.$products[$i]['image'];
    }


    $PRODUCTS_IMAGES=array();
    $imagesq=xtDBquery("select  url_big,url_middle,url_small  from products_images where products_id=".$products[$i]["id"]);
    while ($ik= xtc_db_fetch_array($imagesq,true))
    {
        $PRODUCTS_IMAGES[]=$ik;
    }

        

    $veq = xtc_db_fetch_array(xtc_db_query("select products_trading_unit,products_status from ".TABLE_PRODUCTS." where products_id='". $products[$i]['id']."'"));

    $module_content[$i] = array 
    (
        'PRODUCTS_ID' => $products[$i]['id'],
        'PRODUCTS_STATUS' => $product_active,
        'PRODUCTS_NAME' => $products[$i]['name'].$mark_stock, 
        'PRODUCTS_QTY' => $products[$i]['quantity'],
        'PRODUCTS_MODEL'=>$products[$i]['model'],
        'PRODUCTS_SHIPPING_TIME'=>$products[$i]['shipping_time'],
        'PRODUCTS_TAX' => number_format($products[$i]['tax'], TAX_DECIMAL_PLACES), 
        'PRODUCTS_IMAGES'=> $PRODUCTS_IMAGES,
        'IMAGE_ALT' => $products[$i]['name'], 
        'BOX_DELETE' => xtc_draw_checkbox_field('cart_delete[]', $products[$i]['id']), 
        'PRODUCTS_LINK' => "/products/".$products[$i]['id'], 
        'PRODUCTS_PRICE' => $xtPrice->xtcFormat($products[$i]['price'] * $products[$i]['quantity'], true), 
        'PRODUCTS_SINGLE_PRICE' =>$xtPrice->xtcFormat($products[$i]['price'], true), 
        'PRODUCTS_SHORT_DESCRIPTION' => xtc_get_short_description($products[$i]['id']),
        'PRODUCTS_TRADING_UNIT' => $veq["products_trading_unit"],
        'ATTRIBUTES' => ''
    );

	// Product options names
	$attributes_exist = ((isset ($products[$i]['attributes'])) ? 1 : 0);

	if ($attributes_exist == 1) {
		reset($products[$i]['attributes']);

		while (list ($option, $value) = each($products[$i]['attributes'])) {

			if (ATTRIBUTE_STOCK_CHECK == 'true' && STOCK_CHECK == 'true') {
				$attribute_stock_check = xtc_check_stock_attributes($products[$i][$option]['products_attributes_id'], $products[$i]['quantity']);
				if ($attribute_stock_check)
					$_SESSION['any_out_of_stock'] = 1;
			}

			$module_content[$i]['ATTRIBUTES'][] = array ('ID' => $products[$i][$option]['products_attributes_id'], 'MODEL' => xtc_get_attributes_model(xtc_get_prid($products[$i]['id']), $products[$i][$option]['products_options_values_name'],$products[$i][$option]['products_options_name']), 'NAME' => $products[$i][$option]['products_options_name'], 'VALUE_NAME' => $products[$i][$option]['products_options_values_name'].$attribute_stock_check);

		}
	}

}

$total_content = '';
$total =$_SESSION['cart']->show_total();
if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1' && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		$price = $total-$_SESSION['cart']->show_tax(false);
	} else {
		$price = $total;
	}
	$discount = $xtPrice->xtcGetDC($price, $_SESSION['customers_status']['customers_status_ot_discount']);
	$total_content = $_SESSION['customers_status']['customers_status_ot_discount'].' % '.SUB_TITLE_OT_DISCOUNT.' -'.xtc_format_price($discount, $price_special = 1, $calculate_currencies = false).'<br />';
}

if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) $total-=$discount;
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) $total-=$discount;
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) $total-=$discount;
	$total_content .= SUB_TITLE_SUB_TOTAL.$xtPrice->xtcFormat($total, true).'<br />';
} else {
	$total_content .= NOT_ALLOWED_TO_SEE_PRICES.'<br />';
}
// display only if there is an ot_discount
if ($customer_status_value['customers_status_ot_discount'] != 0) {
	$total_content .= TEXT_CART_OT_DISCOUNT.$customer_status_value['customers_status_ot_discount'].'%';
}
if (SHOW_SHIPPING == 'true') {
	$module_smarty->assign('SHIPPING_INFO', ' '.SHIPPING_EXCL.'<a href="/content//Shipping"> '.SHIPPING_COSTS.'</a>');
}
if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
$module_smarty->assign('UST_CONTENT', $_SESSION['cart']->show_tax());
}

$module_smarty->assign('MAX_PRODUCTS_QTY', MAX_PRODUCTS_QTY);
$module_smarty->assign('TOTAL_CONTENT', $total_content);
$module_smarty->assign('language', $_SESSION['language']);
$module_smarty->assign('module_content', $module_content);

$module_smarty->caching = 0;

$module = $module_smarty->fetch('module/order_details.html');

$smarty->assign('MODULE_order_details', $module);
?>
