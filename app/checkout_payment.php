<?php

/* -----------------------------------------------------------------------------------------
   $Id: checkout_payment.php 1325 2005-10-30 10:23:32Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_payment.php,v 1.110 2003/03/14); www.oscommerce.com
   (c) 2003	 nextcommerce (checkout_payment.php,v 1.20 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   agree_conditions_1.01        	Autor:	Thomas Pl�nkers (webmaster@oscommerce.at)

   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function module()
{
    $smarty=new Smarty;
    global $breadcrumb,$main,$order;

    require_once (DIR_FS_INC . 'xtc_get_address_format_id.inc.php');
    require_once (DIR_FS_INC . 'xtc_check_stock.inc.php');
    require_once (DIR_FS_INC . 'xtc_address_label.inc.php');
    require_once (DIR_WS_CLASSES . 'payment.php');
    require_once (DIR_WS_CLASSES . 'order.php');
    require_once (DIR_WS_CLASSES . 'order_total.php');



    unset ($_SESSION['tmp_oID']);
    // if the customer is not logged on, redirect them to the login page
    if (!isset ($_SESSION['customer_id'])) {
	    if (ACCOUNT_OPTIONS == 'guest') {
		    xtc_redirect(xtc_href_link(FILENAME_CREATE_GUEST_ACCOUNT, '', 'SSL'));
	    } else {
		    xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
	    }
    }
    
    // if there is nothing in the customers cart, redirect them to the shopping cart page
    if ($_SESSION['cart']->count_contents() < 1)
	    xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));
    
    // if no shipping method has been selected, redirect the customer to the shipping method selection page
    if (!isset ($_SESSION['shipping']))
	    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    
    // avoid hack attempts during the checkout procedure by checking the internal cartID
    if (isset ($_SESSION['cart']->cartID) && isset ($_SESSION['cartID'])) {
	    if ($_SESSION['cart']->cartID != $_SESSION['cartID'])
		    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    }
    
    if (isset ($_SESSION['credit_covers']))
	    unset ($_SESSION['credit_covers']); //ICW ADDED FOR CREDIT CLASS SYSTEM
    // Stock Check
    if ((STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true')) {
	    $products = $_SESSION['cart']->get_products();
	    $any_out_of_stock = 0;
	    for ($i = 0, $n = sizeof($products); $i < $n; $i++) {
		    if (xtc_check_stock($products[$i]['id'], $products[$i]['quantity']))
			    $any_out_of_stock = 1;
	    }
	    if ($any_out_of_stock == 1)
		    xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));
    
    }


    
    // if no billing destination address was selected, use the customers own address as default
    if (!isset ($_SESSION['billto'])) {
	    $_SESSION['billto'] = $_SESSION['customer_default_address_id'];
    } else {
	    // verify the selected billing address
	    $check_address_query = xtc_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int) $_SESSION['customer_id'] . "' and address_book_id = '" . (int) $_SESSION['billto'] . "'");
	    $check_address = xtc_db_fetch_array($check_address_query);
    
	    if ($check_address['total'] != '1') {
		    $_SESSION['billto'] = $_SESSION['customer_default_address_id'];
		    if (isset ($_SESSION['payment']))
			    unset ($_SESSION['payment']);
	    }
    }
    
    if (!isset ($_SESSION['sendto']) || $_SESSION['sendto'] == "")
	    $_SESSION['sendto'] = $_SESSION['billto'];


    if (isset ($_POST['payment']))
        $_SESSION['payment'] = xtc_db_prepare_input($_POST['payment']);
    
    if ($_POST['comments_added'] != '')
        $_SESSION['comments'] = xtc_db_prepare_input($_POST['comments']);


    $payment_modules = new payment($_SESSION['payment']);
    $payment_modules->update_status();

    $order = new order();
    $order_total_modules = new order_total();
    $order_total_modules->collect_posts();
    $order_total_modules->pre_confirmation_check();


    if (isset ($_SESSION['credit_covers']))
        $_SESSION['payment'] = 'no_payment'; 





    if (isset ($_POST['action']) && ($_POST['action'] == 'process')) 
    {

        $error='';


        if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') 
        {
            if ($_POST['conditions'] == false) 
            {
                $error=ERROR_CONDITIONS_NOT_ACCEPTED;
            }
            else
            {
                $_SESSION['conditions_accepted']=true;
            }
        }

        global $$_SESSION['payment'];
        if (
                (
                    is_array($payment_modules->modules)   && 
                    (sizeof($payment_modules->modules) > 1) && 
                    (!is_object($$_SESSION['payment'])) && 
                    (!isset ($_SESSION['credit_covers']))
                ) 
                    || (is_object($$_SESSION['payment']) && 
                        ($$_SESSION['payment']->enabled == false))
            ) 
        {
            $error=ERROR_NO_PAYMENT_MODULE_SELECTED;
        }


        if($error)
            $smarty->assign("error",$error);
        else
            xtc_redirect(FILENAME_CHECKOUT_CONFIRMATION);


    }









    $total_weight = $_SESSION['cart']->show_weight();
    
    //  $total_count = $_SESSION['cart']->count_contents();
    $total_count = $_SESSION['cart']->count_contents_virtual(); // GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
    
    if ($order->billing['country']['iso_code_2'] != '')
	    $_SESSION['delivery_zone'] = $order->billing['country']['iso_code_2'];
    
    // load all enabled payment modules
    $payment_modules = new payment;
    
    $order_total_modules->process();
    // redirect if Coupon matches ammount
    
    $breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_PAYMENT, xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    $breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_PAYMENT, xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
    
    $smarty->assign('FORM_ACTION', xtc_draw_form('checkout_payment', xtc_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post', 'onSubmit="return check_form();"'));
    $smarty->assign('ADDRESS_LABEL', xtc_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, ' ', '<br />'));
    
    
    
    $smarty->assign('FORM_END', '</form>');
    
    
    $payment_data=array();
    
    if ($order->info['total'] > 0) 
        {
	    if (isset ($_GET['payment_error']) && is_object(${ $_GET['payment_error'] }) && ($error = ${$_GET['payment_error']}->get_error())) 
        {
            $smarty->assign('error', htmlspecialchars($error['error']));
    
	    }
    
	    $selection = $payment_modules->selection();
    
	    $radio_buttons = 0;
	    for ($i = 0, $n = sizeof($selection); $i < $n; $i++) {
    
		    $selection[$i]['radio_buttons'] = $radio_buttons;
		    if (($selection[$i]['id'] == $payment) || ($n == 1)) {
			    $selection[$i]['checked'] = 1;
		    }
    
		    if (sizeof($selection) > 1) {
			    $selection[$i]['selection'] = xtc_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $_SESSION['payment']));
		    } else {
			    $selection[$i]['selection'] = xtc_draw_hidden_field('payment', $selection[$i]['id']);
		    }
    
		    if (isset ($selection[$i]['error'])) {
    
		    } else {
    
			    $radio_buttons++;
		    }
	    }
    
	    $payment_data=$selection;
    
    } else {
	    $smarty->assign('GV_COVER', 'true');
    }
    
    if (ACTIVATE_GIFT_SYSTEM == 'true') {
	    $smarty->assign('module_gift', $order_total_modules->credit_selection());
    }
    
    
    
    
    $smarty->assign('COMMENTS', xtc_draw_textarea_field('comments', 'soft', '60', '5', $_SESSION['comments']) . xtc_draw_hidden_field('comments_added', 'YES'));
    
    //check if display conditions on checkout page is true
    if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {
    
	    if (GROUP_CHECK == 'true') {
		    $group_check = "and group_ids LIKE '%c_" . $_SESSION['customers_status']['customers_status_id'] . "_group%'";
	    }
    
	    $shop_content_query = xtc_db_query("SELECT
	                                                    content_title,
	                                                    content_heading,
	                                                    content_text,
	                                                    content_file
	                                                    FROM " . TABLE_CONTENT_MANAGER . "
	                                                    WHERE content_group='3' " . $group_check . "
	                                                    AND languages_id='" . $_SESSION['languages_id'] . "'");
	    $shop_content_data = xtc_db_fetch_array($shop_content_query);
    
	    if ($shop_content_data['content_file'] != '') {
    
		    $conditions = '<iframe SRC="' . DIR_WS_CATALOG . 'media/content/' . $shop_content_data['content_file'] . '" width="100%" height="300">';
		    $conditions .= '</iframe>';
	    } else {
    
		    $conditions = '<textarea name="blabla" cols="60" rows="10" readonly="readonly">' . strip_tags(str_replace('<br />', "\n", $shop_content_data['content_text'])) . '</textarea>';
	    }
    
	    $smarty->assign('AGB', $conditions);
	    $smarty->assign('AGB_LINK', $main->getContentLink(3, MORE_INFO));
	    // LUUPAY ZAHLUNGSMODUL
	    if ($_SESSION['conditions_accepted']) {
		    $smarty->assign('AGB_checkbox', '<input type="checkbox" value="conditions" name="conditions" checked />');
	    } else {
		    $smarty->assign('AGB_checkbox', '<input type="checkbox" value="conditions" name="conditions" />');
	    }
	    // LUUPAY END
    
    }



    $smarty->assign('language', $_SESSION['language']);
    $smarty->assign('realm', "checkout");
    $smarty->assign('payment_data', $payment_data);
    $smarty->caching = 0;
    return $smarty->fetch(CURRENT_TEMPLATE . '/module/checkout_payment.html');
}
?>