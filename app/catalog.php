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
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function module()
{
    global $breadcrumb,$cPath,$cPath_array,$current_category_id,$product,$category_depth;
    $smarty=new Smarty;
    // $breadcrumb->add(HEADER_TITLE_CATALOG, "/catalog");
    $breadcrumb->addCategory($cPath_array);
    // add category names or the manufacturer name to the breadcrumb trail
    
    
    // the following cPath references come from application_top.php
    $category_depth = 'top';
    
    
    require (DIR_WS_INCLUDES.'header.php');
    
    if (isset ($cPath) && xtc_not_null($cPath)) 
    {
        $categories_products_query = "select count(*) as total from ".TABLE_PRODUCTS_TO_CATEGORIES." where categories_id = '".$current_category_id."'";
        $categories_products_query = xtDBquery($categories_products_query);
        $cateqories_products = xtc_db_fetch_array($categories_products_query, true);
        if ($cateqories_products['total'] > 0) 
        {
            $category_depth = 'products'; // display products
        } 
        else 
        {
            $category_parent_query = "select count(*) as total from ".TABLE_CATEGORIES." where parent_id = '".$current_category_id."'";
            $category_parent_query = xtDBquery($category_parent_query);
            $category_parent = xtc_db_fetch_array($category_parent_query, true);
            if ($category_parent['total'] > 0) 
            {
                $category_depth = 'nested'; // navigate through the categories
            } 
            else 
            {
                $category_depth = 'products'; // category has no products, but display the 'no products' message
            }
        }
        $module='';
        include (DIR_WS_MODULES.'default.php');
        return $module;
    }
    else
    {
        return $smarty->_tpl_vars['box_CATEGORIES'];
    }
}
?>