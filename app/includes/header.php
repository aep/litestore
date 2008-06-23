<?php
/* -----------------------------------------------------------------------------------------
   $Id: header.php 1140 2005-08-10 10:16:00Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce 
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(header.php,v 1.40 2003/03/14); www.oscommerce.com 
   (c) 2003	 nextcommerce (header.php,v 1.13 2003/08/17); www.nextcommerce.org 

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include(DIR_WS_MODULES.FILENAME_METATAGS);
require('javascript/general.js.php');

$smarty->assign("CHARSET",$_SESSION['language_charset']);
$smarty->assign("HTML_PARAMS",HTML_PARAMS );


header("Content-Type","text/html; charset="+$_SESSION['language_charset']);


require_once('inc/xtc_output_warning.inc.php');
require_once('inc/xtc_parse_input_field_data.inc.php');

  // check if the 'install' directory exists, and warn of its existence
  if (WARN_INSTALL_EXISTENCE == 'true') {
    if (file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/xtc_installer')) {
      xtc_output_warning(WARNING_INSTALL_DIRECTORY_EXISTS);
    }
  }

  // check if the configure.php file is writeable
  if (WARN_CONFIG_WRITEABLE == 'true') {
    if ( (file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/includes/configure.php')) && (is_writeable(dirname($_SERVER['SCRIPT_FILENAME']) . '/includes/configure.php')) ) {
      xtc_output_warning(WARNING_CONFIG_FILE_WRITEABLE);
    }
  }

  // check if the session folder is writeable
  if (WARN_SESSION_DIRECTORY_NOT_WRITEABLE == 'true') {
    if (STORE_SESSIONS == '') {
      if (!is_dir(xtc_session_save_path())) {
        xtc_output_warning(WARNING_SESSION_DIRECTORY_NON_EXISTENT);
      } elseif (!is_writeable(xtc_session_save_path())) {
        xtc_output_warning(WARNING_SESSION_DIRECTORY_NOT_WRITEABLE);
      }
    }
  }

  // check session.auto_start is disabled
  if ( (function_exists('ini_get')) && (WARN_SESSION_AUTO_START == 'true') ) {
    if (ini_get('session.auto_start') == '1') {
      xtc_output_warning(WARNING_SESSION_AUTO_START);
    }
  }

  if ( (WARN_DOWNLOAD_DIRECTORY_NOT_READABLE == 'true') && (DOWNLOAD_ENABLED == 'true') ) {
    if (!is_dir(DIR_FS_DOWNLOAD)) {
      xtc_output_warning(WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT);
    }
  }


$smarty->assign('navtrail',$breadcrumb->trail(' &raquo; '));
if (isset($_SESSION['customer_id'])) 
{
    $smarty->assign('customer_id',true);
}
if ( $_SESSION['account_type']=='0')
{
    $smarty->assign('account',true);
}
$smarty->assign('store_name',TITLE);

if (isset($_GET['error_message']) && xtc_not_null($_GET['error_message'])) 
{
    $smarty->assign('error',htmlspecialchars(urldecode($_GET['error_message'])));
}

if (isset($_GET['info_message']) && xtc_not_null($_GET['info_message'])) 
{
    $smarty->assign('error',htmlspecialchars(urldecode($_GET['info_message'])));
}

?>
