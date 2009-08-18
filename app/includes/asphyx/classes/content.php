<?php

asphyx_regme("com.handelsweise.litestore.sidebar.content","BoxContent");
class BoxContent extends A2YObject
{
    var $classid= "com.handelsweise.litestore.sidebar.content";
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
