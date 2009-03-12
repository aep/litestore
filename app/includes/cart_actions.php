<?php

/* -----------------------------------------------------------------------------------------
   $Id: cart_actions.php 1298 2005-10-09 13:14:44Z mz $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_top.php,v 1.273 2003/05/19); www.oscommerce.com
   (c) 2003         nextcommerce (application_top.php,v 1.54 2003/08/25); www.nextcommerce.org

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Add A Quickie v1.0 Autor  Harald Ponce de Leon

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


// Shopping cart actions


if (isset ($_GET['action']))
    $cartaction=$_GET['action'];
else if (isset ($_POST['action']))
    $cartaction=$_POST['action'];


if (isset($cartaction))
{
    // redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled
    if ($session_started == false) 
    {
        xtc_redirect(FILENAME_COOKIE_USAGE);
    }

    if (DISPLAY_CART == 'true') 
    {
        $goto = FILENAME_SHOPPING_CART;
        $parameters = array (
            'action',
            'cPath',
            'products_id',
            'pid'
        );
    } 
    else 
    {
        $goto = $_GET["path"];
        if ($_GET['action'] == 'buy_now' ) 
        {
            $parameters = array (
                'action',
                'pid',
                'products_id',
                'BUYproducts_id'
            );
        } 
        else 
        {
            $parameters = array (
                'action',
                'pid',
                'BUYproducts_id',
                'info'
            );
        }
    }

    switch ($cartaction) 
    {
        // customer wants to update the product quantity in their shopping cart
        case 'update_product' :


        for ($i = 0, $n = sizeof($_POST['products_id']); $i < $n; $i++) 
            {
                if (in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array ()))) 
                {
                    $_SESSION['cart']->remove($_POST['products_id'][$i]);

                    if (is_object($econda))
                        $econda->_delArticle($_POST['products_id'][$i], $_POST['cart_quantity'][$i], $_POST['old_qty'][$i]);

                } 
                else 
                {
                    if ($_POST['cart_quantity'][$i] > MAX_PRODUCTS_QTY)
                        $_POST['cart_quantity'][$i] = MAX_PRODUCTS_QTY;
                    $attributes = ($_POST['id'][$_POST['products_id'][$i]]) ? $_POST['id'][$_POST['products_id'][$i]] : '';

                    if (is_object($econda)) 
                    {
                        $old_quantity = $_SESSION['cart']->get_quantity(xtc_get_uprid($_POST['products_id'][$i], $_POST['id'][$i]));
                        $econda->_updateProduct($_POST['products_id'][$i], $_POST['cart_quantity'][$i], $old_quantity);
                    }

                    $_SESSION['cart']->add_cart((int)$_POST['products_id'][$i], xtc_remove_non_numeric($_POST['cart_quantity'][$i]), $attributes, false);
                }
			}
			xtc_redirect($goto. xtc_get_all_get_params($parameters));
			break;
			// customer adds a product from the products page
		case 'add_product' :
			if (isset ($_POST['products_id']) && is_numeric($_POST['products_id'])) {
				if ($_POST['products_qty'] > MAX_PRODUCTS_QTY)
					$_POST['products_qty'] = MAX_PRODUCTS_QTY;

				if (is_object($econda)) {
					$econda->_emptyCart();
					$old_quantity = $_SESSION['cart']->get_quantity(xtc_get_uprid($_POST['products_id'], $_POST['id']));
					$econda->_addProduct($_POST['products_id'], $_POST['products_qty'], $old_quantity);
				}

				$_SESSION['cart']->add_cart((int) $_POST['products_id'], $_SESSION['cart']->get_quantity(xtc_get_uprid($_POST['products_id'], $_POST['id'])) + xtc_remove_non_numeric($_POST['products_qty']), $_POST['id']);
			}
			xtc_redirect($goto. xtc_get_all_get_params($parameters));
			break;

		case 'check_gift' :
			require_once (DIR_FS_INC . 'xtc_collect_posts.inc.php');
			xtc_collect_posts();
			break;

		case 'buy_now' :
			if (isset ($_GET['BUYproducts_id'])) {
				// check permission to view product

				$permission_query = xtc_db_query("SELECT products_fsk18,products_trading_unit from " . TABLE_PRODUCTS . " where products_id='" . (int) $_GET['BUYproducts_id'] . "'");
				$permission = xtc_db_fetch_array($permission_query);

				// check for FSK18
				if ($permission['products_fsk18'] == '1' && $_SESSION['customers_status']['customers_fsk18'] == '1') {
					xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id'], 'NONSSL'));
				}
				if ($_SESSION['customers_status']['customers_fsk18_display'] == '0' && $permission['products_fsk18'] == '1') {
					xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id'], 'NONSSL'));
				}

				if (GROUP_CHECK == 'true') {

					if ($permission['customer_group'] != '1') {
						xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id']));
					}
				}
				
            if (isset ($_SESSION['cart'])) {

                    $quantity=$permission['products_trading_unit'];
                    if(!$quantity)
                        $quantity=1;


                $_SESSION['cart']->add_cart((int) $_GET['BUYproducts_id'], $_SESSION['cart']->get_quantity((int) $_GET['BUYproducts_id']) +$quantity  );
				} 
                else 
                {
                    xtc_redirect(FILENAME_DEFAULT);
                }
			}
			xtc_redirect($goto);
			break;
		case 'cust_order' :
			if (isset ($_SESSION['customer_id']) && isset ($_GET['pid'])) {
				if (xtc_has_product_attributes((int) $_GET['pid'])) {
					xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['pid']));
				} else {
					$_SESSION['cart']->add_cart((int) $_GET['pid'], $_SESSION['cart']->get_quantity((int) $_GET['pid']) + $_GET['products_trading_unit']);
				}
			}
			xtc_redirect(xtc_href_link($goto, xtc_get_all_get_params($parameters)));
			break;
	}
}
?>
