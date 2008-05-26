<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_draw_separator.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_draw_separator.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Output a separator either through whitespace, or with an image
  function xtc_draw_separator($image = 'pixel_black.gif', $width = '100%', $height = '1') {
    return xtc_image(DIR_WS_IMAGES . $image, '', $width, $height);
  }
 ?>