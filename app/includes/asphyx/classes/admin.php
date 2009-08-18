<?php


asphyx_regme("com.handelsweise.litestore.sidebar.adminbox","BoxAdmin");
class BoxAdmin extends A2YObject
{
    var $classid= "com.handelsweise.litestore.sidebar.adminbox";
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
