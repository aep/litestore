<?php
/* -----------------------------------------------------------------------------------------
   $Id: admin.php 1262 2005-09-30 10:00:32Z mz $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (admin.php,v 1.12 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

// reset var


class BoxAdmin extends AbstractVCBox
{
    var $classid= "{1784e3c3-0000-4000-824f-76b767236602}";
    function __construct()
    {
    }

    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {

        if(array_key_exists('customers_status',$_SESSION) && 
            (array_key_exists('customers_status_id',$_SESSION['customers_status'])) &&
                ($_SESSION['customers_status']['customers_status_id']==='0' || $_SESSION['customers_status']['customers_status_id']===0))
        {
            $box_smarty = new smarty;
            $box_smarty->assign('tpl_path','/templates/'.CURRENT_TEMPLATE.'/');
            $box_smarty->assign('language', $_SESSION['language']);
            return $box_smarty->fetch('boxes/box_admin.html');
        }
        else
        {
            return '';
        }
    }
    function metatype()
    {
        return "restore/box";
    }
}
?>
