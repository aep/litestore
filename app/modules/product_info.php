<?php
/* -----------------------------------------------------------------------------------------
$Id: product_info.php 1317 2005-10-21 16:03:18Z mz $   

ReStore - an XT-Commerce fork to restore sanity
http://www.xt-commerce.com

Copyright (c) 2003 XT-Commerce
-----------------------------------------------------------------------------------------
based on: 
(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
(c) 2002-2003 osCommerce(product_info.php,v 1.94 2003/05/04); www.oscommerce.com 
(c) 2003      nextcommerce (product_info.php,v 1.46 2003/08/25); www.nextcommerce.org

Released under the GNU General Public License 
-----------------------------------------------------------------------------------------
Third Party contribution:
Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
New Attribute Manager v4b                            Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com   
Cross-Sell (X-Sell) Admin 1                          Autor: Joshua Dechant (dreamscape)
Released under the GNU General Public License
---------------------------------------------------------------------------------------*/

//include needed functions
require_once (DIR_FS_INC.'xtc_check_categories_status.inc.php');
require_once (DIR_FS_INC.'xtc_get_vpe_name.inc.php');
require_once (DIR_FS_INC.'get_cross_sell_name.inc.php');
require_once (DIR_FS_INC.'xtc_get_download.inc.php');
require_once (DIR_FS_INC.'xtc_delete_file.inc.php');
require_once (DIR_FS_INC.'xtc_get_all_get_params.inc.php');
require_once (DIR_FS_INC.'xtc_date_long.inc.php');
require_once (DIR_FS_INC.'xtc_draw_hidden_field.inc.php');
require_once (DIR_FS_INC.'xtc_draw_form.inc.php');
require_once (DIR_FS_INC.'xtc_draw_input_field.inc.php');

