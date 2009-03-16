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
        

        global $azrael;


        $links=array();
        
        foreach( $azrael->listGenerators($azrael->presets['Contentbox']) as $node)
        {
            $links[]=array('name'=>$node->name(),
                'url'=>"/content/".$node->Id."/".rawurlencode(str_replace(' ','-',$node->name())));
        }
        
        if(count($links))
            $box_smarty->assign('BOX_CONTENT', $links);
        
        
        return $box_smarty->fetch('boxes/box_content.html');
    }
}
?>
