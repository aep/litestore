<?php

/* -----------------------------------------------------------------------------------------
   $Id: search.php 1262 2005-09-30 10:00:32Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(search.php,v 1.22 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (search.php,v 1.9 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


class BoxSearch extends AbstractVCBox
{
    var $classid= "{1784e3c3-0000-4000-824f-76b767236620}";
    function __construct()
    {
    }

    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        $box_smarty = new smarty;
        $box_smarty->assign('tpl_path', '/templates/'.CURRENT_TEMPLATE.'/');
        $box_content = '';

        require_once (DIR_FS_INC.'xtc_hide_session_id.inc.php');
        
        $box_smarty->assign('language', $_SESSION['language']);
        // set cache ID        $box_smarty->caching = 0;
        $box_search = $box_smarty->fetch('boxes/box_search.html');
        
        return $box_search;
    }
}
?>
