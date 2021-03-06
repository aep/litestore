<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_get_zone_code.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_get_zone_code.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
    function xtc_get_zone_code($country_id, $zone_id, $default_zone) 
    {
    $zone_query = xtc_db_query("select zone_code from " . TABLE_ZONES . " where zone_country_id = '" . $country_id . "' and zone_id = '" . $zone_id . "'");
    $zone = xtc_db_fetch_array($zone_query);
    if ($zone) 
    {
      return $zone['zone_code'];
    } else {
      return $default_zone;
    }
  }
 ?>
