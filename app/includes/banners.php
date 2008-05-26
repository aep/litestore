<?php
/* -----------------------------------------------------------------------------------------
   $Id: banners.php 899 2005-04-29 02:40:57Z hhgag $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


  require_once(DIR_FS_INC . 'xtc_banner_exists.inc.php');
  require_once(DIR_FS_INC . 'xtc_display_banner.inc.php');
  require_once(DIR_FS_INC . 'xtc_update_banner_display_count.inc.php');


  if ($banner = xtc_banner_exists('dynamic', 'banner')) {
  $smarty->assign('BANNER',xtc_display_banner('static', $banner));

  }
?>