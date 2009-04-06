<?php

/* -----------------------------------------------------------------------------------------
   $Id: shop_content.php 1303 2005-10-12 16:47:31Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(conditions.php,v 1.21 2003/02/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (shop_content.php,v 1.1 2003/08/19); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require_once (DIR_WS_CLASSES.'azrael.php');

function module()
{
    global $breadcrumb;
    global $APP_PATH;
    global $_GET;
    global $azrael;
    $breadcrumb->add($APP_PATH[3], $_GET["path"]);

    if($APP_PATH[2]==='')
    {
        return $azrael->renderPreset($APP_PATH[3]);
    }
    else
    {
        return $azrael->renderID((int)$APP_PATH[2]);
    }
}
?>
