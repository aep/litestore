<?php

/* -----------------------------------------------------------------------------------------
   $Id: index.php 1321 2005-10-26 20:55:07Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(default.php,v 1.84 2003/05/07); www.oscommerce.com
   (c) 2003	 nextcommerce (default.php,v 1.13 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS :    http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function module()
{
    global $breadcrumb,$cPath,$cPath_array,$current_category_id,$product,$category_depth;
    $smarty=new Smarty;
    $breadcrumb->add(HEADER_TITLE_CATALOG, "/catalog");
    $breadcrumb->addCategory($cPath_array);

    $category_depth = 'top';

    require (DIR_WS_INCLUDES.'header.php');

    if (!isset ($cPath) && !xtc_not_null($cPath))
    {
        xtc_redirect(FILENAME_DEFAULT);
        return;
    }


    $default_smarty = new smarty;
    $default_smarty->assign('tpl_path', '/templates/'.CURRENT_TEMPLATE.'/');
    $default_smarty->assign('session', session_id());


    require_once (DIR_FS_INC.'xtc_get_path.inc.php');
    require_once (DIR_FS_INC.'xtc_check_categories_status.inc.php');



    if (xtc_check_categories_status($current_category_id) >= 1) 
    {
        $error = CATEGORIE_NOT_FOUND;
        include (DIR_WS_MODULES.FILENAME_ERROR_HANDLER);
        return;
    }


    $categories_products_query = 
            "select count(*) as total from ".TABLE_PRODUCTS_TO_CATEGORIES." where categories_id = '".$current_category_id."'";
    $cateqories_products = xtc_db_fetch_array(xtDBquery($categories_products_query), true);


    $category_parent_query = 
            "select count(*) as total from ".TABLE_CATEGORIES." where parent_id = '".$current_category_id."'";
    $category_parent = xtc_db_fetch_array(xtDBquery($category_parent_query),true);




    ///-------- display products   ---------- ///
    if ($cateqories_products['total'] > 0)
    {
        //fsk18 lock
        $fsk_lock = '';
        if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') 
        {
            $fsk_lock = ' and p.products_fsk18!=1';
        }


        $sorting_data = xtc_db_fetch_array(xtDBquery("SELECT products_sorting,
                                            products_sorting2 FROM ".TABLE_CATEGORIES."
                                            where categories_id='".$current_category_id."'"),true);

        if (!$sorting_data['products_sorting'])
        {
            $sorting_data['products_sorting'] = 'pd.products_name';
        }
        $sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';


        $manufacturers_q='';
        if (isset ($_GET['manufacturers_id'])) 
        {
            $manufacturers_q = "and p.manufacturers_id = '".(int) $_GET['manufacturers_id']."'";
        }

        $listing_sql = "(SELECT
            p.products_fsk18,
            p.products_shippingtime,
            p.products_model,
            p.products_ean,
            pd.products_name,
            m.manufacturers_name,
            p.products_quantity,
            p.products_weight,
            pd.products_short_description,
            pd.products_description,
            p.products_id,
            p.manufacturers_id,
            p.products_price,
            p.products_vpe_id,
            p.products_vpe_status,
            p.products_vpe_value,
            p.products_discount_allowed,
            p.products_tax_class_id
            FROM  "
            .TABLE_PRODUCTS_DESCRIPTION." pd, "
            .TABLE_PRODUCTS_TO_CATEGORIES." p2c, "
            .TABLE_PRODUCTS." p left join ".TABLE_MANUFACTURERS." m on p.manufacturers_id = m.manufacturers_id
            left join ".TABLE_SPECIALS." s on p.products_id = s.products_id
            WHERE
            p.products_status = '1'
            and p.products_id = p2c.products_id
            and pd.products_id = p2c.products_id
            ".$group_check."
            ".$fsk_lock."
            ".$manufacturers_q."
            and pd.languages_id = '".(int) $_SESSION['languages_id']."'
            and p2c.categories_id = '".$current_category_id."') 
            UNION DISTINCT
            (SELECT DISTINCT
            p.products_fsk18,
            p.products_shippingtime,
            p.products_model,
            p.products_ean,
            pd.products_name,
            m.manufacturers_name,
            p.products_quantity,
            p.products_weight,
            pd.products_short_description,
            pd.products_description,
            p.products_id,
            p.manufacturers_id,
            p.products_price,
            p.products_vpe_id,
            p.products_vpe_status,
            p.products_vpe_value,
            p.products_discount_allowed,
            p.products_tax_class_id
            FROM  "
            .TABLE_CATEGORIES." c, ibc_original_supplies_to_devices  ibc_os2d, "
            ."ibc_alternative_supplies_to_original_supplies ibc_as2os, "
            .TABLE_PRODUCTS_DESCRIPTION." pd, "
            .TABLE_PRODUCTS." p left join ".TABLE_MANUFACTURERS." m on p.manufacturers_id = m.manufacturers_id
            left join ".TABLE_SPECIALS." s on p.products_id = s.products_id
            WHERE
            c.categories_id = '".$current_category_id."'
            and c.ibc_devices = ibc_os2d.ibc_devices
            and ibc_os2d.ibc_original_supplies = ibc_as2os.ibc_original_supplies
            and ibc_as2os.ibc_alternative_supplies = p.ibc_supplies
            and p.products_status = '1'
            and pd.products_id = p.products_id
            and pd.languages_id = '".(int) $_SESSION['languages_id']."'
            ".$group_check."
            ".$fsk_lock."
            ".$manufacturers_q."
            )";

        $module="";
        include (DIR_WS_MODULES.FILENAME_PRODUCT_LISTING);
        return $module;

    } 
    ///-------- display sub categories   ---------- ///
    else if ($category_parent['total'] > 0)
    {
        if (GROUP_CHECK == 'true')
        {
            $group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
        }
        $category_query = "select
            cd.categories_description,
            cd.categories_name,
            c.categories_teaser,
            cd.categories_heading_title,
            c.categories_template,
            c.categories_image from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
            where c.categories_id = '".$current_category_id."'
            and cd.categories_id = '".$current_category_id."'
            ".$group_check."
            and cd.languages_id = '".(int) $_SESSION['languages_id']."'";

        $category =xtc_db_fetch_array(xtDBquery($category_query));
        if (isset ($cPath) && ereg('_', $cPath)) 
        {
            //check to see if there are deeper categories within the current category
            $category_links = array_reverse($cPath_array);
            for ($i = 0, $n = sizeof($category_links); $i < $n; $i ++) 
            {
                if (GROUP_CHECK == 'true') 
                {
                    $group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
                }
                $categories_query = "select cd.categories_description,
                                            c.categories_id,
                                            cd.categories_name,
                                            cd.categories_heading_title,
                                            c.categories_image,
                                            c.parent_id from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
                                            where c.categories_status = '1'
                                            and c.parent_id = '".$category_links[$i]."'
                                            and c.categories_id = cd.categories_id
                                            ".$group_check."
                                            and cd.languages_id = '".(int) $_SESSION['languages_id']."'
                                            order by sort_order, cd.categories_name";
                $categories_query = xtDBquery($categories_query);

                if (xtc_db_num_rows($categories_query, true) < 1) 
                {
                    // do nothing, go through the loop
                } 
                else 
                {
                    break; // we've found the deepest category the customer is in
                }
            }
        } 
        else 
        {
            if (GROUP_CHECK == 'true') 
            {
                $group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
            }
                $categories_query = "select cd.categories_description,
                                        c.categories_id,
                                        cd.categories_name,
                                        cd.categories_heading_title,
                                        c.categories_image,
                                        c.parent_id from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
                                        where c.categories_status = '1'
                                        and c.parent_id = '".$current_category_id."'
                                        and c.categories_id = cd.categories_id
                                        ".$group_check."
                                        and cd.languages_id = '".(int) $_SESSION['languages_id']."'
                                        order by sort_order, cd.categories_name";


                $categories_query = xtDBquery($categories_query);
        }




        $rows = 0;
        while ($categories = xtc_db_fetch_array($categories_query, true)) 
        {
            $rows ++;
            if($cPath_array)
                $cPath_new = "/catalog/".implode("/",$cPath_array)."/".$categories['categories_id'];
            else
                $cPath_new = "/catalog/".$categories['categories_id'];

            $width = (int) (100 / MAX_DISPLAY_CATEGORIES_PER_ROW).'%';
            $image = '';
            if ($categories['categories_image'] != '') 
            {
                $image = DIR_WS_IMAGES.'categories/'.$categories['categories_image'];
            }

            $categories_content[] = array 
            (
                'CATEGORIES_NAME' => $categories['categories_name'], 
                'CATEGORIES_HEADING_TITLE' => $categories['categories_heading_title'], 
                'CATEGORIES_IMAGE' => $image,
                'CATEGORIES_LINK' => $cPath_new, 
                'CATEGORIES_DESCRIPTION' => $categories['categories_description']
            );
        }


        $new_products_category_id = $current_category_id;
        include (DIR_WS_MODULES.FILENAME_NEW_PRODUCTS);

        $image = '';
        if ($category['categories_image'] != '') 
        {
            $image = DIR_WS_IMAGES.'categories/'.$category['categories_image'];
        }
        $default_smarty->assign('CATEGORIES_NAME', $category['categories_name']);
        $default_smarty->assign('CATEGORIES_HEADING_TITLE', $category['categories_heading_title']);

        $default_smarty->assign('CATEGORIES_IMAGE', $image);
        $default_smarty->assign('CATEGORIES_DESCRIPTION', $category['categories_description']);


        if ($category['categories_teaser'] != '')
            $default_smarty->assign('CATEGORIES_TEASER',DIR_WS_IMAGES.'categories_teaser/'.$category['categories_teaser']);
        $default_smarty->assign('language', $_SESSION['language']);
        $default_smarty->assign('module_content', $categories_content);


        $default_smarty->caching = 0;
        return $default_smarty->fetch(CURRENT_TEMPLATE.'/module/categorie_listing.html');
    }
    else
    {
        xtc_redirect(FILENAME_DEFAULT);
    }
}
?>