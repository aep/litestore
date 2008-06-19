<?php

class BoxCategories extends AbstractVCBox
{
    var $classid= "{1784e3c3-0000-4000-824f-76b767236603}";
    function __construct()
    {
    }

    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        global $cPath;
        $box_smarty  = new smarty;
        $box_smarty->caching = 0;
        
        
        $box_smarty->assign('language', $_SESSION['language']);
        
        
        $box_smarty->assign('tpl_path', '/templates/'.CURRENT_TEMPLATE.'/');
        require_once (DIR_FS_INC.'xtc_has_category_subcategories.inc.php');
        require_once (DIR_FS_INC.'xtc_count_products_in_category.inc.php');
        
        
        
        $categories_string = '';
        $categories_query = xtDBquery("select c.categories_id,
            cd.categories_name,
            c.parent_id from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
            where c.categories_status = '1'
            ".$group_check."
            and c.categories_id = cd.categories_id
            and cd.languages_id='".(int) $_SESSION['languages_id']."'
            order by sort_order, cd.categories_name");

        $m_tt=array();
        
        while ($categories = xtc_db_fetch_array($categories_query, true))
        {
            $m_tt[$categories['categories_id']] =array (
                    'name' => $categories['categories_name'],
                    'parent' => $categories['parent_id'],
                    'id' => $categories['categories_id']);
        }
        if ($cPath)
        {
            foreach(split('_', $cPath) as $id)
            {
                $m_tt[$id]['active']='true';
            }
        }


        $m_tt[0]=array('name'=>'root');

        for($ic=0;$ic<count($m_tt);$ic++)
        {
            foreach($m_tt as $bt )
            {
                if($bt['id']==0)
                    continue;
                $m_tt[$bt['parent']]['children'][$bt['id']]=$bt;
            }
        }

        $box_smarty->assign('BOX_CONTENT', $m_tt[0]);
        return $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_categories.html');
    }
    function metatype()
    {
        return "restore/box";
    }
}
?>