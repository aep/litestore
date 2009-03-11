<?php
/* --------------------------------------------------------------
   $Id: column_left.php 1231 2005-09-21 13:05:36Z mz $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(column_left.php,v 1.15 2002/01/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (column_left.php,v 1.25 2003/08/19); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  $admin_access_query = xtc_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . $_SESSION['customer_id'] . "'");
  $admin_access = xtc_db_fetch_array($admin_access_query); 


?>
<div id="sidebar">

<img src="/admin/images/logo.png">


<div class="dataTableHeadingContent"><b>About</b></div>
<a class="menuBoxContentLink" href="/admin/start.php" class="headerLink">-Start</a>
<a class="menuBoxContentLink" href="/" class="headerLink">-Shop</a>
<a class="menuBoxContentLink" href="/admin/credits.php" class="headerLink">-Credits</a>
<a class="menuBoxContentLink" href="/logout" class="headerLink">-Logout</a>

<?php

  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_CUSTOMERS.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CUSTOMERS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CUSTOMERS . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers_status'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CUSTOMERS_STATUS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CUSTOMERS_STATUS . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['orders'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_ORDERS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ORDERS . '</a>';
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_unsold_carts'] == '1')) echo '<a href="' . xtc_href_link("stats_unsold_carts.php", '', 'NONSSL') . '" class="menuBoxContentLink"> -Offene Warenk&ouml;rbe </a>';

  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_PRODUCTS.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['categories'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CATEGORIES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CATEGORIES . '</a>';
/*  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['new_attributes'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_NEW_ATTRIBUTES, '', 'NONSSL') . '" class="menuBoxContentLink"> -'.BOX_ATTRIBUTES_MANAGER.'</a>';*/
/*  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_attributes'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PRODUCTS_ATTRIBUTES . '</a>';*/
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['manufacturers'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_MANUFACTURERS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_MANUFACTURERS . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['specials'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_SPECIALS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_SPECIALS . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_expected'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_PRODUCTS_EXPECTED, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PRODUCTS_EXPECTED . '</a>';

  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_MODULES.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_MODULES, 'set=payment', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PAYMENT . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_MODULES, 'set=shipping', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_SHIPPING . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_MODULES, 'set=ordertotal', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ORDER_TOTAL . '</a>';
//   if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_export'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_MODULE_EXPORT) . '" class="menuBoxContentLink"> -' . BOX_MODULE_EXPORT . '</a>';

  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_STATISTICS.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_products_viewed'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_STATS_PRODUCTS_VIEWED, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PRODUCTS_VIEWED . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_products_purchased'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PRODUCTS_PURCHASED . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_customers'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_STATS_CUSTOMERS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_STATS_CUSTOMERS . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_sales_report'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_SALES_REPORT, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_SALES_REPORT . '</a>';
/*  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_campaigns'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CAMPAIGNS_REPORT, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CAMPAIGNS_REPORT . '</a>';*/
  

  
  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_TOOLS.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_newsletter'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_MODULE_NEWSLETTER) . '" class="menuBoxContentLink"> -' . BOX_MODULE_NEWSLETTER . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['content_manager'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CONTENT_MANAGER) . '" class="menuBoxContentLink"> -' . BOX_CONTENT . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['blacklist'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_BLACKLIST, '', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_TOOLS_BLACKLIST . '</a>';

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['banner_manager'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_BANNER_MANAGER) . '" class="menuBoxContentLink"> -' . BOX_BANNER_MANAGER . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['adsense'] == '1')) echo '<a href="/admin/adsense.php" class="menuBoxContentLink"> -Google Adsense</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['adwords'] == '1')) echo '<a href="/admin/adwords.php" class="menuBoxContentLink"> -Google Adwords</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['export'] == '1')) echo '<a href="' . xtc_href_link('export.php') . '" class="menuBoxContentLink"> -Export</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['csv_backend'] == '1')) echo '<a href="' . xtc_href_link('csv_backend.php') . '" class="menuBoxContentLink"> -Import</a>';


if (ACTIVATE_GIFT_SYSTEM=='true') {
  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_GV_ADMIN.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['coupon_admin'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_COUPON_ADMIN, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_COUPON_ADMIN . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_queue'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_GV_QUEUE, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_GV_ADMIN_QUEUE . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_mail'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_GV_MAIL, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_GV_ADMIN_MAIL . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_sent'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_GV_SENT, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_GV_ADMIN_SENT . '</a>';
  }

  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_ZONE.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['countries'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_COUNTRIES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_COUNTRIES . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['currencies'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CURRENCIES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CURRENCIES. '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['zones'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_ZONES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ZONES . '</a>';
 if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['geo_zones'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_GEO_ZONES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_GEO_ZONES . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['tax_classes'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_TAX_CLASSES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_TAX_CLASSES . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['tax_rates'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_TAX_RATES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_TAX_RATES . '</a>';


  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_CONFIGURATION.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=1', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_1 . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . xtc_href_link("style.php", '', 'NONSSL') . '" class="menuBoxContentLink"> -Style</a>';

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=2', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_2 . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=3', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_3 . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=5', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_5 . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=7', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_7 . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=8', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_8 . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=12', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_12 . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="/admin/metatags.php" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_16 . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=76', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_76 . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=17', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_17 . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=18', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_18 . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=22', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_22 . '</a>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['orders_status'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_ORDERS_STATUS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ORDERS_STATUS . '</a>';
  if (ACTIVATE_SHIPPING_STATUS=='true') {
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['shipping_status'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_SHIPPING_STATUS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_SHIPPING_STATUS . '</a>';
  }
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_vpe'] == '1')) echo '<a href="' . xtc_href_link(FILENAME_PRODUCTS_VPE, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PRODUCTS_VPE . '</a>';
 

?>
</div>
