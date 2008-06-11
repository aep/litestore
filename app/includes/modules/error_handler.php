<?php
/* -----------------------------------------------------------------------------------------
   $Id: error_handler.php 949 2005-05-14 16:44:33Z hhgag $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

    $module_smarty= new Smarty;
    $module_smarty->assign('tpl_path','/templates/'.CURRENT_TEMPLATE.'/');
    $module_smarty->assign('language', $_SESSION['language']);
    $module_smarty->assign('ERROR',$error);
    $module_smarty->caching = 0;
    $module= $module_smarty->fetch(CURRENT_TEMPLATE.'/module/error_message.html');
    $product_info=$module;
?>