<?php

class BoxContent extends AbstractVCBox
{
    var $classid= "{1784e3c3-0000-4000-824f-76b767236604}";
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
        $box_smarty->assign('language', $_SESSION['language']);
        $box_smarty->caching = 0;
        $box_smarty->assign('tpl_path', '/templates/'.CURRENT_TEMPLATE.'/');
        
        if (GROUP_CHECK == 'true') 
        {
            $group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
        }
        
        $content_query = "SELECT
            content_id,
            categories_id,
            parent_id,
            content_title,
            content_group
            FROM ".TABLE_CONTENT_MANAGER."
            WHERE languages_id='".(int) $_SESSION['languages_id']."'
            and file_flag=1 ".$group_check." and content_status=1 order by sort_order";
        
        $content_query = xtDBquery($content_query);
        
        
        $links=array();
        
        while ($content_data = xtc_db_fetch_array($content_query, true)) 
        {
            $links[]=array('name'=>$content_data['content_title'],
                'url'=>"/content/".$content_data['content_group']."/".rawurlencode($content_data['content_title']));
        }
        
        if(count($links))
            $box_smarty->assign('BOX_CONTENT', $links);
        
        
        return $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_content.html');
    }
}
?>