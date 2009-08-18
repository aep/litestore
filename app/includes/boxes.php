<?php

    require_once (DIR_WS_INCLUDES.'/asphyx/core.php');

    $smarty->assign("banner",$azrael->renderPreset('Banner'));
    $smarty->assign("sidebar",$azrael->renderPreset('Sidebar'));

    $t=new BoxShoppingCart();
    $smarty->assign("cart",$t->evaluate());
?>
