<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_random_select.inc.php 1108 2005-07-24 20:24:08Z hhgag $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_random_select.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
    function xtc_random_select($query) 
    {
        global $db;
        $random_product = '';
        $random_query = $db->query($query);
        $num_rows = $random_query->rowCount();
        if ($num_rows > 0) 
        {
            $random_row = xtc_rand(0, ($num_rows - 1));
            $random_product = $random_query->fetchAll();
            $random_product= $random_product[$random_row];
        }

    return $random_product;
  }
 ?>