function module()
{
    global $breadcrumb;
    global $APP_PATH;
    global $_GET;
    global $product;

    $info_smarty = new Smarty;
    $group_check = '';



    global $breadcrumb ,$xtPrice, $main;

    if (!is_object($product) || !$product->isProduct()) 
    { // product not found in database

        $error = TEXT_PRODUCT_NOT_FOUND;
        include (DIR_WS_MODULES.FILENAME_ERROR_HANDLER);

    } 
    else 
    {
        if (ACTIVATE_NAVIGATOR == 'true')
        include (DIR_WS_MODULES.'product_navigator.php');

        xtc_db_query("update ".TABLE_PRODUCTS_DESCRIPTION." set products_viewed = products_viewed+1 where products_id = '".$product->data['products_id']."' and languages_id = '".$_SESSION['languages_id']."'");


        $products_price = $xtPrice->xtcGetPrice($product->data['products_id'], $format = true, 1, $product->data['products_tax_class_id'], $product->data['products_price'], 1);

        // check if customer is allowed to add to cart
        if ($_SESSION['customers_status']['customers_status_show_price'] != '0') 
        {
        // fsk18
            if ($_SESSION['customers_status']['customers_fsk18'] == '1') 
            {
                if ($product->data['products_fsk18'] == '0') 
                {
                    $info_smarty->assign('ADD_QTY', xtc_draw_input_field('products_qty',  
                        $product->data['products_trading_unit'], 'size="5"').' '.xtc_draw_hidden_field('products_id', $product->data['products_id']));
                    $info_smarty->assign('ADD_CART_BUTTON', true);
                }
            } 
            else 
            {
                $info_smarty->assign('ADD_CART_BUTTON', true);
            }
        }

        if ($product->data['products_fsk18'] == '1') 
        {
            $info_smarty->assign('PRODUCTS_FSK18', 'true');
        }
        if (ACTIVATE_SHIPPING_STATUS == 'true') 
        {
            $info_smarty->assign('SHIPPING_NAME', $main->getShippingStatusName($product->data['products_shippingtime']));
            $info_smarty->assign('SHIPPING_IMAGE', $main->getShippingStatusImage($product->data['products_shippingtime']));
        }
        $info_smarty->assign('FORM_ACTION', FILENAME_PRODUCT_INFO."?". xtc_get_all_get_params(array ('action')).'&amp;action=add_product');
        $info_smarty->assign('FORM_END', '</form>');
        $info_smarty->assign('PRODUCTS_PRICE', $products_price['formated']);
        if ($product->data['products_vpe_status'] == 1 && $product->data['products_vpe_value'] != 0.0 && $products_price['plain'] > 0)
        {
            $info_smarty->assign('PRODUCTS_VPE', $xtPrice->xtcFormat($products_price['plain'] * 
                (1 / $product->data['products_vpe_value']), true).TXT_PER.xtc_get_vpe_name($product->data['products_vpe_id']));
        }
        $info_smarty->assign('PRODUCTS_ID', $product->data['products_id']);
        $info_smarty->assign('PRODUCTS_NAME', $product->data['products_name']);
        if ($_SESSION['customers_status']['customers_status_show_price'] != 0) 
        {
            // price incl tax
            $tax_rate = $xtPrice->TAX[$product->data['products_tax_class_id']];				
            $tax_info = $main->getTaxInfo($tax_rate);
            $info_smarty->assign('PRODUCTS_TAX_INFO', $tax_info);
            $info_smarty->assign('PRODUCTS_SHIPPING_LINK',$main->getShippingLink());
        }
        $info_smarty->assign('PRODUCTS_TRADING_UNIT', $product->data['products_trading_unit']);
        $info_smarty->assign('PRODUCTS_TRADING_UNIT_NAME', $product->data['products_trading_unit_name']);
        $info_smarty->assign('PRODUCTS_MODEL', $product->data['products_model']);
        $info_smarty->assign('PRODUCTS_EAN', $product->data['products_ean']);
        $info_smarty->assign('PRODUCTS_QUANTITY', $product->data['products_quantity']);
        $info_smarty->assign('PRODUCTS_WEIGHT', $product->data['products_weight']);
        $info_smarty->assign('PRODUCTS_STATUS', $product->data['products_status']);
        $info_smarty->assign('PRODUCTS_ORDERED', $product->data['products_ordered']);
        $info_smarty->assign('PRODUCTS_DESCRIPTION', stripslashes($product->data['products_description']));
        $image = '';
        if ($product->data['products_image'] != '')
        {
            $image = DIR_WS_INFO_IMAGES.$product->data['products_image'];
        }

        $info_smarty->assign('PRODUCTS_IMAGE', $image);

        //mo_images - by Novalis@eXanto.de
        if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') 
        {
            $connector = '/';
        }
        else
        {
            $connector = '&amp;';
        }
        $info_smarty->assign('PRODUCTS_POPUP_LINK', 
            'javascript:popupWindow(\''.FILENAME_POPUP_IMAGE. '&amp;pID='.$product->data['products_id'].$connector.'&amp;imgID=0'.'\')');


        $PRODUCTS_IMAGES=array();


        $imagesq=xtDBquery("select  url_big,url_small  from products_images where products_id='".$product->data["products_id"]."' order by image_nr");
        while ($ik= xtc_db_fetch_array($imagesq,true))
        {
            $PRODUCTS_IMAGES[]=$ik;
        }

        $info_smarty->assign('PRODUCTS_IMAGES', $PRODUCTS_IMAGES);
        $info_smarty->assign('PRODUCTS_IMAGES_COUNT', count($PRODUCTS_IMAGES));



        //mo_images EOF
        $discount = 0.00;
        if ($_SESSION['customers_status']['customers_status_public'] == 1 && $_SESSION['customers_status']['customers_status_discount'] != '0.00') 
        {
            $discount = $_SESSION['customers_status']['customers_status_discount'];
            if ($product->data['products_discount_allowed'] < $_SESSION['customers_status']['customers_status_discount'])
                $discount = $product->data['products_discount_allowed'];
            if ($discount != '0.00')
                $info_smarty->assign('PRODUCTS_DISCOUNT', $discount.'%');
        }



        include (DIR_WS_MODULES.'product_attributes.php');
        include (DIR_WS_MODULES.'product_reviews.php');



        if (xtc_not_null($product->data['products_url']))
        {
            $info_smarty->assign('PRODUCTS_URL', sprintf(TEXT_MORE_INFORMATION, 
                xtc_href_link(FILENAME_REDIRECT, 'action=product&amp;id='.$product->data['products_id'], 'NONSSL', true, false)));
        }



        if ($product->data['products_date_available'] > date('Y-m-d H:i:s')) 
        {
            $info_smarty->assign('PRODUCTS_DATE_AVIABLE', sprintf(TEXT_DATE_AVAILABLE, xtc_date_long($product->data['products_date_available'])));



        } 
        else 
        {
            if ($product->data['products_date_added'] != '0000-00-00 00:00:00')
            {
                $info_smarty->assign('PRODUCTS_ADDED', sprintf(TEXT_DATE_ADDED, xtc_date_long($product->data['products_date_added'])));
            }

        }

        if ($_SESSION['customers_status']['customers_status_graduated_prices'] == 1)
        {
            include (DIR_WS_MODULES.FILENAME_GRADUATED_PRICE);
        }


//        include (DIR_WS_MODULES.FILENAME_PRODUCTS_MEDIA);
//        include (DIR_WS_MODULES.FILENAME_ALSO_PURCHASED_PRODUCTS);
//        include (DIR_WS_MODULES.FILENAME_CROSS_SELLING);




        $i = count($_SESSION['tracking']['products_history']);
        if ($i > 6) 
        {
            array_shift($_SESSION['tracking']['products_history']);
            $_SESSION['tracking']['products_history'][6] = $product->data['products_id'];
            $_SESSION['tracking']['products_history'] = array_unique($_SESSION['tracking']['products_history']);
        } 
        else 
        {
            $_SESSION['tracking']['products_history'][$i] = $product->data['products_id'];
            $_SESSION['tracking']['products_history'] = array_unique($_SESSION['tracking']['products_history']);
        }



        $info_smarty->assign('MAX_PRODUCTS_QTY', MAX_PRODUCTS_QTY);
        $info_smarty->assign('language', $_SESSION['language']);
        $info_smarty->caching = 0;
        return $info_smarty->fetch('module/product_info.html');
    }
}



?>
