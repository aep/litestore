<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout_success.php 896 2005-04-27 19:22:59Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_success.php,v 1.48 2003/02/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (checkout_success.php,v 1.14 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

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
    global $breadcrumb;
    $smarty = new Smarty;
    // if the customer is not logged on, redirect them to the shopping cart page
    if (!isset ($_SESSION['customer_id'])) 
    {
        xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));
    }
        $breadcrumb->add("willkommen");    
    require (DIR_WS_INCLUDES.'header.php');

    // Google Conversion tracking

    if (GOOGLE_CONVERSION == 'true') 
    {
	    $smarty->assign('google_tracking', 'true');
	    $smarty->assign('tracking_code', GOOGLE_CONVERSION_REGISTER);
    }

    $smarty->assign('language', $_SESSION['language']);
    $smarty->assign('realm', "account");
    $smarty->caching = 0;
    return $smarty->fetch('module/wellcome.html');
}
?>
