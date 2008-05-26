<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_word_count.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce 
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_word_count.inc.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  // Get the number of times a word/character is present in a string
  function xtc_word_count($string, $needle) {
    $temp_array = split($needle, $string);

    return sizeof($temp_array);
  }
?>