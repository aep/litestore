<?php
function module()
{
    global $xtPrice, $main;
    global $_SESSION;
    global $product;
    global $db;


    if (!is_object($product) || !$product->isProduct()){
        // product not found in database
        $error = TEXT_PRODUCT_NOT_FOUND;
        include (DIR_WS_MODULES.FILENAME_ERROR_HANDLER);
    }
    else
    {
        //increase  viewed counter
        $q=$db->prepare("update products_description set products_viewed = products_viewed+1 where products_id = ? and languages_id = ?");
        $q->execute(array($product->data['products_id'],$_SESSION['languages_id']));

        $info_smarty = new Smarty;

        $info_smarty->assign('PRODUCTS_ID', $product->data['products_id']);
        $info_smarty->assign('PRODUCTS_NAME', $product->data['products_name']);

        $products_price = $xtPrice->xtcGetPrice($product->data['products_id'], $format = true, 1, $product->data['products_tax_class_id'], $product->data['products_price'], 1);
        $info_smarty->assign('PRODUCTS_PRICE', $products_price['formated']);

        $products_prices = $xtPrice->xtcGetPrices($product->data['products_id'],$_SESSION['customers_status']['customers_status_id'],
                                                  $format = true, 1, $product->data['products_tax_class_id'], $product->data['products_price'], 1);
        $info_smarty->assign('PRODUCTS_PRICES', $products_prices);


        // check if customer is allowed to add to cart
        if ($_SESSION['customers_status']['customers_status_show_price'] != '0'){
            if ($_SESSION['customers_status']['customers_fsk18'] == '1') {
                if ($product->data['products_fsk18'] == '0'){
                    $info_smarty->assign('ADD_CART_BUTTON', true);
                }
            }
            else{
                $info_smarty->assign('ADD_CART_BUTTON', true);
            }
        }

        if ($product->data['products_fsk18'] == '1'){
            $info_smarty->assign('PRODUCTS_FSK18', 'true');
        }


        $info_smarty->assign('SHIPPING_NAME', $main->getShippingStatusName($product->data['products_shippingtime']));
        $info_smarty->assign('SHIPPING_IMAGE', $main->getShippingStatusImage($product->data['products_shippingtime']));


        if ($product->data['products_vpe_status'] == 1 && $product->data['products_vpe_value'] != 0.0 && $products_price['plain'] > 0){
            $info_smarty->assign('PRODUCTS_VPE', $xtPrice->xtcFormat($products_price['plain'] *
                (1 / $product->data['products_vpe_value']), true).TXT_PER.xtc_get_vpe_name($product->data['products_vpe_id']));
        }


        if ($_SESSION['customers_status']['customers_status_show_price'] != 0) {
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


        $q=$db->prepare("select  url_big,url_small  from products_images where products_id=? order by image_nr");
        $q->execute(array($product->data["products_id"]));
        $q=$q->fetchAll();
        $info_smarty->assign('PRODUCTS_IMAGES',$q);
        $info_smarty->assign('PRODUCTS_IMAGES_COUNT', count($q));


        $info_smarty->assign('MAX_PRODUCTS_QTY', MAX_PRODUCTS_QTY);
        $info_smarty->assign('language', $_SESSION['language']);
        $info_smarty->caching = 0;
        return $info_smarty->fetch('module/product_info.html');
    }
}



?>
