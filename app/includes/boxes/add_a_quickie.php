<?php

class BoxAddAQuickie extends AbstractVCBox
{
    var $classid= "{1784e3c3-0000-4000-824f-76b767236601}";
    function __construct()
    {
    }

    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        global $_SESSION;
        if ($_SESSION['customers_status']['customers_status_show_price']=='0')
            return;

        global $PHP_SELF;
        $box_smarty = new smarty;
        $box_content='';
        $box_smarty->assign('tpl_path','/templates/'.CURRENT_TEMPLATE.'/');
        $box_smarty->assign('FORM_ACTION','<form id="quick_add" method="post" action="' . xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array('action')) . 'action=add_a_quickie', 'NONSSL') . '">');
        $box_smarty->assign('INPUT_FIELD',xtc_draw_input_field('quickie','','size="20"'));
        $box_smarty->assign('SUBMIT_BUTTON',xtc_image_submit('button_add_quick.gif', BOX_HEADING_ADD_PRODUCT_ID));
        $box_smarty->assign('FORM_END','</form>');
        $box_smarty->assign('BOX_CONTENT', $box_content);
        $box_smarty->assign('language', $_SESSION['language']);
        $box_smarty->caching = 0;
        return $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_add_a_quickie.html');
    }
    function metatype()
    {
        return "restore/box";
    }
}

?>