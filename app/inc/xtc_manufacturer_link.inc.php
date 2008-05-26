<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_manufacturer_link.inc.php 899 2005-04-29 02:40:57Z hhgag $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2005 ReStore

 
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function xtc_manufacturer_link($mID,$mName='') {
		$mName = xtc_cleanName($mName);
		$link = 'manu=m'.$mID.'_'.$mName.'.html';
		return $link;
}
?>