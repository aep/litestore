<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_remove_non_numeric.inc.php 829 2005-03-12 21:34:16Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   by Mario Zanier for XTcommerce
   
   based on:
   (c) 2003	 nextcommerce (xtc_remove_non_numeric.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
function xtc_remove_non_numeric($var) 
	{	  
	  $var=ereg_replace('[^0-9]','',$var);
	  return $var;
     }
 ?>