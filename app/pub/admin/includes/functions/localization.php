<?php
/* --------------------------------------------------------------
   $Id: localization.php 950 2005-05-14 16:45:21Z mz $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(localization.php,v 1.12 2003/06/25); www.oscommerce.com
   (c) 2003	 nextcommerce (localization.php,v 1.4 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------*/
defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
  function quote_oanda_currency($code, $base = DEFAULT_CURRENCY) {
    $page = file('http://www.oanda.com/convert/fxdaily?value=1&redirected=1&exch=' . $code .  '&format=CSV&dest=Get+Table&sel_list=' . $base);

    $match = array();

    preg_match('/(.+),(\w{3}),([0-9.]+),([0-9.]+)/i', implode('', $page), $match);

    if (sizeof($match) > 0) {
      return $match[3];
    } else {
      return false;
    }
  }

  function quote_xe_currency($to, $from = DEFAULT_CURRENCY) {
    $page = file('http://www.xe.net/ucc/convert.cgi?Amount=1&From=' . $from . '&To=' . $to);

    $match = array();

    preg_match('/[0-9.]+\s*' . $from . '\s*=\s*([0-9.]+)\s*' . $to . '/', implode('', $page), $match);

    if (sizeof($match) > 0) {
      return $match[1];
    } else {
      return false;
    }
  }
?>