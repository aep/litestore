<?php

asphyx_regme("com.handelsweise.litestore.sidebar.search","BoxSearch");
class BoxSearch extends A2YObject
{
    var $classid= "com.handelsweise.litestore.sidebar.search";
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
