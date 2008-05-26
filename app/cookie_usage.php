<?php

/* -----------------------------------------------------------------------------------------
   $Id: cookie_usage.php 1238 2005-09-24 10:51:19Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cookie_usage.php,v 1.1 2003/03/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (cookie_usage.php,v 1.9 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');


$breadcrumb->add(NAVBAR_TITLE_COOKIE_USAGE, xtc_href_link(FILENAME_COOKIE_USAGE));

require (DIR_WS_INCLUDES.'header.php');

$smarty->assign('BUTTON_CONTINUE', '<a href="'.xtc_href_link(FILENAME_DEFAULT).'">'.IMAGE_BUTTON_CONTINUE.'</a>');
$smarty->assign('language', $_SESSION['language']);

// set cache ID
 if (!CacheCheck()) {
	$smarty->caching = 0;
	$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/cookie_usage.html');
} else {
	$smarty->caching = 1;
	$smarty->cache_lifetime = CACHE_LIFETIME;
	$smarty->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/cookie_usage.html', $cache_id);
}

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>