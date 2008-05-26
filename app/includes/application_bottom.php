<?php
/* -----------------------------------------------------------------------------------------
   $Id: application_bottom.php 1239 2005-09-24 20:09:56Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_bottom.php,v 1.14 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (application_bottom.php,v 1.6 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


if ((GZIP_COMPRESSION == 'true') && ($ext_zlib_loaded == true) && ($ini_zlib_output_compression < 1)) {
	if ((PHP_VERSION < '4.0.4') && (PHP_VERSION >= '4')) {
		xtc_gzip_output(GZIP_LEVEL);
	}
}
if (TRACKING_ECONDA_ACTIVE == 'true') {
	require_once (DIR_WS_INCLUDES . 'econda/econda.php');
}
echo '</body></html>';
?>