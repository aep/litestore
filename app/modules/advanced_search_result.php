<?php

/* -----------------------------------------------------------------------------------------
   $Id: advanced_search_result.php 1141 2005-08-10 11:31:36Z novalis $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2005 ReStore
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(advanced_search_result.php,v 1.68 2003/05/14); www.oscommerce.com
   (c) 2003	 nextcommerce (advanced_search_result.php,v 1.17 2003/08/21); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function module()
{
    global $breadcrumb,$product;
    $smarty=new Smarty();
    // include needed functions
    require_once (DIR_FS_INC.'xtc_parse_search_string.inc.php');
    require_once (DIR_FS_INC.'xtc_get_subcategories.inc.php');
    require_once (DIR_FS_INC.'xtc_get_currencies_values.inc.php');

    /*
    * check search entry
    */

    $error = 0; // reset error flag to false
    $errorno = 0;
    $keyerror = 0;

    if (isset ($_GET['keywords']) && empty ($_GET['keywords'])) {
        $keyerror = 1;
    }

    if ((isset ($_GET['keywords']) && empty ($_GET['keywords'])) && (isset ($_GET['pfrom']) && empty ($_GET['pfrom'])) && (isset ($_GET['pto']) && empty ($_GET['pto']))) {
        $errorno += 1;
        $error = 1;
    }
    elseif (isset ($_GET['keywords']) && empty ($_GET['keywords']) && !(isset ($_GET['pfrom'])) && !(isset ($_GET['pto']))) {
        $errorno += 1;
        $error = 1;
    }

    if (strlen($_GET['keywords']) < 3 && strlen($_GET['keywords']) > 0 && $error == 0) {
        $errorno += 1;
        $error = 1;
        $keyerror = 1;
    }

    if (strlen($_GET['pfrom']) > 0) {
        $pfrom_to_check = xtc_db_input($_GET['pfrom']);
        if (!settype($pfrom_to_check, "double")) {
            $errorno += 10000;
            $error = 1;
        }
    }

    if (strlen($_GET['pto']) > 0) {
        $pto_to_check = $_GET['pto'];
        if (!settype($pto_to_check, "double")) {
            $errorno += 100000;
            $error = 1;
        }
    }

    if (strlen($_GET['pfrom']) > 0 && !(($errorno & 10000) == 10000) && strlen($_GET['pto']) > 0 && !(($errorno & 100000) == 100000)) {
        if ($pfrom_to_check > $pto_to_check) {
            $errorno += 1000000;
            $error = 1;
        }
    }

    if (strlen($_GET['keywords']) > 0) {
        if (!xtc_parse_search_string(stripslashes($_GET['keywords']), $search_keywords)) {
            $errorno += 10000000;
            $error = 1;
            $keyerror = 1;
        }
    }

    if ($error == 1 && $keyerror != 1) {

        xtc_redirect(xtc_href_link(FILENAME_ADVANCED_SEARCH, 'errorno='.$errorno.'&'.xtc_get_all_get_params(array ('x', 'y'))));

    } else {

        /*
        *    search process starts here
        */

        $breadcrumb->add('Suchergebnis', '');


        require (DIR_WS_INCLUDES.'header.php');

        // define additional filters //

        //fsk18 lock
        if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
            $fsk_lock = " AND p.products_fsk18 != '1' ";
        } else {
            unset ($fsk_lock);
        }

        //group check
        if (GROUP_CHECK == 'true') {
            $group_check = " AND p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
        } else {
            unset ($group_check);
        }

        //manufacturers if set
        if (isset ($_GET['manufacturers_id']) && xtc_not_null($_GET['manufacturers_id'])) {
            $manu_check = " AND p.manufacturers_id = '".(int)$_GET['manufacturers_id']."' ";
        }

        //include subcategories if needed
        if (isset ($_GET['categories_id']) && xtc_not_null($_GET['categories_id'])) {
            if ($_GET['inc_subcat'] == '1') {
                $subcategories_array = array ();
                xtc_get_subcategories($subcategories_array, (int)$_GET['categories_id']);
                $subcat_join = " LEFT OUTER JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." AS p2c ON (p.products_id = p2c.products_id) ";
                $subcat_where = " AND p2c.categories_id IN ('".(int) $_GET['categories_id']."' ";
                foreach ($subcategories_array AS $scat) {
                    $subcat_where .= ", '".$scat."'";
                }
                $subcat_where .= ") ";
            } else {
                $subcat_join = " LEFT OUTER JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." AS p2c ON (p.products_id = p2c.products_id) ";
                $subcat_where = " AND p2c.categories_id = '".(int) $_GET['categories_id']."' ";
            }
        }else {
            $subcat_join = "  JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." AS p2c ON (p.products_id = p2c.products_id) ";
        }

        if ($_GET['pfrom'] || $_GET['pto']) {
            $rate = xtc_get_currencies_values($_SESSION['currency']);
            $rate = $rate['value'];
            if ($rate && $_GET['pfrom'] != '') {
                $pfrom = $_GET['pfrom'] / $rate;
            }
            if ($rate && $_GET['pto'] != '') {
                $pto = $_GET['pto'] / $rate;
            }
        }

        //price filters
        if (($pfrom != '') && (is_numeric($pfrom))) {
            $pfrom_check = " AND (IF(s.status = '1' AND p.products_id = s.products_id, s.specials_new_products_price, p.products_price) >= ".$pfrom.") ";
        } else {
            unset ($pfrom_check);
        }

        if (($pto != '') && (is_numeric($pto))) {
            $pto_check = " AND (IF(s.status = '1' AND p.products_id = s.products_id, s.specials_new_products_price, p.products_price) <= ".$pto." ) ";
        } else {
            unset ($pto_check);
        }

        //build query
        $select_str = "SELECT distinct
                      p.products_id,
                      p.products_price,
                      p.products_model,
                      p.products_quantity,
                      p.products_shippingtime,
                      p.products_fsk18,
                      p.products_weight,
                      p.products_tax_class_id,
                      p.products_trading_unit,
                      pd.products_name,
                      pd.products_short_description,
                      pd.products_description ";

        $from_str  = "FROM ".TABLE_PRODUCTS." AS p LEFT JOIN ".TABLE_PRODUCTS_DESCRIPTION." AS pd ON (p.products_id = pd.products_id) ";
        $from_str .= $subcat_join;
        if (SEARCH_IN_ATTR == 'true') {
            $from_str .= " LEFT OUTER JOIN ".TABLE_PRODUCTS_ATTRIBUTES." AS pa ON (p.products_id = pa.products_id) LEFT OUTER JOIN ".TABLE_PRODUCTS_OPTIONS_VALUES." AS pov ON (pa.options_values_id = pov.products_options_values_id) ";
        }
        $from_str .= "LEFT OUTER JOIN ".TABLE_SPECIALS." AS s ON (p.products_id = s.products_id) AND s.status = '1'";

        if ((DISPLAY_PRICE_WITH_TAX == 'true') && ((isset ($_GET['pfrom']) && xtc_not_null($_GET['pfrom'])) || (isset ($_GET['pto']) && xtc_not_null($_GET['pto'])))) {
            if (!isset ($_SESSION['customer_country_id'])) {
                $_SESSION['customer_country_id'] = STORE_COUNTRY;
                $_SESSION['customer_zone_id'] = STORE_ZONE;
            }
            $from_str .= " LEFT OUTER JOIN ".TABLE_TAX_RATES." tr ON (p.products_tax_class_id = tr.tax_class_id) LEFT OUTER JOIN ".TABLE_ZONES_TO_GEO_ZONES." gz ON (tr.tax_zone_id = gz.geo_zone_id) ";
            $tax_where = " AND (gz.zone_country_id IS NULL OR gz.zone_country_id = '0' OR gz.zone_country_id = '".(int) $_SESSION['customer_country_id']."') AND (gz.zone_id is null OR gz.zone_id = '0' OR gz.zone_id = '".(int) $_SESSION['customer_zone_id']."')";
        } else {
            unset ($tax_where);
        }

        //where-string
        $where_str = " WHERE p.products_status = '1' "." AND pd.languages_id = '".(int) $_SESSION['languages_id']."'".$subcat_where.$fsk_lock.$manu_check.$group_check.$tax_where.$pfrom_check.$pto_check;

        //go for keywords... this is the main search process
        if (isset ($_GET['keywords']) && xtc_not_null($_GET['keywords'])) {
            if (xtc_parse_search_string(stripslashes($_GET['keywords']), $search_keywords)) {
                $where_str .= " AND ( ";
                for ($i = 0, $n = sizeof($search_keywords); $i < $n; $i ++) {
                    switch ($search_keywords[$i]) {
                    case '(' :
                    case ')' :
                    case 'and' :
                    case 'or' :
                        $where_str .= " ".$search_keywords[$i]." ";
                        break;
                    default :
                        $where_str .= " ( ";
                        $where_str .= "pd.products_keywords LIKE ('%".addslashes($search_keywords[$i])."%') ";
                        if (SEARCH_IN_DESC == 'true') {
                            $where_str .= "OR pd.products_description LIKE ('%".addslashes($search_keywords[$i])."%') ";
                            $where_str .= "OR pd.products_short_description LIKE ('%".addslashes($search_keywords[$i])."%') ";
                        }
                        $where_str .= "OR pd.products_name LIKE ('%".addslashes($search_keywords[$i])."%') ";
                        $where_str .= "OR p.products_model LIKE ('%".addslashes($search_keywords[$i])."%') ";
                        if (SEARCH_IN_ATTR == 'true') {
                            $where_str .= "OR (pov.products_options_values_name LIKE ('%".addslashes($search_keywords[$i])."%') ";
                            $where_str .= "AND pov.languages_id = '".(int) $_SESSION['languages_id']."')";
                        }
                        $where_str .= " ) ";
                        break;
                    }
                }
                $where_str .= " ) GROUP BY p.products_id ORDER BY p.products_id ";
            }
        }

        //glue together
        $listing_sql = $select_str.$from_str.$where_str;
        require (DIR_WS_MODULES.FILENAME_PRODUCT_LISTING);
        return $module;
    }
}
?>
